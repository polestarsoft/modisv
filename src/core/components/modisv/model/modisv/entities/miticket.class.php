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
 * Represents a ticket.
 *
 * @package modisv
 */
class miTicket extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function save($cacheFlag = null) {
        $this->set('updatedon', time());
        if ($this->isNew()) {
            $this->set('createdon', time());
            $this->set('lastmessageon', time());
            miUtilities::setGuid($this);
        }

        return parent::save($cacheFlag);
    }

    public function close() {
        if ($this->get('status') == 'closed') {
            return false;
        }
        $this->set('status', 'closed');
        $this->set('closedon', time());
        return $this->save();
    }

    public function reopen() {
        if ($this->get('status') == 'open') {
            return false;
        }
        $this->set('status', 'open');
        $this->set('reopenedon', time());
        return $this->save();
    }

    public function addWatcher($email) {
        $watchers = $this->get('watchers');
        if (!empty($watchers))
            $watchers .= ',';
        $watchers .= $email;
        $this->set('watchers', $watchers);
        return $this->save();
    }

    public function getUrl($includeEmail = true) {
        global $modx;
        $xhtmlUrlSetting = $modx->config['xhtml_urls'];
        $modx->config['xhtml_urls'] = false;            // disable xhtml_urls temporarily
        if ($includeEmail) {
            $url = $modx->makeUrl($modx->getOption('modisv.view_ticket_page'), '', array('guid' => strtolower($this->get('guid')), 'email' => $this->get('author_email')), 'full');
            $url = str_replace('%40', '@', $url);   // replace %40 back to @
        } else {
            $url = $modx->makeUrl($modx->getOption('modisv.view_ticket_page'), '', array('guid' => strtolower($this->get('guid'))), 'full');
        }
        $modx->config['xhtml_urls'] = $xhtmlUrlSetting; // restore xhtml_urls
        return $url;
    }

}