<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();
$session = new miTicketSession();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miNewTicket');
$successTpl = $modx->getOption('successTpl', $scriptProperties, 'miNewTicketSuccess');

if (!empty($_POST)) {
    $errors = array();

    // validate the input
    if (empty($_POST['email']))
        $errors['email'] = 'Please enter your email.';
    else if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $_POST['email']))
        $errors['email'] = 'Sorry, the email address is not valid.';
    if (empty($_POST['body']))
        $errors['body'] = 'Please enter the message.';
    else if (strlen($_POST['body']) < 10)
        $errors['body'] = 'Message too short.';

    // validate the captcha
    $v = $modx->runSnippet('miCaptchaValidate', array('answer' => $_POST['captcha'], 'id' => $_POST['captcha_id'], 'skipMember' => true));
    if ($v != 'success')
        $errors['captcha'] = $v;

    // validate upload
    if (count($_FILES) > $modx->getOption('modisv.upload_max_files', null, 10))
        $errors['files'] = 'Too many upload files.';
    else if (array_reduce($_FILES, create_function('$s,$f', 'return $s + $f["size"];')) > $modx->getOption('modisv.upload_max_size', null, 4194304))
        $errors['files'] = 'Upload exceeds the maximum allowed size.';

    if (empty($errors)) { // no error
        // create new ticket
        $properties = array();
        $properties['subject'] = $_POST['subject'];
        $properties['body'] = $_POST['body'];
        $properties['author_name'] = $_POST['name'];
        $properties['author_email'] = $_POST['email'];
        $properties['source'] = 'web';
        $properties['ip'] = $_SERVER['REMOTE_ADDR'];
        $properties['status'] = 'open';
        $properties['files'] = $_FILES;
        $ticket = $modx->newObject('miTicket');
        if (!$ticket->createNew($properties)) {
            return "Sorry, an internal error occured. Please contact {$modx->getOption('modisv.support_email')} for help.";
        }

        // store info in session
        $session->storeUserInfo($ticket->get('author_name'), $ticket->get('author_email'));

        // return success message
        $phs = $ticket->toArraySanitized();
        return $modisv->getChunk($successTpl, $phs);
    } else {
        $phs = $_POST;
        foreach ($errors as $k => $v) {
            $phs['error.' . $k] = $v;
        }
    }
}

if (empty($phs)) {
    $phs = array();
    $phs['name'] = $session->name;
    $phs['email'] = $session->email;
}
return $modisv->getChunk($tpl, $phs);


