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
 * Downloads a file.
 *
 * @package modisv
 * @subpackage controllers
 */
$path = trim($_REQUEST['path']);
$name = trim($_REQUEST['name']);
if (empty($path))
    return '<p style="padding:30px;">Invalid file path.</p>';

if (strpos($path, 'assets/') !== 0)
    return '<p style="padding:30px;">Only files under assets directory can be downloaded.</p>';

if (!file_exists(MODX_BASE_PATH . $path))
    return '<p style="padding:30px;">File not exists.</p>';

return miUtilities::sendDownload($path, $name);