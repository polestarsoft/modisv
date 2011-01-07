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
 * Add snippets to build
 * 
 * @package modisv
 * @subpackage build
 */
$plugins = array();

$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->fromArray(array(
    'id' => 0,
    'name' => 'miUserCleaner',
    'description' => 'Handles removal of orders & licenses if a User is deleted.',
    'plugincode' => getSnippetContent($sources['source_core'] . '/elements/plugins/plugin.miusercleaner.php'),
), '', true, true);
$events = array();
$events['OnUserRemove'] = $modx->newObject('modPluginEvent');
$events['OnUserRemove']->fromArray(array(
    'event' => 'OnUserRemove',
    'priority' => 0,
    'propertyset' => 0,
), '', true, true);
$plugins[0]->addMany($events);
unset($events);

return $plugins;