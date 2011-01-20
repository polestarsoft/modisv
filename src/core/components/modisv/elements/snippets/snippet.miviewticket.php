<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();
$session = new miTicketSession();

// get the ticket
$ticket = $modx->getObject('miTicket', array('guid' => strtoupper($_REQUEST['guid'])));
if (!$ticket)
    $modx->sendErrorPage();

// check permission
if (!$session->canRead($ticket) || (!empty($_POST) && !$session->canWrite($ticket)))
    $modx->sendUnauthorizedPage();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miViewTicket');
$messageTpl = $modx->getOption('messageTpl', $scriptProperties, 'miMessage');
$attachmentTpl = $modx->getOption('attachmentTpl', $scriptProperties, 'miAttachment');

// attachment download
if (!empty($_GET['file'])) {
    $attachment = $modx->getObject('miAttachment', array('id' => $_GET['file'], 'ticket' => $ticket->get('id')));
    if (!$attachment)
        $modx->sendErrorPage();
    miUtilities::sendDownload($attachment->get('path'), $attachment->get('name'));    // this will terminate the execution
}

$errors = array();
if (!empty($_POST)) { // post reply
    // check ticket status
    if ($ticket->get('status') != 'open')
        return 'Ticket already closed.';

    // check input
    if (empty($_POST['body']))
        $errors['body'] = 'Please enter the message.';
    else if (strlen($_POST['body']) < 20)
        $errors['body'] = 'Message too short.';

    // check upload
    if (count($_FILES) > $modx->getOption('modisv.upload_max_files', null, 10))
        $errors['file'] = 'Too many upload files.';
    else if (array_reduce($_FILES, create_function('$s,$f', 'return $s + $f["size"];')) > $modx->getOption('modisv.upload_max_size', null, 4194304))
        $errors['file'] = 'Upload exceeds the maximum allowed size.';

    if (empty($errors)) { // no error
        // reply
        $properties = array();
        $properties['body'] = $_POST['body'];
        $properties['author_name'] = $session->name;
        $properties['author_email'] = $session->email;
        $properties['staff_response'] = false;
        $properties['source'] = 'web';
        $properties['ip'] = $_SERVER['REMOTE_ADDR'];
        $properties['files'] = $_FILES;
        if (!$ticket->reply($properties)) {
            return "Sorry, an internal error occured. Please contact {$modx->getOption('modisv.support_email')} for help.";
        }

        // redirect back to this page
        $modx->sendRedirect($modx->makeUrl($modx->resource->get('id'), '', array('guid' => $ticket->get('guid'))));
    }
}

// get message wrapper
$wrapperMessages = '';
$i = 0;
foreach ($ticket->getMessages() as $message) {
    // get attachments wrapper
    $wrapperAttachments = '';
    foreach ($message->getMany('Attachments') as $att) {
        $phs = $att->toArray();
        $wrapperAttachments .= $modisv->getChunk($attachmentTpl, $phs);
    }

    $phs = $message->toArraySanitized();
    $phs['classes'] = $message->get('staff_response') ? 'staff' : '';
    $phs['number'] = ++$i;
    $phs['gravatar_url'] = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($message->get('author_email'))));
    $phs['attachments'] = $wrapperAttachments;
    $wrapperMessages .= $modisv->getChunk($messageTpl, $phs);
}

// output
$phs = $ticket->toArraySanitized();
$phs['messages'] = $wrapperMessages;
$phs = array_merge($phs, $_POST);
foreach ($errors as $k => $v) {
    $phs['error.' . $k] = $v;
}
return $modisv->getChunk($tpl, $phs);
