<?php
/**
 * DokuWiki Plugin socialshareprivacy (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Frank Schiebel <frank@linuxmuster.net>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'syntax.php';

class syntax_plugin_socialshareprivacy extends DokuWiki_Syntax_Plugin {
    public function getType() {
        return 'substition';
    }

    public function getPType() {
        return 'block';
    }

    public function getSort() {
        return 222;
    }


    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{socialshareprivacy\}\}',$mode,'plugin_socialshareprivacy');
        $this->Lexer->addSpecialPattern('\{\{socialshareprivacy>.+?\}\}',$mode,'plugin_socialshareprivacy');
    }

    public function handle($match, $state, $pos, &$handler){

        $match = substr($match, 2, -2);
        $pos = strrpos($match, ">");
        if ( $pos === false ) {
            $type = "socialshareprivacy";
            $params = array();
            return array($type, $params);
        } else {
            list($type, $options) = split('>', $match, 2);
        }

        // load default config options
        //$flags = $this->getConf('defaults').'&'.$flags;

        $options = split('&', $options);

        foreach($options as $option) {
            list($name, $value) = split('=', $option);
            $params[trim($name)] = trim($value);
        }

    return array($type, $params);

    }

    public function render($mode, &$renderer, $data) {
        if($mode != 'xhtml') return false;

        $renderer->doc .= '<div id="socialshareprivacy"></div>'. DOKU_LF;
        return true;
    }
}

// vim:ts=4:sw=4:et:
