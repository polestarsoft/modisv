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
 * Adds a ticket watcher.
 *
 * @package modisv
 * @subpackage processors
 */
$ticket = $modx->getObject('miTicket', $scriptProperties['id']);
if ($ticket == null)
    return $modx->error->failure('Ticket not specified or not exists.');

if (!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $scriptProperties['email']))
    $modx->error->addField('email', 'Invalid watcher email.');
if (!preg_match('/^[\w\s\.]*$/', $scriptProperties['fullname']))
    $modx->error->addField('fullname', 'Invalid watcher full name.');
if($modx->error->hasError())
    return $modx->error->failure();

if (!$ticket->addWatcher($scriptProperties['email'], $scriptProperties['fullname'])) {
    return $modx->error->failure('An error occurred while trying to add the watcher.');
}

return $modx->error->success('', $ticket);
