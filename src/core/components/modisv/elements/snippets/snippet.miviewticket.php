<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get the ticket
$guid = trim($_GET['guid']);
$ticket = $modx->getObject('miTicket', array('guid' => $guid));
if (!$ticket) {
    $modx->sendErrorPage();
}

// get user email
$email = trim($_GET['email']);
$user = $modx->user;
if (empty($email) && $user->isAuthenticated($modx->context->get('key'))) {
    $email = $user->get('username');
}

// get privileges
$canRead = false;
$canWrite = false;
if ($user->isMember('Administrator')) {   // admin   //TODO: this should be configed
    $canRead = true;
} else if ($email == $ticket->get('author_email')) { // author
    $canRead = $canWrite = true;
} else {
    $watchers = explode(',', $ticket->get('watchers'));
    if (in_array($email, $watchers)) {
        $canRead = true;
    }
}

// check permission
if (!$canRead) {
    $modx->sendUnauthorizedPage();
}

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miViewTicket');
$messageTpl = $modx->getOption('messageTpl', $scriptProperties, 'miMessage');
$attachmentTpl = $modx->getOption('attachmentTpl', $scriptProperties, 'miAttachment');
$maxUploadFiles = $modx->getOption('maxUploadFiles', $scriptProperties, '10');
$maxUploadSize = $modx->getOption('maxUploadFileSize', $scriptProperties, '4194304');   //4M

// attachment download
if (!empty($_GET['file'])) {
    $attachment = $modx->getObject('miAttachment', array('id' => $_GET['file'], 'ticket' => $ticket->get('id')));
    if (!$attachment) {
        $modx->sendErrorPage();
    }
    miUtilities::sendDownload($attachment->get('path'), $attachment->get('name'));    // this will terminate the execution
}

$errors = array();
if (!empty($_POST)) { // post reply
    if (!$canWrite) {
        $modx->sendUnauthorizedPage();
    }

    // check ticket status
    if ($ticket->get('status') != 'open') {
        return 'Ticket already closed.';
    }

    // check input
    if (empty($_POST['body']))
        $errors['body'] = 'Please enter the message.';
    else if (strlen($_POST['body']) < 20)
        $errors['body'] = 'Message too short.';

    // check upload
    if (count($_FILES) > $maxUploadFiles)
        $errors['file'] = 'Too many upload files.';
    else if (array_reduce($_FILES, create_function('$s,$f', 'return $s + $f["size"];')) > $maxUploadSize)
        $errors['file'] = 'Upload exceeds the maximum allowed size.';

    if (empty($errors)) { // no error
        // create message
        $message = $modx->newObject('miMessage');
        $message->set('body', $_POST['body']);
        $message->set('ticket', $ticket->get('id'));
        $message->set('author_name', $ticket->get('author_name'));
        $message->set('author_email', $ticket->get('author_email'));
        $message->set('source', 'web');
        $message->set('ip', $_SERVER['REMOTE_ADDR']);
        if (!$message->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[miViewTicket] An error occurred while trying to save the reply message:" . print_r($message->toArray(), true));
            return "Sorry, an internal error occured. Please contact {$modx->get('modisv.support_email')} for help.";
        }

        // create attachments
        foreach ($_FILES as $file) {
            if ($file['error'] != 0)
                continue;
            if (empty($file['name']))
                continue;

            // create attachment
            $attachment = $modx->newObject('miAttachment');
            if (!$attachment->fromFile($file['tmp_name'], $message, $file['name'])) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[miViewTicket] An error occurred while trying to create the attachment '{$file['name']}'.");
                return "Sorry, an internal error occured. Please contact {$modx->get('modisv.support_email')} for help.";
            }
            if (!$attachment->save()) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[miViewTicket] An error occurred while trying to save the attachment '{$file['name']}'.");
                return "Sorry, an internal error occured. Please contact {$modx->get('modisv.support_email')} for help.";
            }
        }

        // save the ticket
        $ticket->set('lastresponseon', time());
        if (!$ticket->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[miViewTicket] An error occurred while trying to save the ticket #{$ticket->get('id')}.");
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
                            sprintf('New Message Received (Ticket: #%s)', $ticket->get('guid')),
                            $modx->modisv->getChunk('miNewMessageNotification', $phs));
            if (!$sent)
                $modx->log(modX::LOG_LEVEL_ERROR, "[miViewTicket] An error occurred while trying to send new message notification to staffs.");
            
            $_POST = array();   // don't send those values back to client
        }
    }
}

// get message wrapper
$c = $modx->newQuery('miMessage');
$c->where(array('ticket' => $ticket->get('id')));
$c->sortby('id');
$messages = $modx->getCollection('miMessage', $c);
$wrapperMessages = '';
$i = 0;
foreach ($messages as $message) {
    // get attachments wrapper
    $wrapperAttachments = '';
    foreach ($message->getMany('Attachments') as $att) {
        $phs = $att->toArray();
        $phs['url'] = $att->getUrl(false);
        $wrapperAttachments .= $modisv->getChunk($attachmentTpl, $phs);
    }

    $phs = $message->toArray();
    $phs['html'] = $message->getHtmlBody();
    $phs['classes'] = $message->get('staff_response') ? 'staff' : '';
    $phs['number'] = ++$i;
    $phs['gravatar_url'] = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($message->get('author_email'))));
    $phs['attachments'] = $wrapperAttachments;
    $wrapperMessages .= $modisv->getChunk($messageTpl, $phs);
}

$phs = $ticket->toArray();
$phs['messages'] = $wrapperMessages;
$phs = array_merge($phs, $_POST);
foreach ($errors as $k => $v) {
    $phs['error.' . $k] = $v;
}
return $modisv->getChunk($tpl, $phs);
