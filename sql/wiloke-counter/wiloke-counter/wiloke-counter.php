<?php

/**
* Tested up to:        5.6.2
* Domain Path:         /languages
* Text Domain:         wiloke-counter
* License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
* License:             GPL-2.0+
* Author URI:          https://wiloke.com
* Author:              wiloke
* Version:             1.0.23
* Description:         Wiloke Counter for Elementor
* Plugin URI:          https://wiloke.com
* Plugin Name:         Wiloke Counter
*/

use WilokeCounter\Controllers\Notification\NotificationController;
use WilokeCounter\Controllers\TaxonomyFeaturedImage\TaxonomyFeaturedImageController;
global $wilokeEnabledTaxonomyFeaturedImage;
define("WILOKE_WILOKECOUNTER_VERSION",
  defined('WP_DEBUG') && WP_DEBUG ? uniqid() : '1.0.23');
define("WILOKE_WILOKECOUNTER_NAMESPACE", "wiloke-counter");
define("WILOKE_WILOKECOUNTER_PREFIX", "wiloke-counter_");
define("WILOKE_WILOKECOUNTER_VIEWS_PATH", plugin_dir_path(__FILE__));
define("WILOKE_WILOKECOUNTER_VIEWS_URL", plugin_dir_url(__FILE__));

add_action("plugins_loaded", "WilokeCounterLoadPluginDomain");
if (!function_exists("WilokeCounterLoadPluginDomain")) {
  function WilokeCounterLoadPluginDomain()
  {
    load_plugin_textdomain("wiloke-counter", false,
      plugin_dir_path(__FILE__) . "languages");
  }
}

require_once plugin_dir_path(__FILE__) . "vendor/autoload.php";

new \WilokeCounter\Controllers\RegistrationController();
new \WilokeCounter\Controllers\HandleAjaxController();
new TaxonomyFeaturedImageController();
new NotificationController();