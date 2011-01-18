<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miNewTicket');
$successTpl = $modx->getOption('successTpl', $scriptProperties, 'miNewTicketSuccess');

if (!empty($_POST)) {
    // validate
    $errors = array();
    if (empty($_POST['email']))
        $errors['email'] = 'Please enter your email.';
    else if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $_POST['email']))
        $errors['email'] = 'Sorry, the email address is not valid.';
    if (empty($_POST['body']))
        $errors['body'] = 'Please enter the message.';
    else if (strlen($_POST['body']) < 20)
        $errors['body'] = 'Message too short.';

    // validate the captcha
    $v = $modx->runSnippet('miCaptchaValidate', array('answer' => $_POST['captcha'], 'id' => $_POST['captcha_id'], 'skipMember' => true));
    if ($v != 'success')
        $errors['captcha'] = $v;

    if (empty($errors)) {
        // create the ticket
        $ticket = $modx->newObject('miTicket');
        $ticket->set('subject', $_POST['subject'] ? : '[no subject]');
        $ticket->set('author_name', $_POST['name']);
        $ticket->set('author_email', $_POST['email']);
        $ticket->set('status', 'open');
        $ticket->set('source', 'web');
        $ticket->set('ip', $_SERVER['REMOTE_ADDR']);

        if (!$ticket->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[miNewTicket] An error occurred while trying to save the ticket:" . print_r($ticket->toArray(), true));
            return "Sorry, an internal error occured. Please contact {$modx->get('modisv.support_email')} for help.";
        }

        // create message
        $message = $modx->newObject('miMessage');
        $message->set('body', $_POST['body']);
        $message->set('author_name', $_POST['name']);
        $message->set('author_email', $_POST['email']);
        $message->set('source', 'web');
        $message->set('ip', $_SERVER['REMOTE_ADDR']);
        $message->set('ticket', $ticket->get('id'));

        // save the message
        if (!$message->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[miNewTicket] An error occurred while trying to save the message:" . print_r($message->toArray(), true));
            return "Sorry, an internal error occured. Please contact {$modx->get('modisv.support_email')} for help.";
        }

        // send notification to watchers
        $phs = $ticket->toArray('ticket.');
        $phs = array_merge($phs, $message->toArray('message.'));
        $phs['ticket.url'] = $ticket->getUrl(false);
        $staffs = $modx->getOption('modisv.ticket_notification_emails');
        if (!empty($staffs)) {
            $sent = $modisv->sendEmail(
                            $staffs,
                            sprintf('New Ticket Created (Ticket: #%s)', $ticket->get('guid')),
                            $modx->modisv->getChunk('miNewTicketNotification', $phs));
            if (!$sent)
                $modx->log(modX::LOG_LEVEL_ERROR, "[miNewTicket] An error occurred while trying to send new ticket notification to staffs.");
        }

        $phs = $ticket->toArray();
        $phs['url'] = $ticket->getUrl(true);
        return $modisv->getChunk($successTpl, $phs);
    }

    $phs = $_POST;
    foreach ($errors as $k => $v) {
        $phs['error.' . $k] = $v;
    }
}

if (empty($phs)) {
    $phs = array();
    if($modx->user && $modx->user->isAuthenticated($modx->context->get('key'))) {
        $phs['author_name'] = $modx->user->getOne('Profile')->get('fullname');
        $phs['author_email'] = $modx->user->get('username');
    }
}
return $modisv->getChunk($tpl, $phs);

