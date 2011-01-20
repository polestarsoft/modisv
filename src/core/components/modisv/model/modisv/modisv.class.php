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
 * The base class for modISV.
 *
 * @package modisv
 */
class modISV {

    function __construct(modX &$modx, array $config = array()) {
        $this->modx = & $modx;

        $corePath = $this->modx->getOption('modisv.core_path', $config, $this->modx->getOption('core_path') . 'components/modisv/');
        $assetsUrl = $this->modx->getOption('modisv.assets_url', $config, $this->modx->getOption('assets_url') . 'components/modisv/');
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
                    'assetsUrl' => $assetsUrl,
                    'cssUrl' => $assetsUrl . 'css/',
                    'jsUrl' => $assetsUrl . 'js/',
                    'imagesUrl' => $assetsUrl . 'images/',
                    'connectorUrl' => $connectorUrl,
                    'corePath' => $corePath,
                    'modelPath' => $corePath . 'model/',
                    'chunksPath' => $corePath . 'elements/chunks/',
                    'chunkSuffix' => '.chunk.tpl',
                    'snippetsPath' => $corePath . 'elements/snippets/',
                    'processorsPath' => $corePath . 'processors/',
                        ), $config);

        $this->modx->addPackage('modisv.entities', $this->config['modelPath']);
        $this->modx->addPackage('modisv.rules', $this->config['modelPath']); // load validators
        $this->modx->lexicon->load('modisv:default');
    }

    /**
     * Initializes modISV into different contexts.
     *
     * @access public
     * @param string $ctx The context to load. Defaults to web.
     */
    public function initialize($ctx = 'web') {

        $this->modx->loadClass('modisv.miUser', $this->config['modelPath'], true, true);
        $this->modx->loadClass('modisv.miUtilities', $this->config['modelPath'], true, true);
        $this->modx->loadClass('modisv.miOrderFulfiller', $this->config['modelPath'], true, true);
        $this->modx->loadClass('modisv.miOrderMessageBuilder', $this->config['modelPath'], true, true);
        $this->modx->loadClass('modisv.miPaypal', $this->config['modelPath'], true, true);
        $this->modx->loadClass('modisv.miTicketSession', $this->config['modelPath'], true, true);

        switch ($ctx) {
            case 'mgr':
                if (!$this->modx->loadClass('modisv.request.modISVControllerRequest', $this->config['modelPath'], true, true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new modISVControllerRequest($this);
                return $this->request->handleRequest();
                break;
            default:
                /* if you wanted to do any generic frontend stuff here.
                 * For example, if you have a lot of snippets but common code
                 * in them all at the beginning, you could put it here and just
                 * call $modisv->initialize($modx->context->get('key'));
                 * which would run this.
                 */
                break;
        }
    }

    /**
     * Sends an email.
     *
     * @access public
     * @param string $to The email address of the recipient.
     * @param string $subject The subject of the email.
     * @param string $body The subject of the email.
     * @param string $from The address of the sender.
     * @param boolean $html HTML message or not.
     * @return boolean Whehther the email was sent sucessfully.
     */
    public function sendEmail($to, $subject, $body, $from = null, $html = false) {
        return miUtilities::sendEmail($to, $subject, $body, $from, $html);
    }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk, or @CODE binding.
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name, array $properties = null) {
        $chunk = null;
        if (substr($name, 0, 6) == "@CODE:") {
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent(substr($name, 6));
        } else if (!isset($this->chunks[$name])) {
            $chunk = $this->modx->getObject('modChunk', array('name' => $name), true);
            if (empty($chunk)) {
                $chunk = $this->_getTplChunk($name, $this->config['chunkSuffix']);
                if ($chunk == false)
                    return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);

        return $chunk->process($properties);
    }

    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.chunk.tpl by default.
     * @param string $suffix The suffix to add to the chunk filename.
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name, $suffix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->config['chunksPath'] . strtolower($name) . $suffix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name', $name);
            $chunk->setContent($o);
        }
        return $chunk;
    }

    public function shoppingCart() {
        if (!isset($this->shoppingCart)) {
            $this->modx->loadClass('modisv.miShoppingCart', $this->config['modelPath'], true, true);
            $this->shoppingCart = new miShoppingCart();
        }
        return $this->shoppingCart;
    }

}