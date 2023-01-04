<?php

namespace WilokeCounter\Controllers;


use Elementor\Controls_Manager;
use WilokeCounter\Controllers\CategoryPostControl\CustomCategoryPostControl;
use WilokeCounter\Controllers\SelectTaxonomyControl\SelectTaxonomyControl;
use WilokeCounter\Controllers\CategoryProductControl\CustomCategoryProductControl;
use WilokeCounter\Controllers\PostControl\CustomPostControl;
use WilokeCounter\Controllers\ProductControl\ProductControl;
use WilokeCounter\Controllers\SingleProductControl\SingleProductControl;
use WilokeCounter\Share\App;

class RegistrationController
{
  public static string $WilokeCounter = 'WilokeCounter';
  private string       $appDomain  = ".netlify.app";

  public function __construct()
  {
    $aConfigs = json_decode(file_get_contents(plugin_dir_path(__FILE__) .
      '../Configs/config.json'), true);
    App::bind('dataConfig', $aConfigs);

    $this->registerScriptKeys();
    add_action('wp_enqueue_scripts', [$this, 'registerScripts']);
    add_action('elementor/elements/categories_registered',
      [$this, 'registerCategories']);
    add_action('elementor/widgets/register', [$this, 'registerAddon']);
    add_action('elementor/controls/register', [$this, 'registerControls']);
  }

  public function registerCategories($oElementsManager)
  {
    $key = App::get('dataConfig')['category']['key'] ?? 'wiloke-category';
    if (!array_key_exists($key, $oElementsManager->get_categories())) {
      $oElementsManager->add_category(
        $key,
        [
          'title' => App::get('dataConfig')['category']['title'] ??
            esc_html__('Wiloke', 'wiloke-counter'),
          'icon'  => App::get('dataConfig')['category']['icon'] ?? 'eicon-font',
        ]
      );
    }
  }

  public function registerScriptKeys()
  {
    if (isset(App::get('dataConfig')['css'])) {
      $aHandleCss[] = WILOKE_WILOKECOUNTER_NAMESPACE .
        md5(App::get('dataConfig')['css']);
      $aHandleJs[] = WILOKE_WILOKECOUNTER_NAMESPACE .
        md5(App::get('dataConfig')['js']);
    } else {
      $aHandleCss[] = WILOKE_WILOKECOUNTER_NAMESPACE;
      $aHandleJs[] = WILOKE_WILOKECOUNTER_NAMESPACE;
    }

    App::bind('handleCss', $aHandleCss);
    App::bind('handleJs', $aHandleJs);
  }

  private function getStylesheetUrl()
  {
    if (isset(App::get('dataConfig')['css'])) {
      return App::get('dataConfig')['css'];
    }

    $domain = App::get('dataConfig')['filename'] ?? WILOKE_WILOKECOUNTER_NAMESPACE;

    return esc_url(
      "https://" . $domain . $this->appDomain . "/styles/styles.css"
    );
  }

  private function getScriptUrl()
  {
    if (isset(App::get('dataConfig')['js'])) {
      return App::get('dataConfig')['js'];
    }

    $domain = App::get('dataConfig')['filename'] ?? WILOKE_WILOKECOUNTER_NAMESPACE;

    return esc_url(
      "https://" . $domain . $this->appDomain . "/js/scripts.js",
    );
  }

  public function registerScripts()
  {
    wp_register_style(
      WILOKE_WILOKECOUNTER_NAMESPACE,
      $this->getStylesheetUrl(),
      [],
      WILOKE_WILOKECOUNTER_VERSION);

    wp_register_script(
      WILOKE_WILOKECOUNTER_NAMESPACE,
      $this->getScriptUrl(),
      ['elementor-frontend'],
      WILOKE_WILOKECOUNTER_VERSION,
      true
    );

    wp_localize_script('jquery', 'WilokeCounter', [
      'prefix'  => WILOKE_WILOKECOUNTER_NAMESPACE,
      'userID'  => get_current_user_id(),
      'ajaxUrl' => admin_url('admin-ajax.php')
    ]);
  }

  public function registerAddon($oWidgetManager)
  {
    $oWidgetManager->register(new PluginAddon());
  }

  public function registerControls(Controls_Manager $oControlManager)
  {
    
    
    
    
    
    
  }
}