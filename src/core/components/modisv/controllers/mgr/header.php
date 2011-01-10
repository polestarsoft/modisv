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
 * Loads the header for mgr pages.
 *
 * @package modisv
 * @subpackage controllers
 */
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/modisv.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/utils/vtypes.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/utils/renderers.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/utils/tooltip.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.combo.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.checkbox.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.licensetypefield.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.randomfield.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.tabs.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.grid.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.listpanel.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.updatepanel.js');
$modx->regClientStartupScript($modisv->config['jsUrl'] . 'mgr/widgets/modisv.window.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    modISV.config = ' . $modx->toJSON($modisv->config) . ';
    modISV.config.connector_url = "' . $modisv->config['connectorUrl'] . '";
    modISV.request = ' . $modx->toJSON($_GET) . ';
});
</script>');

return '';