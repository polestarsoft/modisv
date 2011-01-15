<?php

/**
 * @package modisv
 */
class miMessage extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function save($cacheFlag = null) {
        $this->set('updatedon', time());
        if ($this->isNew()) {
            $this->set('createdon', time());
        }

        return parent::save($cacheFlag);
    }

    public function getHtmlBody() {
        // get the body markdown txt
        $body = $this->get('body') ? : '';
        if (empty($body)) {
            return '';
        }

        // transform using the markdown parser
        $parserClass = $this->xpdo->loadClass('markdown.MarkdownParser', dirname(dirname(dirname(__FILE__))) . '/', true, true);
        $parser = new $parserClass();
        $html = $parser->transform($body);

        //TODO: filter unwanted tags

        return $html;
    }

}