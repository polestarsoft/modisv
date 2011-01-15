<?php

require_once dirname(dirname(dirname(__FILE__))) . '/htmlpurifier/HTMLPurifier.auto.php';

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

        // filter unwanted tags
        $config = HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
        $config->set('HTML.Allowed', 'a[href|title],img[src|width|height|alt|title],code[class],b,blockquote,del,dd,dl,dt,em,h1,h2,h3,i,kbd,li,ol,p,pre,s,sup,sub,strong,strike,ul,br,hr');
        $purifier = new HTMLPurifier($config);
        $pure_html = $purifier->purify($html);
        
        return $pure_html;
    }

}