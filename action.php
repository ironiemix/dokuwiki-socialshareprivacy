<?php
/**
 * DokuWiki Plugin socialshareprivacy (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Frank Schiebel <frank@linuxmuster.net>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'action.php';

class action_plugin_socialshareprivacy extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler &$controller) {

       $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle_tpl_metaheader_output');
   
    }

    public function handle_tpl_metaheader_output(Doku_Event &$event, $param) {

        $event->data["script"][] = array (
                "type" => "text/javascript",
                "charset" => "utf-8",
                "_data" => "",
                "src" => DOKU_BASE."lib/plugins/socialshareprivacy/jquery.socialshareprivacy.js"
                );

        $dummyImgPath = DOKU_BASE . "lib/plugins/socialshareprivacy/images/";
        $dummyFB = $dummyImgPath . "dummy_facebook.png";
        $dummyTWIT = $dummyImgPath . "dummy_twitter.png";
        $dummyGP = $dummyImgPath . "dummy_gplus.png";

        $scriptstring  = '   jQuery(document).ready(function($){ ' . DOKU_LF;
        $scriptstring .= "        if($('#socialshareprivacy').length > 0){ " .DOKU_LF;
        $scriptstring .= "           $('#socialshareprivacy').socialSharePrivacy({ ". DOKU_LF;
        $scriptstring .= "              services : { " .DOKU_LF;
        $scriptstring .= "                  facebook : { " .DOKU_LF;
        $scriptstring .= "                      'dummy_img' : '". $dummyFB  ."' " .DOKU_LF;
        $scriptstring .= "                  },  " .DOKU_LF;
        $scriptstring .= "                  twitter : { " .DOKU_LF;
        $scriptstring .= "                      'dummy_img' : '". $dummyTWIT  ."' " .DOKU_LF;
        $scriptstring .= "                  }, " .DOKU_LF;
        $scriptstring .= "                  gplus : { " .DOKU_LF;
        $scriptstring .= "                      'dummy_img' : '". $dummyGP  ."' " .DOKU_LF;
        $scriptstring .= "                  } ".DOKU_LF;
        $scriptstring .= "              }, ".DOKU_LF;
        $scriptstring .= "              'css_path' : '' ".DOKU_LF;
        $scriptstring .= '     })' .DOKU_LF;
        $scriptstring .= "    }" .DOKU_LF;
        $scriptstring .= '   });' .DOKU_LF;


        //$scriptstring .= "           $('#socialshareprivacy').socialSharePrivacy();" .DOKU_LF;
        $event->data["script"][] = array (
                "type" => "text/javascript",
                "charset" => "utf-8",
                "_data" => $scriptstring
                );

    }

}

// vim:ts=4:sw=4:et:
