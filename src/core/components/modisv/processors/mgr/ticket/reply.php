<?php

/**
 * modISV
 *
 * Copyright 2010 by Weqiang Wang <wenqiang@polestarsoft.com>
 *
 * modISV is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * modISV is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * modISV; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package modisv
 */
/**
 * Reply a ticket.
 *
 * @package modisv
 * @subpackage processors
 */
$ticket = $modx->getObject('miTicket', $scriptProperties['id']);
if ($ticket == null) {
    return $modx->error->failure('Ticket not specified or not exists.');
}

// check status
if ($ticket->get('status') != 'open') {
    return $modx->error->failure('Ticket already closed.');
}

// create message
$message = $modx->newObject('miMessage');
$message->set('body', $scriptProperties['body']);
$message->set('ticket', $ticket->get('id'));
$message->set('staff_response', true);
$message->set('author_name', $modx->user->getOne('Profile')->get('fullname'));
$message->set('author_email', $modx->user->get('username'));
$message->set('source', 'web');
$message->set('ip', $_SERVER['REMOTE_ADDR']);
if (!$message->save()) {
    return $modx->error->failure('An error occurred while trying to save the reply message.');
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
        return $modx->error->failure("An error occurred while trying to create the attachment '{$file['name']}'.");
    }
    if (!$attachment->save()) {
        return $modx->error->failure("An error occurred while trying to save the attachment '{$file['name']}'.");
    }
}

// save the ticket
$ticket->set('lastresponseon', time());
$ticket->set('answered', true);
if (!$ticket->save()) {
    return $modx->error->failure("An error occurred while trying to save the ticket.");
}

// send notification to watchers
$phs = $ticket->toArray('ticket.');
$phs = array_merge($phs, $message->toArray('message.'));
$phs['ticket.url'] = $ticket->getUrl(true);
$phs['message.attachments'] = '';
foreach ($message->getMany('Attachments') as $att) {
    $phs['message.attachments'] .= sprintf("- %s %s\n", $att->getFileName(), $att->getUrl());
}
if ($ticket->get('watchers')) {
    $sent = $modx->modisv->sendEmail(
                    $ticket->get('watchers'),
                    sprintf('RE: %s [#%s]', $ticket->get('subject'), strtoupper($ticket->get('guid'))),
                    $modx->modisv->getChunk('miTicketReplyEmail', $phs),
                    $modx->getOption('modisv.support_email')
    );
    if (!$sent) {
        return $modx->error->failure("An error occured while trying to send ticket reply email to watchers.");
    }
}

return $modx->error->success('', $message);
