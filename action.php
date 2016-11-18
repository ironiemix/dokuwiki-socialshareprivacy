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

    public function register(Doku_Event_Handler $controller) {

       $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle_tpl_metaheader_output');
    }

    public function handle_tpl_metaheader_output(Doku_Event &$event, $param) {
        global $conf;

        $options = array(
                "global_info_link",
                "global_txt_help",
                "global_settings_perma",
                "global_cookie_expires",
                "facebook_status",
                "facebook_txt_info",
                "facebook_perma_option",
                "facebook_display_name",
                "facebook_language",
                "facebook_action",
                "twitter_status",
                "twitter_txt_info",
                "twitter_perma_option",
                "twitter_display_name",
                "twitter_language",
                "gplus_status",
                "gplus_txt_info",
                "gplus_perma_option",
                "gplus_display_name",
                "gplus_language"
                );

        foreach($options as $opt) {
                $opt_value=$this->getConf("$opt");
                $parts = explode("_", $opt, 2);
                if ( $parts[1] == "status" && $opt_value == "1") { $opt_value = "on"; }
                if ( $parts[1] == "status" && $opt_value == "0") { $opt_value = "off"; }
                if ( $parts[1] == "perma_option" && $opt_value == "1") { $opt_value = "on"; }
                if ( $parts[1] == "perma_option" && $opt_value == "0") { $opt_value = "off"; }
                if ( $opt_value != "" ) {
                    $jsopt["$parts[0]"] .= "'" . $parts[1] . "' : " . "'" .$opt_value . "',";
                }
        }

        $dummyImgPath = DOKU_BASE . "lib/plugins/socialshareprivacy/images/";
        $dummyFB = $dummyImgPath . str_replace(".png", "_".$conf['lang'] . ".png", "dummy_facebook.png");
        $dummyTWIT = $dummyImgPath . "dummy_twitter.png";
        $dummyGP = $dummyImgPath . "dummy_gplus.png";

        $scriptstring  = '   jQuery(document).ready(function($){ ' . DOKU_LF;
        $scriptstring .= "        if($('#socialshareprivacy').length > 0){ " .DOKU_LF;
        $scriptstring .= "           $('#socialshareprivacy').socialSharePrivacy({ ". DOKU_LF;
        $scriptstring .= "              services : { " .DOKU_LF;
        $scriptstring .= "                  facebook : { " .DOKU_LF;
        $scriptstring .= "                     ". $jsopt["facebook"] . DOKU_LF;
        $scriptstring .= "                      'dummy_img' : '". $dummyFB  ."' " .DOKU_LF;
        $scriptstring .= "                  },  " .DOKU_LF;
        $scriptstring .= "                  twitter : { " .DOKU_LF;
        $scriptstring .= "                     ". $jsopt["twitter"] .DOKU_LF;
        $scriptstring .= "                      'dummy_img' : '". $dummyTWIT  ."' " .DOKU_LF;
        $scriptstring .= "                  }, " .DOKU_LF;
        $scriptstring .= "                  gplus : { " .DOKU_LF;
        $scriptstring .= "                     ". $jsopt["gplus"] . DOKU_LF;
        $scriptstring .= "                      'dummy_img' : '". $dummyGP  ."' " .DOKU_LF;
        $scriptstring .= "                  } ".DOKU_LF;
        $scriptstring .= "              }, ".DOKU_LF;
        $scriptstring .= "              ". $jsopt["global"];
        $scriptstring .= "              'css_path' : '' ".DOKU_LF;
        $scriptstring .= '     })' .DOKU_LF;
        $scriptstring .= "    }" .DOKU_LF;
        $scriptstring .= '   });' .DOKU_LF;

        // Output
        $event->data["script"][] = array (
                "type" => "text/javascript",
                "charset" => "utf-8",
                "_data" => "",
                "src" => DOKU_BASE."lib/plugins/socialshareprivacy/jquery.socialshareprivacy.min.js"
                );

        $event->data["script"][] = array (
                "type" => "text/javascript",
                "_data" => $scriptstring
                );

    }

}

// vim:ts=4:sw=4:et:
