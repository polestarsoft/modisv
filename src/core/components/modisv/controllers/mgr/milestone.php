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
 * Loads the update milestone page.
 *
 * @package modisv
 * @subpackage controllers
 */
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/sections/milestone/modisv.page.milestone.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/sections/milestone/modisv.panel.milestone.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/sections/tickets/modisv.grid.tickets.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/sections/tickets/modisv.window.newticket.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/sections/ticket/modisv.window.updateticket.js');


return '<div id="modisv-panel-root-div"></div>';