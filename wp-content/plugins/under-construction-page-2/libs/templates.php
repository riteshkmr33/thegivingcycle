<?php
/**
 * UCP Utility & Helper functions
 */


class UCP_templates extends UCP {
  
  // enqueue CSS and JS scripts in admin
  static function admin_enqueue_scripts($hook) {
    
    if('posts_page_ucp_editor' == $hook) {
      wp_enqueue_style( 'wp-color-picker' );
      wp_enqueue_script( 'wp-color-picker' );
      wp_enqueue_script("jquery-effects-core");
      wp_enqueue_script("jquery-ui-accordion");
      wp_enqueue_script("jquery-ui-sortable");
      wp_enqueue_script("jquery-ui-resizable");
      wp_enqueue_style('jquery-ui-smoothness', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', false, null);
      wp_enqueue_script('ucp-spectrum', UCP_PLUGIN_URL . 'js/spectrum.js', array('jquery'), UCP::$version, true);
      wp_enqueue_style('ucp-spectrum', UCP_PLUGIN_URL . 'css/spectrum.css', array(), UCP::$version);
      
      wp_enqueue_script('ucp-html2canvas', UCP_PLUGIN_URL . 'js/html2canvas.js', array('jquery'), UCP::$version, true);
      wp_enqueue_script('ucp-bootstrap', UCP_PLUGIN_URL . 'js/bootstrap.min.js', array('jquery'), UCP::$version, true);
      
      wp_enqueue_style('ucp-bootstrap', UCP_PLUGIN_URL . 'css/bootstrap.min.css', array(), UCP::$version);
       
      
      wp_enqueue_script('ucp-tooltipster', UCP_PLUGIN_URL . 'js/tooltipster.bundle.min.js', array('jquery'), UCP::$version, true);
      wp_enqueue_style('ucp-tooltipster', UCP_PLUGIN_URL . 'css/tooltipster.bundle.min.css', array(), UCP::$version);
      wp_enqueue_style('ucp-font-awesome', UCP_PLUGIN_URL . 'css/font-awesome/font-awesome.min.css', array(), UCP::$version);
      
      wp_enqueue_style('ucp-admin-editor', UCP_PLUGIN_URL . 'css/ucp-admin-editor.css', array(), UCP::$version);
      
      wp_enqueue_style('ucp-summernote', UCP_PLUGIN_URL . 'css/summernote.css', array(), UCP::$version);
      wp_enqueue_script('ucp-summernote', UCP_PLUGIN_URL . 'js/summernote.min.js', array('jquery'), UCP::$version, true);
      
      wp_register_script( 'ucp-admin-editor', UCP_PLUGIN_URL . 'js/ucp-admin-editor.js', array('jquery'), UCP::$version );
      
      $options = self::get_options();
      
      if(!empty($options['mc_api_key']) && !empty($options['mc_list'])){
        $mailchimp_status = true;
      } else {
        $mailchimp_status = false;
      }
      
      if(!empty($options['zapier_webhook_url'])){
        $zapier_status = true;
      } else {
        $zapier_status = false;
      }
      
      if(!empty($options['autoresponder_action_url'])){
        $ar_status = true;
      } else {
        $ar_status = false;
      }
      
      $ucp_editor_variables = array(
        'ucp_home_url' => get_home_url(),
        'ucp_admin_url' => admin_url(),
        'ucp_ajax_url' => admin_url( 'admin-ajax.php' ),
        'ucp_plugin_url' => UCP_PLUGIN_URL,
        'ucp_google_fonts' => self::google_fonts(),
        'ucp_captcha_html' => self::captcha_print(),
        'ucp_lc' => UCP::get_licence_type(),
        'mailchimp_status' => $mailchimp_status,
        'zapier_status' => $zapier_status,
        'ar_status' => $ar_status,
        'admin_email' => get_option('admin_email'),
      );
      wp_localize_script( 'ucp-admin-editor', 'ucp_admin_editor_variables', $ucp_editor_variables );
      wp_enqueue_script( 'ucp-admin-editor' );
      
      wp_enqueue_media();
    }

  } // admin_enqueue_scripts
  
  
  
  static function ucp_editor_clean_admin_page(){
    global $_GET;
    $_GET['noheader'] = true;
        
    global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow,
      $update_title, $total_update_count, $parent_file;
        
    if ( empty( $current_screen ) )
      set_current_screen();
    
    get_admin_page_title();
    $title = esc_html( strip_tags( $title ) );
    
    wp_user_settings();    
    _wp_admin_html_begin();
    ?>
    <title>UCP Editor</title>
    <?php
    
    wp_enqueue_style( 'colors' );
    wp_enqueue_style( 'ie' );
    wp_enqueue_script('utils');
    wp_enqueue_script( 'svg-painter' );
    
    $admin_body_class = preg_replace('/[^a-z0-9_-]+/i', '-', $hook_suffix);
    ?>
    <script type="text/javascript">
    addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
    var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>',
      pagenow = '<?php echo $current_screen->id; ?>',
      typenow = '<?php echo $current_screen->post_type; ?>',
      adminpage = '<?php echo $admin_body_class; ?>',
      thousandsSeparator = '<?php echo addslashes( $wp_locale->number_format['thousands_sep'] ); ?>',
      decimalPoint = '<?php echo addslashes( $wp_locale->number_format['decimal_point'] ); ?>',
      isRtl = <?php echo (int) is_rtl(); ?>;
    </script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <?php
        
    do_action( 'admin_enqueue_scripts', $hook_suffix );
    do_action( "admin_print_styles-{$hook_suffix}" );
    do_action( 'admin_print_styles' );
    do_action( "admin_print_scripts-{$hook_suffix}" );
    do_action( 'admin_print_scripts' );
    do_action( "admin_head-{$hook_suffix}" );
    do_action( 'admin_head' );
    
    ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
    </head>
    <?php
    
    $admin_body_classes = apply_filters( 'admin_body_class', '' );
    ?>
    <body class="wp-admin wp-core-ui no-js <?php echo $admin_body_classes . ' ' . $admin_body_class; ?>">
    <script type="text/javascript">
      document.body.className = document.body.className.replace('no-js','js');
    </script>
    
    <?php    

  } // ucp_editor_clean_admin_page
   
  static function admin_menu() {
    add_submenu_page(
        null,
        'UnderConstruction Styler',
        'UnderConstruction Styler',
        'edit_pages',
        'ucp_editor',
        array(__CLASS__, 'ucp_editor')
    );        
  } // admin_menu
  
  static function ucp_editor(){
    global $wpdb;
    
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    
    $template_name=false;
    if(isset($_GET['template'])){
       $template_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->ucp_templates . ' WHERE slug = %s LIMIT 1', $_GET['template']));
    }
    
    do_action('admin_enqueue_styles');
    do_action('admin_print_styles');
    do_action('admin_enqueue_scripts');
    do_action('admin_print_scripts'); 
    do_action('admin_head');
    ?>
      <div id="ucp-editor-page-loader"><div class="ucp-loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw margin-bottom"></i> Loading editor ... </div></div>
      <div id="ucp-styler-wrapper">  
         
        <div id="ucp-style-sidebar">
         
         <div id="ucp-sidebar-toggle"><i class="fa fa-caret-left" aria-hidden="true"></i></div>
         
         <div class="ucp-sidebar-header">
           <img src="<?php echo UCP_PLUGIN_URL.'/images/ucp_icon_w.png'; ?>" alt="UnderConstructionPage PRO" title="UnderConstructionPage PRO">
           <span class="ucp-sidebar-title">UCP Builder</span>
         </div>
         
         <div class="ucp_sidebar_main">
          
           <ul class="ucp-sidebar-tabs"><li data-tab="ucp_page_properties">Page Properties</li><li data-tab="ucp-modules" class="active">Add New Element</li></ul>
           
           
           
           <div id="ucp_page_properties" class="ucp-sidebar-tab" style="display:none;">
              <label for="ucp-template-name">Template Name:</label>
              <input type="text" id="ucp-template-name" class="ucp-tooltip" title="Template Name" name="ucp_template_name" value="<?php echo (isset($template_data->name)?$template_data->name:'New Template'); ?>" />
              <input type="hidden" id="ucp-template-id" name="ucp_template_id" value="<?php echo (isset($template_data->id)?$template_data->id:0); ?>" />
              <?php
              if ( is_plugin_active('ucp-tools/ucp-tools.php') ) {
                $template_types = array('draft (unpublished)','basic','pro','agency');
                echo '<label>Template Licence Level:</label><select id="ucp-template-type">';
                foreach($template_types as $type){
                  echo '<option value="'.$type.'" '.( $template_data->type == $type ? ' selected ' : '' ).'>'.ucfirst($type).'</option>';
                }
                echo '</select>';
                
                echo '<label>Template Tags:</label><input type="text" id="ucp-template-tags" value="'.(isset($template_data->tags)?$template_data->tags:'').'" />';
                echo '<label>Template Description:</label><input type="text" id="ucp-template-desc" value="'.(isset($template_data->desc)?$template_data->desc:'').'" />';
                echo '<label>Template Version:</label><input type="text" id="ucp-template-version" value="'.(isset($template_data->version)?$template_data->version:'1.0').'" />';
                echo '<input type="hidden" id="ucp-template-ucp" value="false" />';                
              } else {
                echo '<input type="hidden" id="ucp-template-type" value="user" />';
                echo '<input type="hidden" id="ucp-template-ucp" value="'.(isset($template_data) && $template_data->type!='user'?'true':'false').'" />';
                echo '<input type="hidden" id="ucp-template-version" value="1.0" />';
              }
              ?>

              <label>Page Title:</label>
              <textarea id="ucp-template-page-title" name="ucp-template-page-title"><?php echo isset($template_data)?$template_data->page_title:''; ?></textarea>
              
              <label>Page Description:</label>
              <textarea id="ucp-template-page-description" name="ucp-template-page-description"><?php echo isset($template_data)?$template_data->page_desc:''; ?></textarea>
                            
              <label>Custom CSS:</label>
              <textarea id="ucp-template-custom-css" name="ucp-template-custom-css"></textarea>
              
              <label>Footer Code:</label>
              <textarea id="ucp-template-footer-code" name="ucp-template-footer-code"></textarea>
              <small>Javascript code you insert is disabled in editor.</small>
              
              
              <div class="ucp_editor_background" data-applyto="page">
                <label>Background:</label>
                <div class="ucp_editor_background_styles_wrapper">
                  <div title="Transparent background" class="ucp-tooltip ucp_editor_background_style" data-background-type="transparent"><i class="icon-transparent-background" aria-hidden="true"></i></div>
                  <div title="Solid color background" class="ucp-tooltip ucp_editor_background_style" data-background-type="color"><i class="icon-solid-color-bg" aria-hidden="true"></i></div>
                  <div title="Gradient background" class="ucp-tooltip ucp_editor_background_style" data-background-type="gradient"><i class="icon-gradient-background" aria-hidden="true"></i></div>
                  <div title="Image background" class="ucp-tooltip ucp_editor_background_style" data-background-type="image"><i class="icon-image-background" aria-hidden="true"></i></div>
                  <div title="Video background" class="ucp-tooltip ucp_editor_background_style" data-background-type="video"><i class="icon-video-background" aria-hidden="true"></i></div>
                  <div title="Animated background" class="ucp-tooltip ucp_editor_background_style" data-background-type="animated"><i class="icon-animated-background" aria-hidden="true"></i></div>
                </div> 
                
                <div class="ucp_editor_background_options"></div>
              </div>  
                 
           </div> 
            
            
           <div id="ucp-modules" class="ucp_sidebar_modules ucp-sidebar-tab">
              <div class="ucp-sidebar-module" id="ucp-module-heading-l" data-module-type="heading_l"><i class="icon-heading-big" aria-hidden="true"></i><span>Heading Big</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-heading-s" data-module-type="heading_s"><i class="icon-heading-small" aria-hidden="true"></i><span>Heading Small</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-text" data-module-type="text"><i class="icon-text" aria-hidden="true"></i><span>Text</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-image" data-module-type="image"><i class="icon-image" aria-hidden="true"></i><span>Image</span></div>    
              <div class="ucp-sidebar-module" id="ucp-module-video" data-module-type="video"><i class="icon-video" aria-hidden="true"></i><span>Video</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-social" data-module-type="social"><i class="icon-social-icons" aria-hidden="true"></i><span>Social Icons</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-newsletter" data-module-type="newsletter"><i class="icon-newsletter" aria-hidden="true"></i><span>Newsletter</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-contact" data-module-type="contact"><i class="icon-contact" aria-hidden="true"></i><span>Contact</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-countdown" data-module-type="countdown"><i class="icon-countdown-timer" aria-hidden="true"></i><span>Countdown Timer</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-large-button" data-module-type="large_button"><i class="icon-large-button" aria-hidden="true"></i><span>Large Button</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-large-button" data-module-type="divider"><i class="icon-divider" aria-hidden="true"></i><span>Divider</span></div>
              <div class="ucp-sidebar-module" id="ucp-module-html" data-module-type="html"><i class="icon-html" aria-hidden="true"></i><span>HTML</span></div>
              <?php if(UCP::get_licence_type()>=3){ ?>
              <div class="ucp-sidebar-module" id="ucp-module-html" data-module-type="gmap"><i class="icon-GoogleMaps" aria-hidden="true"></i><span>Google Maps</span></div>
              <?php } ?>
          </div>
          
       </div>
        
        
        
       <div id="ucp-sidebar-footer-wrapper">
         <div data-action="close" title="Close editor" class="ucp-tooltip ucp-sidebar-footer-button"><i class="fa fa-window-close" aria-hidden="true"></i></div>
         <div data-action="help" title="Help" class="ucp-tooltip ucp-sidebar-footer-button"><i class="fa fa-question" aria-hidden="true"></i></div>
         <div data-action="history" title="History" class="ucp-tooltip ucp-sidebar-footer-button"><i class="fa fa-history" aria-hidden="true"></i></div>
         <div data-action="devices" title="Device preview" class="ucp-tooltip ucp-sidebar-footer-button"><i class="fa fa-desktop" aria-hidden="true"></i></div>
         <div data-action="save" class="ucp-sidebar-footer-button ucp-sidebar-footer-button-save">SAVE</div>       
         
         <div id="ucp-sidebar-footer-menu">
          
         </div>
      </div>
      
       <div class="ucp_sidebar_edit">
         <div class="ucp_sidebar_edit_fields"></div>
       </div>  
        
        
      </div>
      
      <div id="ucp_editor_preview_wrapper">
        <div id="ucp_editor_preview" class="ui-widget-content ucp-editor-preview-desktop">
          <iframe src="<?php echo get_home_url() . '/?ucp_template_preview&ucp_editing=true'.(isset($_GET['template'])?'&template='.$_GET['template']:''); ?>" id="ucp_editor_iframe"></iframe>
        </div>
      </div>
    </div>
  <?php
  } // ucp_editor
    
  
  static function slugify($text)
  {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);  
    if (empty($text)) {
      return 'n-a';
    }  
    return $text;
  } // slugify
  
  static function refresh_templates($force = false){
    self::ucp_refresh_templates(true);
  }
  
  static function ucp_refresh_templates($force = false){
    // Check last refreshed
    $templates = get_option(UCP_TEMPLATES_KEY);
        
    if( !$force && $templates && $templates['updated'] > (time()-84000) ){
      return;
    }
    

    $options = self::get_options();
    $request_params = array('sslverify' => false, 'timeout' => 25, 'redirection' => 2);
    $request_data = array('ucp_action' => 'get_templates',
                          'license_key' => $options['license_key'],
                          'code_base' => 'pro',
                          '_rand' => rand(1000, 9999),
                          'version' => self::$version,
                          'site' => get_home_url());                          
     
    $url = add_query_arg($request_data, 'https://templates.underconstructionpage.com/');
    $response = wp_remote_get(esc_url_raw($url), $request_params);
    
    if ( !is_wp_error($response) && 200 == wp_remote_retrieve_response_code( $response ) ) {
      
      $result = @json_decode(wp_remote_retrieve_body($response), true);
      if (!is_array($result)) {
        if($force){
          UCP::add_settings_error('An error occured retrieving the templates.', 'notice-info');
        } else {
          return false;
        }
      } else {
        $templates = array( 'updated'=>time(), 'templates' => $result );
        update_option(UCP_TEMPLATES_KEY,$templates);      
      }
      
    } 
    
    if($force){
      UCP::add_settings_error('Templates have been refreshed.', 'notice-info');
      
      if (!empty($_GET['redirect'])) {
        if (strpos($_GET['redirect'], 'settings-updated=true') == false) {
          $_GET['redirect'] .= '&settings-updated=true';
        }
        wp_redirect($_GET['redirect']);
      } else {
        wp_redirect(admin_url());
      }

      exit;
    } else {
      return true; 
    }
     
  }
  
  static function install_template(){
    global $wpdb;
    $template_slug = $_GET['template'];

    // Check if template exists, then update
    $template_id = $wpdb->get_var( $wpdb->prepare( 'SELECT id FROM ' . $wpdb->ucp_templates . ' WHERE slug = %s LIMIT 1', $template_slug ) );
    
    $templates = get_option(UCP_TEMPLATES_KEY);
    if( !array_key_exists($template_slug,$templates['templates']) ){
      return false;
    }    
    
    $options = self::get_options();
    $request_params = array('sslverify' => false, 'timeout' => 25, 'redirection' => 2);
    $request_data = array('ucp_action' => 'get_template',
                          'template_slug' => $template_slug,
                          'license_key' => $options['license_key'],
                          'code_base' => 'pro',
                          '_rand' => rand(1000, 9999),
                          'version' => self::$version,
                          'site' => get_home_url());                          
     
    $url = add_query_arg($request_data, 'https://templates.underconstructionpage.com/');
    $response = wp_remote_get(esc_url_raw($url), $request_params);
    
    if (!is_wp_error($response) && 200 == wp_remote_retrieve_response_code( $response ) ) {
      $template_html = stripslashes(wp_remote_retrieve_body($response));
      
      
      $doc = new DOMDocument();
      $doc->loadHTML($template_html);
      $template_images = array();
      
      $imageTags = $doc->getElementsByTagName('img');
      
      foreach($imageTags as $tag) {
        $image_path = str_replace('"','',stripslashes($tag->getAttribute('src')));
        $template_images[$image_path]=$image_path;               
      }
      
      foreach($template_images as $template_image){
        
        if(strpos($template_image,'captcha.php')){
          $template_html = str_replace('https://templates.underconstructionpage.com/app/wp-content/plugins/under-construction-page/', UCP_PLUGIN_URL, $template_html);
          continue;
        }
        $local_image = media_sideload_image($template_image, 0, '', 'src');        
        $template_html = str_replace($template_image, $local_image, $template_html);
      }
        
      $template_data = array( 'template_id' => $template_id,
                              'template_slug' => $template_slug,
                              'template_name' => $templates['templates'][$template_slug]['name'],
                              'template_html' => $template_html,
                              'template_type' => $templates['templates'][$template_slug]['type'],
                              'template_version' => $templates['templates'][$template_slug]['version'],
                              'template_thumb' => '',
                              'template_ucp' => true);
      
      self::ucp_editor_save_template($template_data);
    }    
    
    
    
    UCP::add_settings_error('Template <strong>'.$templates['templates'][$template_slug]['name'].'</strong> has been installed.', 'notice-info');
    
    if (!empty($_GET['redirect'])) {
      if (strpos($_GET['redirect'], 'settings-updated=true') == false) {
        $_GET['redirect'] .= '&settings-updated=true';
      }
      wp_redirect($_GET['redirect']);
    } else {
      wp_redirect(admin_url());
    }

    exit;
  }
  
  static function activate_template(){
    
    $options = UCP::get_options();
    $options['theme'] = $_GET['template'];
    update_option(UCP_OPTIONS_KEY, $options);

    if (false === $redirect) {
      return true;
    }

    UCP::add_settings_error('Template has been activated.', 'updated');

    if (!empty($_GET['redirect'])) {
      if (strpos($_GET['redirect'], 'settings-updated=true') == false) {
        $_GET['redirect'] .= '&settings-updated=true';
      }
      wp_redirect($_GET['redirect']);
    } else {
      wp_redirect(admin_url());
    }

    exit;
  } // activate_template
  
  static function delete_template(){
    global $wpdb;
    
    $template = $_GET['template'];
    $wpdb->query('DELETE FROM ' . $wpdb->ucp_templates . ' WHERE slug="'.$template.'"');
    
    if (false === $redirect) {
      return true;
    }

    UCP::add_settings_error('Template has been deleted.', 'updated');

    if (!empty($_GET['redirect'])) {
      if (strpos($_GET['redirect'], 'settings-updated=true') == false) {
        $_GET['redirect'] .= '&settings-updated=true';
      }
      wp_redirect($_GET['redirect']);
    } else {
      wp_redirect(admin_url());
    }

    exit;
  } // delete_template
   
  static function ucp_editor_save_template($template_data = false){
    global $wpdb;
    
    if(!$template_data){
      $template_data = $_POST;
    }
    
    if(!isset($template_data['template_tags'])){
      $template_data['template_tags'] = '';
    }
    
    if(!isset($template_data['template_desc'])){
      $template_data['template_desc'] = '';
    }
    
    if(!isset($template_data['template_page_title'])){
      $template_data['template_page_title'] = '';
    }
    
    if(!isset($template_data['template_page_title'])){
      $template_data['template_page_title'] = '';
    }
    
    if( isset($template_data['template_id']) && (int)$template_data['template_id']>0 ){
      $template_slug = $wpdb->get_var( $wpdb->prepare( 'SELECT slug FROM ' . $wpdb->ucp_templates . ' WHERE id = %s LIMIT 1', $template_data['template_id'] ) );
            
      $template_id = (int)$template_data['template_id'];
      $wpdb->update( 
        $wpdb->ucp_templates, 
        array( 
          'name' => $template_data['template_name'],
          'html' => $template_data['template_html'],
          'type' => $template_data['template_type'],
          'version' => $template_data['template_version'],
          'tags' => $template_data['template_tags'],
          'desc' => $template_data['template_desc'],
          'page_title' => $template_data['template_page_title'],
          'page_desc' => $template_data['template_page_desc']
        ), 
        array( 'id' => (int)$template_data['template_id'] ), 
        array( 
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s'
        ), 
        array( '%d' ) 
      );   
      
    } else {
      // Check if template exists
      if($template_data['template_slug']){
        $template_slug = $template_data['template_slug'];
      } else {
        $template_slug = self::slugify($template_data['template_name']);      
      }
      
      $check_template = $wpdb->get_var( $wpdb->prepare( 'SELECT id FROM ' . $wpdb->ucp_templates . ' WHERE slug = %s LIMIT 1', $template_slug ) );
      
      if($check_template>0){
         $template_slug = $template_slug.time();
      }
      
      $wpdb->insert( 
        $wpdb->ucp_templates,
        array( 
          'name' => $template_data['template_name'],
          'slug' => $template_slug,
          'html' => $template_data['template_html'],          
          'type' => $template_data['template_type'],
          'version' => $template_data['template_version'],
          'tags' => $template_data['template_tags'],
          'desc' => $template_data['template_desc'],
          'page_title' => $template_data['template_page_title'],
          'page_desc' => $template_data['template_page_desc']
        ), 
        array( 
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s',
          '%s'
        )
      );
      
      $template_id = $wpdb->insert_id;
    } 
    
    if(isset($template_data['activate']) && $template_data['activate'] == 'true'){
      $options = UCP::get_options();
      $options['theme'] = $template_slug;
      update_option(UCP_OPTIONS_KEY, $options); 
    }
    
    //Save template thumbnail
    $img = $template_data['template_thumb'];
 
    if (strpos($img, 'data:image/png;base64') === 0) {
      $uploads = wp_upload_dir(); 
      file_put_contents($uploads['basedir'].'/ucp/test.txt',$img);
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      
      $uploads = wp_upload_dir(); 
      $custom_img_path = $uploads['basedir'].'/ucp/'; 
              
      if(!file_exists($custom_img_path)){
        mkdir($custom_img_path,0777); 
      }
      $file = $custom_img_path.'template-'.$template_slug.'.png';
   
      $thumb_img = imagecreatefromstring($data);
      
      $width_orig = imagesx($thumb_img);
      $height_orig = imagesy($thumb_img);
      
      $width = 300;
      $height = 216;
      
      $ratio = max($width/$width_orig, $height/$height_orig);
      $height_orig = $height / $ratio;
      $x = ($width_orig - $width / $ratio) / 2;
      $width_orig = $width / $ratio;
      
      
      
      $img = imagecreatetruecolor(300, 216);
      $color = imagecolorallocatealpha($img, 0, 0, 0, 127);
      imagefill($img, 0, 0, $color);
      imagesavealpha($img, true);
      imagealphablending( $img, true );
      imagecopyresampled($img, $thumb_img, 0, 0, $x, 0, $width, $height, $width_orig, $height_orig);
      imagepng($img,$file);
      imagedestroy($img);
    } 
    
    if(!isset($template_data['template_ucp'])){
      wp_send_json_success(array('template_id'=>$template_id,'template_slug'=>$template_slug,'template_slug_initial'=>$template_data['template_slug']));
      die();
    } else {
      return true;
    }
  } // ucp_editor_save_template
 
 
  static function ucp_editor_unsplash_api(){
    
    $request_params = array('sslverify' => false, 'timeout' => 15, 'redirection' => 2);
    $api_url = 'http://alex.technique.ro/unsplash_api/';
    
    $response = wp_remote_get($api_url.'?request=photos&page='.(int)$_POST['page'].'&per_page='.(int)$_POST['per_page'].'&search='.urlencode($_POST['search']), $request_params);

    if( is_wp_error($response) || !wp_remote_retrieve_body($response) ) {
      wp_send_json_error('Unsplash API is temporarily not available. '.$api_url.'?request=photos&page='.(int)$_POST['page'].'&per_page='.(int)$_POST['per_page'].'&search='.urlencode($_POST['search']));      
    } else {
      $body = wp_remote_retrieve_body($response);
      $photos_unsplash_response = json_decode($body);
      
      $photos_response = array();
      $total_pages=false;
      $total_results=false;
      
      if($photos_unsplash_response->total){
        $total_results = $photos_unsplash_response->total;
        $total_pages = $photos_unsplash_response->total_pages;
        $photos_unsplash = $photos_unsplash_response->results;
      } else {
        $photos_unsplash = $photos_unsplash_response;  
      }      
      
      foreach($photos_unsplash as $photo_data){
        $photo_response[]=array('id'=>$photo_data->id,'thumb'=>$photo_data->urls->thumb,'full'=>$photo_data->urls->full,'user'=>'<a class="unsplash-user" href="https://unsplash.com/@'.$photo_data->user->username.'" target="_blank"><img src="'.$photo_data->user->profile_image->small.'" />'.$photo_data->user->name.'</a>'); 
      }
      
      if(count($photo_response) == 0){
        wp_send_json_error('Unsplash API is temporarily not available.');     
      } else {
        wp_send_json_success(array('results'=>json_encode($photo_response),'total_pages'=>$total_pages,'total_results'=>$total_results));
      }
    }
    die();
    
  } // ucp_editor_unsplash_api
  
  static function ucp_editor_unsplash_download(){
    
    $image_url = $_POST['image_url'];
    
    $image_src = media_sideload_image($image_url.'&format=.jpg', 0, '', 'src');
    
    if(!is_wp_error($image_src)){
      wp_send_json_success($image_src); 
    } else {
      wp_send_json_error($image_src->get_error_message()); 
    }
    die();  
    
  } // ucp_editor_unsplash_download
  
  static function google_fonts(){
    	 $google_fonts_list=unserialize('a:733:{s:9:"open_sans";a:3:{s:4:"name";s:9:"Open Sans";s:8:"variants";s:70:"300,300italic,regular,italic,600,600italic,700,700italic,800,800italic";s:8:"fallback";s:10:"sans-serif";}s:6:"roboto";a:3:{s:4:"name";s:6:"Roboto";s:8:"variants";s:84:"100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:4:"lato";a:3:{s:4:"name";s:4:"Lato";s:8:"variants";s:70:"100,100italic,300,300italic,regular,italic,700,700italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:10:"slabo_27px";a:3:{s:4:"name";s:10:"Slabo 27px";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:16:"roboto_condensed";a:3:{s:4:"name";s:16:"Roboto Condensed";s:8:"variants";s:42:"300,300italic,regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:6:"oswald";a:3:{s:4:"name";s:6:"Oswald";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:10:"sans-serif";}s:10:"montserrat";a:3:{s:4:"name";s:10:"Montserrat";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:15:"source_sans_pro";a:3:{s:4:"name";s:15:"Source Sans Pro";s:8:"variants";s:84:"200,200italic,300,300italic,regular,italic,600,600italic,700,700italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:4:"lora";a:3:{s:4:"name";s:4:"Lora";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:7:"raleway";a:3:{s:4:"name";s:7:"Raleway";s:8:"variants";s:126:"100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:7:"pt_sans";a:3:{s:4:"name";s:7:"PT Sans";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:19:"open_sans_condensed";a:3:{s:4:"name";s:19:"Open Sans Condensed";s:8:"variants";s:17:"300,300italic,700";s:8:"fallback";s:10:"sans-serif";}s:10:"droid_sans";a:3:{s:4:"name";s:10:"Droid Sans";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:6:"ubuntu";a:3:{s:4:"name";s:6:"Ubuntu";s:8:"variants";s:56:"300,300italic,regular,italic,500,500italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:11:"roboto_slab";a:3:{s:4:"name";s:11:"Roboto Slab";s:8:"variants";s:19:"100,300,regular,700";s:8:"fallback";s:5:"serif";}s:11:"droid_serif";a:3:{s:4:"name";s:11:"Droid Serif";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:5:"arimo";a:3:{s:4:"name";s:5:"Arimo";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:10:"fjalla_one";a:3:{s:4:"name";s:10:"Fjalla One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:14:"pt_sans_narrow";a:3:{s:4:"name";s:14:"PT Sans Narrow";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:12:"merriweather";a:3:{s:4:"name";s:12:"Merriweather";s:8:"variants";s:56:"300,300italic,regular,italic,700,700italic,900,900italic";s:8:"fallback";s:5:"serif";}s:9:"noto_sans";a:3:{s:4:"name";s:9:"Noto Sans";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:13:"titillium_web";a:3:{s:4:"name";s:13:"Titillium Web";s:8:"variants";s:74:"200,200italic,300,300italic,regular,italic,600,600italic,700,700italic,900";s:8:"fallback";s:10:"sans-serif";}s:13:"alegreya_sans";a:3:{s:4:"name";s:13:"Alegreya Sans";s:8:"variants";s:98:"100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,800,800italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:8:"pt_serif";a:3:{s:4:"name";s:8:"PT Serif";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:11:"passion_one";a:3:{s:4:"name";s:11:"Passion One";s:8:"variants";s:15:"regular,700,900";s:8:"fallback";s:7:"display";}s:10:"poiret_one";a:3:{s:4:"name";s:10:"Poiret One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"candal";a:3:{s:4:"name";s:6:"Candal";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:16:"playfair_display";a:3:{s:4:"name";s:16:"Playfair Display";s:8:"variants";s:42:"regular,italic,700,700italic,900,900italic";s:8:"fallback";s:5:"serif";}s:12:"indie_flower";a:3:{s:4:"name";s:12:"Indie Flower";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"bitter";a:3:{s:4:"name";s:6:"Bitter";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:5:"serif";}s:5:"dosis";a:3:{s:4:"name";s:5:"Dosis";s:8:"variants";s:31:"200,300,regular,500,600,700,800";s:8:"fallback";s:10:"sans-serif";}s:5:"cabin";a:3:{s:4:"name";s:5:"Cabin";s:8:"variants";s:56:"regular,italic,500,500italic,600,600italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:17:"yanone_kaffeesatz";a:3:{s:4:"name";s:17:"Yanone Kaffeesatz";s:8:"variants";s:19:"200,300,regular,700";s:8:"fallback";s:10:"sans-serif";}s:6:"oxygen";a:3:{s:4:"name";s:6:"Oxygen";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:10:"sans-serif";}s:7:"lobster";a:3:{s:4:"name";s:7:"Lobster";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:4:"hind";a:3:{s:4:"name";s:4:"Hind";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:5:"anton";a:3:{s:4:"name";s:5:"Anton";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:4:"arvo";a:3:{s:4:"name";s:4:"Arvo";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:10:"noto_serif";a:3:{s:4:"name";s:10:"Noto Serif";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:6:"nunito";a:3:{s:4:"name";s:6:"Nunito";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:10:"sans-serif";}s:11:"inconsolata";a:3:{s:4:"name";s:11:"Inconsolata";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:9:"monospace";}s:4:"abel";a:3:{s:4:"name";s:4:"Abel";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:10:"bree_serif";a:3:{s:4:"name";s:10:"Bree Serif";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:4:"muli";a:3:{s:4:"name";s:4:"Muli";s:8:"variants";s:28:"300,300italic,regular,italic";s:8:"fallback";s:10:"sans-serif";}s:9:"fira_sans";a:3:{s:4:"name";s:9:"Fira Sans";s:8:"variants";s:56:"300,300italic,regular,italic,500,500italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:12:"josefin_sans";a:3:{s:4:"name";s:12:"Josefin Sans";s:8:"variants";s:70:"100,100italic,300,300italic,regular,italic,600,600italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:16:"ubuntu_condensed";a:3:{s:4:"name";s:16:"Ubuntu Condensed";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"cinzel";a:3:{s:4:"name";s:6:"Cinzel";s:8:"variants";s:15:"regular,700,900";s:8:"fallback";s:5:"serif";}s:17:"libre_baskerville";a:3:{s:4:"name";s:17:"Libre Baskerville";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:5:"serif";}s:5:"exo_2";a:3:{s:4:"name";s:5:"Exo 2";s:8:"variants";s:126:"100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:8:"pacifico";a:3:{s:4:"name";s:8:"Pacifico";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:18:"shadows_into_light";a:3:{s:4:"name";s:18:"Shadows Into Light";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:4:"play";a:3:{s:4:"name";s:4:"Play";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:12:"crimson_text";a:3:{s:4:"name";s:12:"Crimson Text";s:8:"variants";s:42:"regular,italic,600,600italic,700,700italic";s:8:"fallback";s:5:"serif";}s:4:"asap";a:3:{s:4:"name";s:4:"Asap";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:7:"signika";a:3:{s:4:"name";s:7:"Signika";s:8:"variants";s:19:"300,regular,600,700";s:8:"fallback";s:10:"sans-serif";}s:6:"cuprum";a:3:{s:4:"name";s:6:"Cuprum";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:14:"archivo_narrow";a:3:{s:4:"name";s:14:"Archivo Narrow";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:12:"francois_one";a:3:{s:4:"name";s:12:"Francois One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"quicksand";a:3:{s:4:"name";s:9:"Quicksand";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:10:"sans-serif";}s:17:"merriweather_sans";a:3:{s:4:"name";s:17:"Merriweather Sans";s:8:"variants";s:56:"300,300italic,regular,italic,700,700italic,800,800italic";s:8:"fallback";s:10:"sans-serif";}s:8:"alegreya";a:3:{s:4:"name";s:8:"Alegreya";s:8:"variants";s:42:"regular,italic,700,700italic,900,900italic";s:8:"fallback";s:5:"serif";}s:9:"amatic_sc";a:3:{s:4:"name";s:9:"Amatic SC";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:11:"handwriting";}s:8:"vollkorn";a:3:{s:4:"name";s:8:"Vollkorn";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:9:"maven_pro";a:3:{s:4:"name";s:9:"Maven Pro";s:8:"variants";s:19:"regular,500,700,900";s:8:"fallback";s:10:"sans-serif";}s:8:"orbitron";a:3:{s:4:"name";s:8:"Orbitron";s:8:"variants";s:19:"regular,500,700,900";s:8:"fallback";s:10:"sans-serif";}s:12:"varela_round";a:3:{s:4:"name";s:12:"Varela Round";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"karla";a:3:{s:4:"name";s:5:"Karla";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:9:"righteous";a:3:{s:4:"name";s:9:"Righteous";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"dancing_script";a:3:{s:4:"name";s:14:"Dancing Script";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:11:"handwriting";}s:3:"exo";a:3:{s:4:"name";s:3:"Exo";s:8:"variants";s:126:"100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:7:"rokkitt";a:3:{s:4:"name";s:7:"Rokkitt";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:19:"architects_daughter";a:3:{s:4:"name";s:19:"Architects Daughter";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"questrial";a:3:{s:4:"name";s:9:"Questrial";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"chewy";a:3:{s:4:"name";s:5:"Chewy";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"pt_sans_caption";a:3:{s:4:"name";s:15:"PT Sans Caption";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:7:"bangers";a:3:{s:4:"name";s:7:"Bangers";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"abril_fatface";a:3:{s:4:"name";s:13:"Abril Fatface";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"patua_one";a:3:{s:4:"name";s:9:"Patua One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"sigmar_one";a:3:{s:4:"name";s:10:"Sigmar One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:18:"pathway_gothic_one";a:3:{s:4:"name";s:18:"Pathway Gothic One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"monda";a:3:{s:4:"name";s:5:"Monda";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:17:"quattrocento_sans";a:3:{s:4:"name";s:17:"Quattrocento Sans";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:12:"josefin_slab";a:3:{s:4:"name";s:12:"Josefin Slab";s:8:"variants";s:70:"100,100italic,300,300italic,regular,italic,600,600italic,700,700italic";s:8:"fallback";s:5:"serif";}s:9:"russo_one";a:3:{s:4:"name";s:9:"Russo One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"benchnine";a:3:{s:4:"name";s:9:"BenchNine";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:10:"sans-serif";}s:9:"ropa_sans";a:3:{s:4:"name";s:9:"Ropa Sans";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:10:"sans-serif";}s:9:"comfortaa";a:3:{s:4:"name";s:9:"Comfortaa";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:7:"display";}s:10:"news_cycle";a:3:{s:4:"name";s:10:"News Cycle";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:11:"lobster_two";a:3:{s:4:"name";s:11:"Lobster Two";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:7:"display";}s:11:"crete_round";a:3:{s:4:"name";s:11:"Crete Round";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:14:"kaushan_script";a:3:{s:4:"name";s:14:"Kaushan Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"eb_garamond";a:3:{s:4:"name";s:11:"EB Garamond";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"istok_web";a:3:{s:4:"name";s:9:"Istok Web";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:5:"gudea";a:3:{s:4:"name";s:5:"Gudea";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:10:"sans-serif";}s:7:"abeezee";a:3:{s:4:"name";s:7:"ABeeZee";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:10:"sans-serif";}s:12:"pontano_sans";a:3:{s:4:"name";s:12:"Pontano Sans";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:21:"covered_by_your_grace";a:3:{s:4:"name";s:21:"Covered By Your Grace";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"noticia_text";a:3:{s:4:"name";s:12:"Noticia Text";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:17:"gloria_hallelujah";a:3:{s:4:"name";s:17:"Gloria Hallelujah";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"didact_gothic";a:3:{s:4:"name";s:13:"Didact Gothic";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:11:"fredoka_one";a:3:{s:4:"name";s:11:"Fredoka One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"cantarell";a:3:{s:4:"name";s:9:"Cantarell";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:15:"hammersmith_one";a:3:{s:4:"name";s:15:"Hammersmith One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:11:"philosopher";a:3:{s:4:"name";s:11:"Philosopher";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:11:"coming_soon";a:3:{s:4:"name";s:11:"Coming Soon";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:15:"old_standard_tt";a:3:{s:4:"name";s:15:"Old Standard TT";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:5:"serif";}s:6:"armata";a:3:{s:4:"name";s:6:"Armata";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"rambla";a:3:{s:4:"name";s:6:"Rambla";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:13:"archivo_black";a:3:{s:4:"name";s:13:"Archivo Black";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"domine";a:3:{s:4:"name";s:6:"Domine";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:9:"tangerine";a:3:{s:4:"name";s:9:"Tangerine";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:11:"handwriting";}s:9:"courgette";a:3:{s:4:"name";s:9:"Courgette";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"satisfy";a:3:{s:4:"name";s:7:"Satisfy";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"tinos";a:3:{s:4:"name";s:5:"Tinos";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:15:"cabin_condensed";a:3:{s:4:"name";s:15:"Cabin Condensed";s:8:"variants";s:19:"regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:5:"kreon";a:3:{s:4:"name";s:5:"Kreon";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:5:"serif";}s:7:"sanchez";a:3:{s:4:"name";s:7:"Sanchez";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:4:"ruda";a:3:{s:4:"name";s:4:"Ruda";s:8:"variants";s:15:"regular,700,900";s:8:"fallback";s:10:"sans-serif";}s:7:"handlee";a:3:{s:4:"name";s:7:"Handlee";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"cookie";a:3:{s:4:"name";s:6:"Cookie";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:15:"source_code_pro";a:3:{s:4:"name";s:15:"Source Code Pro";s:8:"variants";s:31:"200,300,regular,500,600,700,900";s:8:"fallback";s:9:"monospace";}s:6:"varela";a:3:{s:4:"name";s:6:"Varela";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"economica";a:3:{s:4:"name";s:9:"Economica";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:4:"acme";a:3:{s:4:"name";s:4:"Acme";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"rock_salt";a:3:{s:4:"name";s:9:"Rock Salt";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"alfa_slab_one";a:3:{s:4:"name";s:13:"Alfa Slab One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"quattrocento";a:3:{s:4:"name";s:12:"Quattrocento";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:7:"poppins";a:3:{s:4:"name";s:7:"Poppins";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:16:"permanent_marker";a:3:{s:4:"name";s:16:"Permanent Marker";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:4:"jura";a:3:{s:4:"name";s:4:"Jura";s:8:"variants";s:19:"300,regular,500,600";s:8:"fallback";s:10:"sans-serif";}s:18:"gentium_book_basic";a:3:{s:4:"name";s:18:"Gentium Book Basic";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:8:"voltaire";a:3:{s:4:"name";s:8:"Voltaire";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:12:"luckiest_guy";a:3:{s:4:"name";s:12:"Luckiest Guy";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"rubik";a:3:{s:4:"name";s:5:"Rubik";s:8:"variants";s:70:"300,300italic,regular,italic,500,500italic,700,700italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:9:"work_sans";a:3:{s:4:"name";s:9:"Work Sans";s:8:"variants";s:39:"100,200,300,regular,500,600,700,800,900";s:8:"fallback";s:10:"sans-serif";}s:7:"sintony";a:3:{s:4:"name";s:7:"Sintony";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:22:"shadows_into_light_two";a:3:{s:4:"name";s:22:"Shadows Into Light Two";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"roboto_mono";a:3:{s:4:"name";s:11:"Roboto Mono";s:8:"variants";s:70:"100,100italic,300,300italic,regular,italic,500,500italic,700,700italic";s:8:"fallback";s:9:"monospace";}s:5:"bevan";a:3:{s:4:"name";s:5:"Bevan";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"fauna_one";a:3:{s:4:"name";s:9:"Fauna One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"cardo";a:3:{s:4:"name";s:5:"Cardo";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:5:"serif";}s:11:"paytone_one";a:3:{s:4:"name";s:11:"Paytone One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:13:"pinyon_script";a:3:{s:4:"name";s:13:"Pinyon Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"actor";a:3:{s:4:"name";s:5:"Actor";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:13:"special_elite";a:3:{s:4:"name";s:13:"Special Elite";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"playball";a:3:{s:4:"name";s:8:"Playball";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"volkhov";a:3:{s:4:"name";s:7:"Volkhov";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:8:"vidaloka";a:3:{s:4:"name";s:8:"Vidaloka";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:10:"bad_script";a:3:{s:4:"name";s:10:"Bad Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"great_vibes";a:3:{s:4:"name";s:11:"Great Vibes";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:10:"changa_one";a:3:{s:4:"name";s:10:"Changa One";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:7:"display";}s:8:"amaranth";a:3:{s:4:"name";s:8:"Amaranth";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:11:"oleo_script";a:3:{s:4:"name";s:11:"Oleo Script";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:9:"audiowide";a:3:{s:4:"name";s:9:"Audiowide";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"antic_slab";a:3:{s:4:"name";s:10:"Antic Slab";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:12:"marck_script";a:3:{s:4:"name";s:12:"Marck Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"basic";a:3:{s:4:"name";s:5:"Basic";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"enriqueta";a:3:{s:4:"name";s:9:"Enriqueta";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:19:"playfair_display_sc";a:3:{s:4:"name";s:19:"Playfair Display SC";s:8:"variants";s:42:"regular,italic,700,700italic,900,900italic";s:8:"fallback";s:5:"serif";}s:6:"arapey";a:3:{s:4:"name";s:6:"Arapey";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:8:"boogaloo";a:3:{s:4:"name";s:8:"Boogaloo";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"amiri";a:3:{s:4:"name";s:5:"Amiri";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:6:"nobile";a:3:{s:4:"name";s:6:"Nobile";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:7:"niconne";a:3:{s:4:"name";s:7:"Niconne";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:15:"droid_sans_mono";a:3:{s:4:"name";s:15:"Droid Sans Mono";s:8:"variants";s:7:"regular";s:8:"fallback";s:9:"monospace";}s:16:"sorts_mill_goudy";a:3:{s:4:"name";s:16:"Sorts Mill Goudy";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:9:"fugaz_one";a:3:{s:4:"name";s:9:"Fugaz One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"chivo";a:3:{s:4:"name";s:5:"Chivo";s:8:"variants";s:28:"regular,italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:10:"squada_one";a:3:{s:4:"name";s:10:"Squada One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"molengo";a:3:{s:4:"name";s:7:"Molengo";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"khand";a:3:{s:4:"name";s:5:"Khand";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:14:"calligraffitti";a:3:{s:4:"name";s:14:"Calligraffitti";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"damion";a:3:{s:4:"name";s:6:"Damion";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:10:"doppio_one";a:3:{s:4:"name";s:10:"Doppio One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:4:"viga";a:3:{s:4:"name";s:4:"Viga";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"limelight";a:3:{s:4:"name";s:9:"Limelight";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"scada";a:3:{s:4:"name";s:5:"Scada";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:5:"copse";a:3:{s:4:"name";s:5:"Copse";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:16:"signika_negative";a:3:{s:4:"name";s:16:"Signika Negative";s:8:"variants";s:19:"300,regular,600,700";s:8:"fallback";s:10:"sans-serif";}s:5:"share";a:3:{s:4:"name";s:5:"Share";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:7:"display";}s:8:"marmelad";a:3:{s:4:"name";s:8:"Marmelad";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:17:"just_another_hand";a:3:{s:4:"name";s:17:"Just Another Hand";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:10:"gochi_hand";a:3:{s:4:"name";s:10:"Gochi Hand";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"glegoo";a:3:{s:4:"name";s:6:"Glegoo";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:8:"overlock";a:3:{s:4:"name";s:8:"Overlock";s:8:"variants";s:42:"regular,italic,700,700italic,900,900italic";s:8:"fallback";s:7:"display";}s:8:"days_one";a:3:{s:4:"name";s:8:"Days One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"lusitana";a:3:{s:4:"name";s:8:"Lusitana";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:4:"coda";a:3:{s:4:"name";s:4:"Coda";s:8:"variants";s:11:"regular,800";s:8:"fallback";s:7:"display";}s:10:"jockey_one";a:3:{s:4:"name";s:10:"Jockey One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"carme";a:3:{s:4:"name";s:5:"Carme";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:16:"alegreya_sans_sc";a:3:{s:4:"name";s:16:"Alegreya Sans SC";s:8:"variants";s:98:"100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,800,800italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:5:"ultra";a:3:{s:4:"name";s:5:"Ultra";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:12:"crafty_girls";a:3:{s:4:"name";s:12:"Crafty Girls";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:14:"homemade_apple";a:3:{s:4:"name";s:14:"Homemade Apple";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"electrolize";a:3:{s:4:"name";s:11:"Electrolize";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"alice";a:3:{s:4:"name";s:5:"Alice";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:16:"source_serif_pro";a:3:{s:4:"name";s:16:"Source Serif Pro";s:8:"variants";s:15:"regular,600,700";s:8:"fallback";s:5:"serif";}s:21:"montserrat_alternates";a:3:{s:4:"name";s:21:"Montserrat Alternates";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:6:"neuton";a:3:{s:4:"name";s:6:"Neuton";s:8:"variants";s:30:"200,300,regular,italic,700,800";s:8:"fallback";s:5:"serif";}s:13:"black_ops_one";a:3:{s:4:"name";s:13:"Black Ops One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"cantata_one";a:3:{s:4:"name";s:11:"Cantata One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:12:"contrail_one";a:3:{s:4:"name";s:12:"Contrail One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"patrick_hand";a:3:{s:4:"name";s:12:"Patrick Hand";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"spinnaker";a:3:{s:4:"name";s:9:"Spinnaker";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"michroma";a:3:{s:4:"name";s:8:"Michroma";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"nixie_one";a:3:{s:4:"name";s:9:"Nixie One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"walter_turncoat";a:3:{s:4:"name";s:15:"Walter Turncoat";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"quantico";a:3:{s:4:"name";s:8:"Quantico";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:23:"waiting_for_the_sunrise";a:3:{s:4:"name";s:23:"Waiting for the Sunrise";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"kanit";a:3:{s:4:"name";s:5:"Kanit";s:8:"variants";s:126:"100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic";s:8:"fallback";s:10:"sans-serif";}s:5:"antic";a:3:{s:4:"name";s:5:"Antic";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:17:"cherry_cream_soda";a:3:{s:4:"name";s:17:"Cherry Cream Soda";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"allerta";a:3:{s:4:"name";s:7:"Allerta";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"rajdhani";a:3:{s:4:"name";s:8:"Rajdhani";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:7:"average";a:3:{s:4:"name";s:7:"Average";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:10:"alex_brush";a:3:{s:4:"name";s:10:"Alex Brush";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"syncopate";a:3:{s:4:"name";s:9:"Syncopate";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:7:"aldrich";a:3:{s:4:"name";s:7:"Aldrich";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:14:"bubblegum_sans";a:3:{s:4:"name";s:14:"Bubblegum Sans";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"julius_sans_one";a:3:{s:4:"name";s:15:"Julius Sans One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:10:"sacramento";a:3:{s:4:"name";s:10:"Sacramento";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:20:"nothing_you_could_do";a:3:{s:4:"name";s:20:"Nothing You Could Do";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"catamaran";a:3:{s:4:"name";s:9:"Catamaran";s:8:"variants";s:39:"100,200,300,regular,500,600,700,800,900";s:8:"fallback";s:10:"sans-serif";}s:6:"marvel";a:3:{s:4:"name";s:6:"Marvel";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:8:"homenaje";a:3:{s:4:"name";s:8:"Homenaje";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"khula";a:3:{s:4:"name";s:5:"Khula";s:8:"variants";s:23:"300,regular,600,700,800";s:8:"fallback";s:10:"sans-serif";}s:15:"allerta_stencil";a:3:{s:4:"name";s:15:"Allerta Stencil";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"magra";a:3:{s:4:"name";s:5:"Magra";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:5:"kalam";a:3:{s:4:"name";s:5:"Kalam";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:11:"handwriting";}s:11:"ceviche_one";a:3:{s:4:"name";s:11:"Ceviche One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"marcellus";a:3:{s:4:"name";s:9:"Marcellus";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:13:"gentium_basic";a:3:{s:4:"name";s:13:"Gentium Basic";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:4:"teko";a:3:{s:4:"name";s:4:"Teko";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:20:"fredericka_the_great";a:3:{s:4:"name";s:20:"Fredericka the Great";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"ubuntu_mono";a:3:{s:4:"name";s:11:"Ubuntu Mono";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:9:"monospace";}s:7:"kameron";a:3:{s:4:"name";s:7:"Kameron";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:12:"finger_paint";a:3:{s:4:"name";s:12:"Finger Paint";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:16:"fontdiner_swanky";a:3:{s:4:"name";s:16:"Fontdiner Swanky";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"six_caps";a:3:{s:4:"name";s:8:"Six Caps";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"pt_mono";a:3:{s:4:"name";s:7:"PT Mono";s:8:"variants";s:7:"regular";s:8:"fallback";s:9:"monospace";}s:13:"reenie_beanie";a:3:{s:4:"name";s:13:"Reenie Beanie";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:16:"pt_serif_caption";a:3:{s:4:"name";s:16:"PT Serif Caption";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:15:"berkshire_swash";a:3:{s:4:"name";s:15:"Berkshire Swash";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"allura";a:3:{s:4:"name";s:6:"Allura";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"puritan";a:3:{s:4:"name";s:7:"Puritan";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:6:"halant";a:3:{s:4:"name";s:6:"Halant";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:5:"serif";}s:6:"rancho";a:3:{s:4:"name";s:6:"Rancho";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"radley";a:3:{s:4:"name";s:6:"Radley";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:5:"prata";a:3:{s:4:"name";s:5:"Prata";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"telex";a:3:{s:4:"name";s:5:"Telex";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:10:"yellowtail";a:3:{s:4:"name";s:10:"Yellowtail";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"freckle_face";a:3:{s:4:"name";s:12:"Freckle Face";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"chelsea_market";a:3:{s:4:"name";s:14:"Chelsea Market";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"coustard";a:3:{s:4:"name";s:8:"Coustard";s:8:"variants";s:11:"regular,900";s:8:"fallback";s:5:"serif";}s:14:"carrois_gothic";a:3:{s:4:"name";s:14:"Carrois Gothic";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:10:"advent_pro";a:3:{s:4:"name";s:10:"Advent Pro";s:8:"variants";s:31:"100,200,300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:8:"merienda";a:3:{s:4:"name";s:8:"Merienda";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:11:"handwriting";}s:6:"neucha";a:3:{s:4:"name";s:6:"Neucha";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"mouse_memoirs";a:3:{s:4:"name";s:13:"Mouse Memoirs";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"montez";a:3:{s:4:"name";s:6:"Montez";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"average_sans";a:3:{s:4:"name";s:12:"Average Sans";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"adamina";a:3:{s:4:"name";s:7:"Adamina";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"rochester";a:3:{s:4:"name";s:9:"Rochester";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"lekton";a:3:{s:4:"name";s:6:"Lekton";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:10:"sans-serif";}s:6:"cambay";a:3:{s:4:"name";s:6:"Cambay";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:12:"cabin_sketch";a:3:{s:4:"name";s:12:"Cabin Sketch";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:6:"cutive";a:3:{s:4:"name";s:6:"Cutive";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"kadwa";a:3:{s:4:"name";s:5:"Kadwa";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:8:"ek_mukta";a:3:{s:4:"name";s:8:"Ek Mukta";s:8:"variants";s:31:"200,300,regular,500,600,700,800";s:8:"fallback";s:10:"sans-serif";}s:24:"annie_use_your_telescope";a:3:{s:4:"name";s:24:"Annie Use Your Telescope";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"grand_hotel";a:3:{s:4:"name";s:11:"Grand Hotel";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"trocchi";a:3:{s:4:"name";s:7:"Trocchi";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:21:"goudy_bookletter_1911";a:3:{s:4:"name";s:21:"Goudy Bookletter 1911";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:10:"parisienne";a:3:{s:4:"name";s:10:"Parisienne";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"aclonica";a:3:{s:4:"name";s:8:"Aclonica";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"timmana";a:3:{s:4:"name";s:7:"Timmana";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"hanuman";a:3:{s:4:"name";s:7:"Hanuman";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:5:"forum";a:3:{s:4:"name";s:5:"Forum";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"press_start_2p";a:3:{s:4:"name";s:14:"Press Start 2P";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"oranienbaum";a:3:{s:4:"name";s:11:"Oranienbaum";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:11:"sansita_one";a:3:{s:4:"name";s:11:"Sansita One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"unica_one";a:3:{s:4:"name";s:9:"Unica One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"marcellus_sc";a:3:{s:4:"name";s:12:"Marcellus SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:8:"denk_one";a:3:{s:4:"name";s:8:"Denk One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"monoton";a:3:{s:4:"name";s:7:"Monoton";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"corben";a:3:{s:4:"name";s:6:"Corben";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:7:"rosario";a:3:{s:4:"name";s:7:"Rosario";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:17:"cinzel_decorative";a:3:{s:4:"name";s:17:"Cinzel Decorative";s:8:"variants";s:15:"regular,700,900";s:8:"fallback";s:7:"display";}s:10:"schoolbell";a:3:{s:4:"name";s:10:"Schoolbell";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:16:"port_lligat_slab";a:3:{s:4:"name";s:16:"Port Lligat Slab";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:10:"kelly_slab";a:3:{s:4:"name";s:10:"Kelly Slab";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"yesteryear";a:3:{s:4:"name";s:10:"Yesteryear";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"arbutus_slab";a:3:{s:4:"name";s:12:"Arbutus Slab";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:7:"frijole";a:3:{s:4:"name";s:7:"Frijole";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"belleza";a:3:{s:4:"name";s:7:"Belleza";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:4:"alef";a:3:{s:4:"name";s:4:"Alef";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:12:"leckerli_one";a:3:{s:4:"name";s:12:"Leckerli One";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"alegreya_sc";a:3:{s:4:"name";s:11:"Alegreya SC";s:8:"variants";s:42:"regular,italic,700,700italic,900,900italic";s:8:"fallback";s:5:"serif";}s:6:"caudex";a:3:{s:4:"name";s:6:"Caudex";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:12:"merienda_one";a:3:{s:4:"name";s:12:"Merienda One";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:4:"mako";a:3:{s:4:"name";s:4:"Mako";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"cousine";a:3:{s:4:"name";s:7:"Cousine";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:9:"monospace";}s:11:"short_stack";a:3:{s:4:"name";s:11:"Short Stack";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"convergence";a:3:{s:4:"name";s:11:"Convergence";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"inder";a:3:{s:4:"name";s:5:"Inder";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:14:"give_you_glory";a:3:{s:4:"name";s:14:"Give You Glory";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"lustria";a:3:{s:4:"name";s:7:"Lustria";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:6:"gruppo";a:3:{s:4:"name";s:6:"Gruppo";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"slackey";a:3:{s:4:"name";s:7:"Slackey";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"tenor_sans";a:3:{s:4:"name";s:10:"Tenor Sans";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"capriola";a:3:{s:4:"name";s:8:"Capriola";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:11:"metrophobic";a:3:{s:4:"name";s:11:"Metrophobic";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"graduate";a:3:{s:4:"name";s:8:"Graduate";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"racing_sans_one";a:3:{s:4:"name";s:15:"Racing Sans One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"prosto_one";a:3:{s:4:"name";s:10:"Prosto One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:19:"sue_ellen_francisco";a:3:{s:4:"name";s:19:"Sue Ellen Francisco";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"alike";a:3:{s:4:"name";s:5:"Alike";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"duru_sans";a:3:{s:4:"name";s:9:"Duru Sans";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:10:"lilita_one";a:3:{s:4:"name";s:10:"Lilita One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"italianno";a:3:{s:4:"name";s:9:"Italianno";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"unkempt";a:3:{s:4:"name";s:7:"Unkempt";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:10:"carter_one";a:3:{s:4:"name";s:10:"Carter One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"nova_square";a:3:{s:4:"name";s:11:"Nova Square";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"baumans";a:3:{s:4:"name";s:7:"Baumans";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"poller_one";a:3:{s:4:"name";s:10:"Poller One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"lemon";a:3:{s:4:"name";s:5:"Lemon";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:19:"petit_formal_script";a:3:{s:4:"name";s:19:"Petit Formal Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:10:"engagement";a:3:{s:4:"name";s:10:"Engagement";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:23:"just_me_again_down_here";a:3:{s:4:"name";s:23:"Just Me Again Down Here";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"creepster";a:3:{s:4:"name";s:9:"Creepster";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"fenix";a:3:{s:4:"name";s:5:"Fenix";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:6:"strait";a:3:{s:4:"name";s:6:"Strait";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"sarala";a:3:{s:4:"name";s:6:"Sarala";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:14:"pragati_narrow";a:3:{s:4:"name";s:14:"Pragati Narrow";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:13:"gilda_display";a:3:{s:4:"name";s:13:"Gilda Display";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"tauri";a:3:{s:4:"name";s:5:"Tauri";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:14:"mr_de_haviland";a:3:{s:4:"name";s:14:"Mr De Haviland";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"skranji";a:3:{s:4:"name";s:7:"Skranji";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:18:"the_girl_next_door";a:3:{s:4:"name";s:18:"The Girl Next Door";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"lateef";a:3:{s:4:"name";s:6:"Lateef";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"delius";a:3:{s:4:"name";s:6:"Delius";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:14:"londrina_solid";a:3:{s:4:"name";s:14:"Londrina Solid";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"bowlby_one_sc";a:3:{s:4:"name";s:13:"Bowlby One SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"imprima";a:3:{s:4:"name";s:7:"Imprima";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"quando";a:3:{s:4:"name";s:6:"Quando";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:6:"rufina";a:3:{s:4:"name";s:6:"Rufina";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:5:"allan";a:3:{s:4:"name";s:5:"Allan";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:7:"anaheim";a:3:{s:4:"name";s:7:"Anaheim";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"crushed";a:3:{s:4:"name";s:7:"Crushed";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"judson";a:3:{s:4:"name";s:6:"Judson";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:5:"serif";}s:11:"oxygen_mono";a:3:{s:4:"name";s:11:"Oxygen Mono";s:8:"variants";s:7:"regular";s:8:"fallback";s:9:"monospace";}s:7:"knewave";a:3:{s:4:"name";s:7:"Knewave";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"kotta_one";a:3:{s:4:"name";s:9:"Kotta One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:13:"hind_siliguri";a:3:{s:4:"name";s:13:"Hind Siliguri";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:7:"brawler";a:3:{s:4:"name";s:7:"Brawler";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:8:"wire_one";a:3:{s:4:"name";s:8:"Wire One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:17:"loved_by_the_king";a:3:{s:4:"name";s:17:"Loved by the King";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"megrim";a:3:{s:4:"name";s:6:"Megrim";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"andika";a:3:{s:4:"name";s:6:"Andika";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:15:"im_fell_dw_pica";a:3:{s:4:"name";s:15:"IM Fell DW Pica";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:3:"ovo";a:3:{s:4:"name";s:3:"Ovo";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:12:"gravitas_one";a:3:{s:4:"name";s:12:"Gravitas One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"la_belle_aurore";a:3:{s:4:"name";s:15:"La Belle Aurore";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:10:"slabo_13px";a:3:{s:4:"name";s:10:"Slabo 13px";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:7:"buenard";a:3:{s:4:"name";s:7:"Buenard";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:12:"headland_one";a:3:{s:4:"name";s:12:"Headland One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:22:"oleo_script_swash_caps";a:3:{s:4:"name";s:22:"Oleo Script Swash Caps";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:7:"oregano";a:3:{s:4:"name";s:7:"Oregano";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:7:"display";}s:6:"andada";a:3:{s:4:"name";s:6:"Andada";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"fjord_one";a:3:{s:4:"name";s:9:"Fjord One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:12:"fanwood_text";a:3:{s:4:"name";s:12:"Fanwood Text";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:11:"cutive_mono";a:3:{s:4:"name";s:11:"Cutive Mono";s:8:"variants";s:7:"regular";s:8:"fallback";s:9:"monospace";}s:9:"rationale";a:3:{s:4:"name";s:9:"Rationale";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"pompiere";a:3:{s:4:"name";s:8:"Pompiere";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"vt323";a:3:{s:4:"name";s:5:"VT323";s:8:"variants";s:7:"regular";s:8:"fallback";s:9:"monospace";}s:18:"averia_serif_libre";a:3:{s:4:"name";s:18:"Averia Serif Libre";s:8:"variants";s:42:"300,300italic,regular,italic,700,700italic";s:8:"fallback";s:7:"display";}s:20:"herr_von_muellerhoff";a:3:{s:4:"name";s:20:"Herr Von Muellerhoff";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"anonymous_pro";a:3:{s:4:"name";s:13:"Anonymous Pro";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:9:"monospace";}s:18:"unifrakturmaguntia";a:3:{s:4:"name";s:18:"UnifrakturMaguntia";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"bentham";a:3:{s:4:"name";s:7:"Bentham";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:10:"yeseva_one";a:3:{s:4:"name";s:10:"Yeseva One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"gafata";a:3:{s:4:"name";s:6:"Gafata";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:12:"happy_monkey";a:3:{s:4:"name";s:12:"Happy Monkey";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:18:"im_fell_english_sc";a:3:{s:4:"name";s:18:"IM Fell English SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:17:"averia_sans_libre";a:3:{s:4:"name";s:17:"Averia Sans Libre";s:8:"variants";s:42:"300,300italic,regular,italic,700,700italic";s:8:"fallback";s:7:"display";}s:15:"caesar_dressing";a:3:{s:4:"name";s:15:"Caesar Dressing";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:4:"mate";a:3:{s:4:"name";s:4:"Mate";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:6:"kranky";a:3:{s:4:"name";s:6:"Kranky";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:21:"love_ya_like_a_sister";a:3:{s:4:"name";s:21:"Love Ya Like A Sister";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"tienne";a:3:{s:4:"name";s:6:"Tienne";s:8:"variants";s:15:"regular,700,900";s:8:"fallback";s:5:"serif";}s:22:"mountains_of_christmas";a:3:{s:4:"name";s:22:"Mountains of Christmas";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:7:"orienta";a:3:{s:4:"name";s:7:"Orienta";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"aladin";a:3:{s:4:"name";s:6:"Aladin";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:14:"seaweed_script";a:3:{s:4:"name";s:14:"Seaweed Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"belgrano";a:3:{s:4:"name";s:8:"Belgrano";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:7:"biryani";a:3:{s:4:"name";s:7:"Biryani";s:8:"variants";s:31:"200,300,regular,600,700,800,900";s:8:"fallback";s:10:"sans-serif";}s:9:"simonetta";a:3:{s:4:"name";s:9:"Simonetta";s:8:"variants";s:28:"regular,italic,900,900italic";s:8:"fallback";s:7:"display";}s:15:"stardos_stencil";a:3:{s:4:"name";s:15:"Stardos Stencil";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:15:"lily_script_one";a:3:{s:4:"name";s:15:"Lily Script One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"norican";a:3:{s:4:"name";s:7:"Norican";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"balthazar";a:3:{s:4:"name";s:9:"Balthazar";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"gfs_didot";a:3:{s:4:"name";s:9:"GFS Didot";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:15:"euphoria_script";a:3:{s:4:"name";s:15:"Euphoria Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"englebert";a:3:{s:4:"name";s:9:"Englebert";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"qwigley";a:3:{s:4:"name";s:7:"Qwigley";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:16:"over_the_rainbow";a:3:{s:4:"name";s:16:"Over the Rainbow";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"inika";a:3:{s:4:"name";s:5:"Inika";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:4:"itim";a:3:{s:4:"name";s:4:"Itim";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"sofia";a:3:{s:4:"name";s:5:"Sofia";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"griffy";a:3:{s:4:"name";s:6:"Griffy";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"im_fell_english";a:3:{s:4:"name";s:15:"IM Fell English";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:5:"khmer";a:3:{s:4:"name";s:5:"Khmer";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"henny_penny";a:3:{s:4:"name";s:11:"Henny Penny";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"bowlby_one";a:3:{s:4:"name";s:10:"Bowlby One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"quintessential";a:3:{s:4:"name";s:14:"Quintessential";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"podkova";a:3:{s:4:"name";s:7:"Podkova";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:18:"chau_philomene_one";a:3:{s:4:"name";s:18:"Chau Philomene One";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:10:"sans-serif";}s:8:"mr_dafoe";a:3:{s:4:"name";s:8:"Mr Dafoe";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"arizonia";a:3:{s:4:"name";s:8:"Arizonia";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"dorsa";a:3:{s:4:"name";s:5:"Dorsa";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:17:"carrois_gothic_sc";a:3:{s:4:"name";s:17:"Carrois Gothic SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"salsa";a:3:{s:4:"name";s:5:"Salsa";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"shanti";a:3:{s:4:"name";s:6:"Shanti";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:3:"geo";a:3:{s:4:"name";s:3:"Geo";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:10:"sans-serif";}s:12:"caveat_brush";a:3:{s:4:"name";s:12:"Caveat Brush";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"karma";a:3:{s:4:"name";s:5:"Karma";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:5:"serif";}s:13:"expletus_sans";a:3:{s:4:"name";s:13:"Expletus Sans";s:8:"variants";s:56:"regular,italic,500,500italic,600,600italic,700,700italic";s:8:"fallback";s:7:"display";}s:10:"share_tech";a:3:{s:4:"name";s:10:"Share Tech";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"meddon";a:3:{s:4:"name";s:6:"Meddon";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"gabriela";a:3:{s:4:"name";s:8:"Gabriela";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"fira_mono";a:3:{s:4:"name";s:9:"Fira Mono";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:9:"monospace";}s:4:"poly";a:3:{s:4:"name";s:4:"Poly";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:13:"hind_vadodara";a:3:{s:4:"name";s:13:"Hind Vadodara";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:7:"mate_sc";a:3:{s:4:"name";s:7:"Mate SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"stalemate";a:3:{s:4:"name";s:9:"Stalemate";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"federo";a:3:{s:4:"name";s:6:"Federo";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"italiana";a:3:{s:4:"name";s:8:"Italiana";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:11:"concert_one";a:3:{s:4:"name";s:11:"Concert One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"fondamento";a:3:{s:4:"name";s:10:"Fondamento";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:11:"handwriting";}s:11:"life_savers";a:3:{s:4:"name";s:11:"Life Savers";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:9:"oldenburg";a:3:{s:4:"name";s:9:"Oldenburg";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:16:"bilbo_swash_caps";a:3:{s:4:"name";s:16:"Bilbo Swash Caps";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"galindo";a:3:{s:4:"name";s:7:"Galindo";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:3:"ntr";a:3:{s:4:"name";s:3:"NTR";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:17:"delius_swash_caps";a:3:{s:4:"name";s:17:"Delius Swash Caps";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"sniglet";a:3:{s:4:"name";s:7:"Sniglet";s:8:"variants";s:11:"regular,800";s:8:"fallback";s:7:"display";}s:6:"kristi";a:3:{s:4:"name";s:6:"Kristi";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"maiden_orange";a:3:{s:4:"name";s:13:"Maiden Orange";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"nova_mono";a:3:{s:4:"name";s:9:"Nova Mono";s:8:"variants";s:7:"regular";s:8:"fallback";s:9:"monospace";}s:4:"unna";a:3:{s:4:"name";s:4:"Unna";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"voces";a:3:{s:4:"name";s:5:"Voces";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"martel";a:3:{s:4:"name";s:6:"Martel";s:8:"variants";s:31:"200,300,regular,600,700,800,900";s:8:"fallback";s:5:"serif";}s:8:"codystar";a:3:{s:4:"name";s:8:"Codystar";s:8:"variants";s:11:"300,regular";s:8:"fallback";s:7:"display";}s:15:"holtwood_one_sc";a:3:{s:4:"name";s:15:"Holtwood One SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"cambo";a:3:{s:4:"name";s:5:"Cambo";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:14:"clicker_script";a:3:{s:4:"name";s:14:"Clicker Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"coda_caption";a:3:{s:4:"name";s:12:"Coda Caption";s:8:"variants";s:3:"800";s:8:"fallback";s:10:"sans-serif";}s:8:"kite_one";a:3:{s:4:"name";s:8:"Kite One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"mallanna";a:3:{s:4:"name";s:8:"Mallanna";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:12:"raleway_dots";a:3:{s:4:"name";s:12:"Raleway Dots";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"patrick_hand_sc";a:3:{s:4:"name";s:15:"Patrick Hand SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:18:"cedarville_cursive";a:3:{s:4:"name";s:18:"Cedarville Cursive";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:4:"sail";a:3:{s:4:"name";s:4:"Sail";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"metamorphous";a:3:{s:4:"name";s:12:"Metamorphous";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"nosifer";a:3:{s:4:"name";s:7:"Nosifer";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"cherry_swash";a:3:{s:4:"name";s:12:"Cherry Swash";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:10:"tulpen_one";a:3:{s:4:"name";s:10:"Tulpen One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:19:"im_fell_double_pica";a:3:{s:4:"name";s:19:"IM Fell Double Pica";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:20:"dawning_of_a_new_day";a:3:{s:4:"name";s:20:"Dawning of a New Day";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"esteban";a:3:{s:4:"name";s:7:"Esteban";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"amethysta";a:3:{s:4:"name";s:9:"Amethysta";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"condiment";a:3:{s:4:"name";s:9:"Condiment";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"rouge_script";a:3:{s:4:"name";s:12:"Rouge Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"flamenco";a:3:{s:4:"name";s:8:"Flamenco";s:8:"variants";s:11:"300,regular";s:8:"fallback";s:7:"display";}s:9:"shojumaru";a:3:{s:4:"name";s:9:"Shojumaru";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"ledger";a:3:{s:4:"name";s:6:"Ledger";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:11:"cantora_one";a:3:{s:4:"name";s:11:"Cantora One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:11:"yantramanav";a:3:{s:4:"name";s:11:"Yantramanav";s:8:"variants";s:27:"100,300,regular,500,700,900";s:8:"fallback";s:10:"sans-serif";}s:15:"aguafina_script";a:3:{s:4:"name";s:15:"Aguafina Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:14:"ruslan_display";a:3:{s:4:"name";s:14:"Ruslan Display";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"rammetto_one";a:3:{s:4:"name";s:12:"Rammetto One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"rubik_one";a:3:{s:4:"name";s:9:"Rubik One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"titan_one";a:3:{s:4:"name";s:9:"Titan One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"zeyada";a:3:{s:4:"name";s:6:"Zeyada";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:15:"share_tech_mono";a:3:{s:4:"name";s:15:"Share Tech Mono";s:8:"variants";s:7:"regular";s:8:"fallback";s:9:"monospace";}s:7:"milonga";a:3:{s:4:"name";s:7:"Milonga";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"vast_shadow";a:3:{s:4:"name";s:11:"Vast Shadow";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"sancreek";a:3:{s:4:"name";s:8:"Sancreek";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"junge";a:3:{s:4:"name";s:5:"Junge";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:11:"trade_winds";a:3:{s:4:"name";s:11:"Trade Winds";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:3:"rye";a:3:{s:4:"name";s:3:"Rye";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:18:"swanky_and_moo_moo";a:3:{s:4:"name";s:18:"Swanky and Moo Moo";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:9:"palanquin";a:3:{s:4:"name";s:9:"Palanquin";s:8:"variants";s:31:"100,200,300,regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:8:"amarante";a:3:{s:4:"name";s:8:"Amarante";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:21:"stint_ultra_condensed";a:3:{s:4:"name";s:21:"Stint Ultra Condensed";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"iceland";a:3:{s:4:"name";s:7:"Iceland";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"delius_unicase";a:3:{s:4:"name";s:14:"Delius Unicase";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:11:"handwriting";}s:11:"martel_sans";a:3:{s:4:"name";s:11:"Martel Sans";s:8:"variants";s:31:"200,300,regular,600,700,800,900";s:8:"fallback";s:10:"sans-serif";}s:10:"medula_one";a:3:{s:4:"name";s:10:"Medula One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"gurajada";a:3:{s:4:"name";s:8:"Gurajada";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:10:"ramabhadra";a:3:{s:4:"name";s:10:"Ramabhadra";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:8:"monofett";a:3:{s:4:"name";s:8:"Monofett";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"mclaren";a:3:{s:4:"name";s:7:"McLaren";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:22:"im_fell_double_pica_sc";a:3:{s:4:"name";s:22:"IM Fell Double Pica SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:20:"im_fell_french_canon";a:3:{s:4:"name";s:20:"IM Fell French Canon";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:10:"butcherman";a:3:{s:4:"name";s:10:"Butcherman";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"artifika";a:3:{s:4:"name";s:8:"Artifika";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:6:"angkor";a:3:{s:4:"name";s:6:"Angkor";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"dynalight";a:3:{s:4:"name";s:9:"Dynalight";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"overlock_sc";a:3:{s:4:"name";s:11:"Overlock SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"kavoon";a:3:{s:4:"name";s:6:"Kavoon";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"kurale";a:3:{s:4:"name";s:6:"Kurale";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:11:"donegal_one";a:3:{s:4:"name";s:11:"Donegal One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"redressed";a:3:{s:4:"name";s:9:"Redressed";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"paprika";a:3:{s:4:"name";s:7:"Paprika";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"stoke";a:3:{s:4:"name";s:5:"Stoke";s:8:"variants";s:11:"300,regular";s:8:"fallback";s:5:"serif";}s:6:"nokora";a:3:{s:4:"name";s:6:"Nokora";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:8:"wallpoet";a:3:{s:4:"name";s:8:"Wallpoet";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"wendy_one";a:3:{s:4:"name";s:9:"Wendy One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"sarina";a:3:{s:4:"name";s:6:"Sarina";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"jolly_lodger";a:3:{s:4:"name";s:12:"Jolly Lodger";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"nova_round";a:3:{s:4:"name";s:10:"Nova Round";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"ruthie";a:3:{s:4:"name";s:6:"Ruthie";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:10:"cagliostro";a:3:{s:4:"name";s:10:"Cagliostro";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:18:"im_fell_dw_pica_sc";a:3:{s:4:"name";s:18:"IM Fell DW Pica SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:16:"jacques_francois";a:3:{s:4:"name";s:16:"Jacques Francois";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:8:"rosarivo";a:3:{s:4:"name";s:8:"Rosarivo";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:10:"pirata_one";a:3:{s:4:"name";s:10:"Pirata One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"prociono";a:3:{s:4:"name";s:8:"Prociono";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:12:"averia_libre";a:3:{s:4:"name";s:12:"Averia Libre";s:8:"variants";s:42:"300,300italic,regular,italic,700,700italic";s:8:"fallback";s:7:"display";}s:23:"im_fell_french_canon_sc";a:3:{s:4:"name";s:23:"IM Fell French Canon SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"sunshiney";a:3:{s:4:"name";s:9:"Sunshiney";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:20:"montserrat_subrayada";a:3:{s:4:"name";s:20:"Montserrat Subrayada";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:6:"habibi";a:3:{s:4:"name";s:6:"Habibi";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:20:"stint_ultra_expanded";a:3:{s:4:"name";s:20:"Stint Ultra Expanded";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:23:"im_fell_great_primer_sc";a:3:{s:4:"name";s:23:"IM Fell Great Primer SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:9:"krona_one";a:3:{s:4:"name";s:9:"Krona One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"ruluko";a:3:{s:4:"name";s:6:"Ruluko";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"piedra";a:3:{s:4:"name";s:6:"Piedra";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"text_me_one";a:3:{s:4:"name";s:11:"Text Me One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:4:"asul";a:3:{s:4:"name";s:4:"Asul";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:12:"scheherazade";a:3:{s:4:"name";s:12:"Scheherazade";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:6:"numans";a:3:{s:4:"name";s:6:"Numans";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:20:"im_fell_great_primer";a:3:{s:4:"name";s:20:"IM Fell Great Primer";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:10:"sonsie_one";a:3:{s:4:"name";s:10:"Sonsie One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"rubik_mono_one";a:3:{s:4:"name";s:14:"Rubik Mono One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:11:"linden_hill";a:3:{s:4:"name";s:11:"Linden Hill";s:8:"variants";s:14:"regular,italic";s:8:"fallback";s:5:"serif";}s:16:"port_lligat_sans";a:3:{s:4:"name";s:16:"Port Lligat Sans";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"vibur";a:3:{s:4:"name";s:5:"Vibur";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"irish_grover";a:3:{s:4:"name";s:12:"Irish Grover";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:4:"buda";a:3:{s:4:"name";s:4:"Buda";s:8:"variants";s:3:"300";s:8:"fallback";s:7:"display";}s:7:"offside";a:3:{s:4:"name";s:7:"Offside";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"nova_slim";a:3:{s:4:"name";s:9:"Nova Slim";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"snippet";a:3:{s:4:"name";s:7:"Snippet";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:19:"mrs_saint_delafield";a:3:{s:4:"name";s:19:"Mrs Saint Delafield";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"caveat";a:3:{s:4:"name";s:6:"Caveat";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:11:"handwriting";}s:5:"bilbo";a:3:{s:4:"name";s:5:"Bilbo";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"della_respira";a:3:{s:4:"name";s:13:"Della Respira";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:13:"glass_antiqua";a:3:{s:4:"name";s:13:"Glass Antiqua";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"ribeye";a:3:{s:4:"name";s:6:"Ribeye";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"battambang";a:3:{s:4:"name";s:10:"Battambang";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:10:"new_rocker";a:3:{s:4:"name";s:10:"New Rocker";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"wellfleet";a:3:{s:4:"name";s:9:"Wellfleet";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"smythe";a:3:{s:4:"name";s:6:"Smythe";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"mystery_quest";a:3:{s:4:"name";s:13:"Mystery Quest";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"elsie";a:3:{s:4:"name";s:5:"Elsie";s:8:"variants";s:11:"regular,900";s:8:"fallback";s:7:"display";}s:15:"gfs_neohellenic";a:3:{s:4:"name";s:15:"GFS Neohellenic";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:10:"sans-serif";}s:7:"trochut";a:3:{s:4:"name";s:7:"Trochut";s:8:"variants";s:18:"regular,italic,700";s:8:"fallback";s:7:"display";}s:10:"keania_one";a:3:{s:4:"name";s:10:"Keania One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"league_script";a:3:{s:4:"name";s:13:"League Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"suranna";a:3:{s:4:"name";s:7:"Suranna";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:6:"chango";a:3:{s:4:"name";s:6:"Chango";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"peralta";a:3:{s:4:"name";s:7:"Peralta";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"antic_didone";a:3:{s:4:"name";s:12:"Antic Didone";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:13:"alike_angular";a:3:{s:4:"name";s:13:"Alike Angular";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:11:"dr_sugiyama";a:3:{s:4:"name";s:11:"Dr Sugiyama";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:5:"kenia";a:3:{s:4:"name";s:5:"Kenia";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"content";a:3:{s:4:"name";s:7:"Content";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:5:"julee";a:3:{s:4:"name";s:5:"Julee";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"snowburst_one";a:3:{s:4:"name";s:13:"Snowburst One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"medievalsharp";a:3:{s:4:"name";s:13:"MedievalSharp";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"unifrakturcook";a:3:{s:4:"name";s:14:"UnifrakturCook";s:8:"variants";s:3:"700";s:8:"fallback";s:7:"display";}s:11:"suwannaphum";a:3:{s:4:"name";s:11:"Suwannaphum";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"bigshot_one";a:3:{s:4:"name";s:11:"Bigshot One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"bubbler_one";a:3:{s:4:"name";s:11:"Bubbler One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"miniver";a:3:{s:4:"name";s:7:"Miniver";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"sumana";a:3:{s:4:"name";s:6:"Sumana";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:8:"joti_one";a:3:{s:4:"name";s:8:"Joti One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"akronim";a:3:{s:4:"name";s:7:"Akronim";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"lovers_quarrel";a:3:{s:4:"name";s:14:"Lovers Quarrel";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"germania_one";a:3:{s:4:"name";s:12:"Germania One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:23:"jacques_francois_shadow";a:3:{s:4:"name";s:23:"Jacques Francois Shadow";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"trykker";a:3:{s:4:"name";s:7:"Trykker";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:7:"astloch";a:3:{s:4:"name";s:7:"Astloch";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:10:"autour_one";a:3:{s:4:"name";s:10:"Autour One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:16:"miltonian_tattoo";a:3:{s:4:"name";s:16:"Miltonian Tattoo";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"combo";a:3:{s:4:"name";s:5:"Combo";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"nova_flat";a:3:{s:4:"name";s:9:"Nova Flat";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:16:"elsie_swash_caps";a:3:{s:4:"name";s:16:"Elsie Swash Caps";s:8:"variants";s:11:"regular,900";s:8:"fallback";s:7:"display";}s:6:"warnes";a:3:{s:4:"name";s:6:"Warnes";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"iceberg";a:3:{s:4:"name";s:7:"Iceberg";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"ribeye_marrow";a:3:{s:4:"name";s:13:"Ribeye Marrow";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"galdeano";a:3:{s:4:"name";s:8:"Galdeano";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:15:"londrina_shadow";a:3:{s:4:"name";s:15:"Londrina Shadow";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"ranchers";a:3:{s:4:"name";s:8:"Ranchers";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"croissant_one";a:3:{s:4:"name";s:13:"Croissant One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"spicy_rice";a:3:{s:4:"name";s:10:"Spicy Rice";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:19:"averia_gruesa_libre";a:3:{s:4:"name";s:19:"Averia Gruesa Libre";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"modern_antiqua";a:3:{s:4:"name";s:14:"Modern Antiqua";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:15:"londrina_sketch";a:3:{s:4:"name";s:15:"Londrina Sketch";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"fresca";a:3:{s:4:"name";s:6:"Fresca";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"petrona";a:3:{s:4:"name";s:7:"Petrona";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"jaldi";a:3:{s:4:"name";s:5:"Jaldi";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:10:"eagle_lake";a:3:{s:4:"name";s:10:"Eagle Lake";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"passero_one";a:3:{s:4:"name";s:11:"Passero One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"sofadi_one";a:3:{s:4:"name";s:10:"Sofadi One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"atomic_age";a:3:{s:4:"name";s:10:"Atomic Age";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"freehand";a:3:{s:4:"name";s:8:"Freehand";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"asset";a:3:{s:4:"name";s:5:"Asset";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:4:"sura";a:3:{s:4:"name";s:4:"Sura";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:20:"monsieur_la_doulaise";a:3:{s:4:"name";s:20:"Monsieur La Doulaise";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:15:"original_surfer";a:3:{s:4:"name";s:15:"Original Surfer";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"fascinate";a:3:{s:4:"name";s:9:"Fascinate";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"purple_purse";a:3:{s:4:"name";s:12:"Purple Purse";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"margarine";a:3:{s:4:"name";s:9:"Margarine";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"sarpanch";a:3:{s:4:"name";s:8:"Sarpanch";s:8:"variants";s:27:"regular,500,600,700,800,900";s:8:"fallback";s:10:"sans-serif";}s:9:"diplomata";a:3:{s:4:"name";s:9:"Diplomata";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"lancelot";a:3:{s:4:"name";s:8:"Lancelot";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"gorditas";a:3:{s:4:"name";s:8:"Gorditas";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:8:"underdog";a:3:{s:4:"name";s:8:"Underdog";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"faster_one";a:3:{s:4:"name";s:10:"Faster One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"montaga";a:3:{s:4:"name";s:7:"Montaga";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:8:"almendra";a:3:{s:4:"name";s:8:"Almendra";s:8:"variants";s:28:"regular,italic,700,700italic";s:8:"fallback";s:5:"serif";}s:9:"rozha_one";a:3:{s:4:"name";s:9:"Rozha One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:10:"devonshire";a:3:{s:4:"name";s:10:"Devonshire";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:12:"emilys_candy";a:3:{s:4:"name";s:12:"Emilys Candy";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"kdam_thmor";a:3:{s:4:"name";s:10:"Kdam Thmor";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"geostar_fill";a:3:{s:4:"name";s:12:"Geostar Fill";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"miltonian";a:3:{s:4:"name";s:9:"Miltonian";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"dekko";a:3:{s:4:"name";s:5:"Dekko";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"aubrey";a:3:{s:4:"name";s:6:"Aubrey";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"vampiro_one";a:3:{s:4:"name";s:11:"Vampiro One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"mandali";a:3:{s:4:"name";s:7:"Mandali";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:11:"metal_mania";a:3:{s:4:"name";s:11:"Metal Mania";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:16:"fascinate_inline";a:3:{s:4:"name";s:16:"Fascinate Inline";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"palanquin_dark";a:3:{s:4:"name";s:14:"Palanquin Dark";s:8:"variants";s:19:"regular,500,600,700";s:8:"fallback";s:10:"sans-serif";}s:5:"laila";a:3:{s:4:"name";s:5:"Laila";s:8:"variants";s:23:"300,regular,500,600,700";s:8:"fallback";s:5:"serif";}s:6:"smokum";a:3:{s:4:"name";s:6:"Smokum";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"mrs_sheppards";a:3:{s:4:"name";s:13:"Mrs Sheppards";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:11:"meie_script";a:3:{s:4:"name";s:11:"Meie Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:10:"goblin_one";a:3:{s:4:"name";s:10:"Goblin One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"ewert";a:3:{s:4:"name";s:5:"Ewert";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"seymour_one";a:3:{s:4:"name";s:11:"Seymour One";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:5:"bokor";a:3:{s:4:"name";s:5:"Bokor";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"chicle";a:3:{s:4:"name";s:6:"Chicle";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"butterfly_kids";a:3:{s:4:"name";s:14:"Butterfly Kids";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"nova_cut";a:3:{s:4:"name";s:8:"Nova Cut";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"nova_script";a:3:{s:4:"name";s:11:"Nova Script";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"felipa";a:3:{s:4:"name";s:6:"Felipa";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"siemreap";a:3:{s:4:"name";s:8:"Siemreap";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"revalia";a:3:{s:4:"name";s:7:"Revalia";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"princess_sofia";a:3:{s:4:"name";s:14:"Princess Sofia";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:18:"macondo_swash_caps";a:3:{s:4:"name";s:18:"Macondo Swash Caps";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"romanesco";a:3:{s:4:"name";s:9:"Romanesco";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:8:"federant";a:3:{s:4:"name";s:8:"Federant";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"rum_raisin";a:3:{s:4:"name";s:10:"Rum Raisin";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"nova_oval";a:3:{s:4:"name";s:9:"Nova Oval";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"spirax";a:3:{s:4:"name";s:6:"Spirax";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"molle";a:3:{s:4:"name";s:5:"Molle";s:8:"variants";s:6:"italic";s:8:"fallback";s:11:"handwriting";}s:16:"almendra_display";a:3:{s:4:"name";s:16:"Almendra Display";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"ranga";a:3:{s:4:"name";s:5:"Ranga";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:7:"display";}s:7:"dangrek";a:3:{s:4:"name";s:7:"Dangrek";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"geostar";a:3:{s:4:"name";s:7:"Geostar";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"marko_one";a:3:{s:4:"name";s:9:"Marko One";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:8:"chonburi";a:3:{s:4:"name";s:8:"Chonburi";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:16:"londrina_outline";a:3:{s:4:"name";s:16:"Londrina Outline";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"dhurjati";a:3:{s:4:"name";s:8:"Dhurjati";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:7:"plaster";a:3:{s:4:"name";s:7:"Plaster";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"diplomata_sc";a:3:{s:4:"name";s:12:"Diplomata SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:4:"moul";a:3:{s:4:"name";s:4:"Moul";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:16:"supermercado_one";a:3:{s:4:"name";s:16:"Supermercado One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"chela_one";a:3:{s:4:"name";s:9:"Chela One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"eater";a:3:{s:4:"name";s:5:"Eater";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"vesper_libre";a:3:{s:4:"name";s:12:"Vesper Libre";s:8:"variants";s:19:"regular,500,700,900";s:8:"fallback";s:5:"serif";}s:14:"uncial_antiqua";a:3:{s:4:"name";s:14:"Uncial Antiqua";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"ramaraja";a:3:{s:4:"name";s:8:"Ramaraja";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"amita";a:3:{s:4:"name";s:5:"Amita";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:11:"handwriting";}s:5:"bayon";a:3:{s:4:"name";s:5:"Bayon";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"miss_fajardose";a:3:{s:4:"name";s:14:"Miss Fajardose";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:13:"rhodium_libre";a:3:{s:4:"name";s:13:"Rhodium Libre";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:13:"bigelow_rules";a:3:{s:4:"name";s:13:"Bigelow Rules";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"macondo";a:3:{s:4:"name";s:7:"Macondo";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:4:"arya";a:3:{s:4:"name";s:4:"Arya";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:10:"sans-serif";}s:13:"stalinist_one";a:3:{s:4:"name";s:13:"Stalinist One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"metal";a:3:{s:4:"name";s:5:"Metal";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:9:"sevillana";a:3:{s:4:"name";s:9:"Sevillana";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"arbutus";a:3:{s:4:"name";s:7:"Arbutus";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:13:"sirin_stencil";a:3:{s:4:"name";s:13:"Sirin Stencil";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"bonbon";a:3:{s:4:"name";s:6:"Bonbon";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"koulen";a:3:{s:4:"name";s:6:"Koulen";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"taprom";a:3:{s:4:"name";s:6:"Taprom";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:10:"mr_bedfort";a:3:{s:4:"name";s:10:"Mr Bedfort";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:6:"gidugu";a:3:{s:4:"name";s:6:"Gidugu";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:6:"risque";a:3:{s:4:"name";s:6:"Risque";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:6:"chenla";a:3:{s:4:"name";s:6:"Chenla";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"almendra_sc";a:3:{s:4:"name";s:11:"Almendra SC";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:7:"flavors";a:3:{s:4:"name";s:7:"Flavors";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"emblema_one";a:3:{s:4:"name";s:11:"Emblema One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:14:"odor_mean_chey";a:3:{s:4:"name";s:14:"Odor Mean Chey";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"ruge_boogie";a:3:{s:4:"name";s:11:"Ruge Boogie";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:14:"jim_nightshade";a:3:{s:4:"name";s:14:"Jim Nightshade";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:7:"tillana";a:3:{s:4:"name";s:7:"Tillana";s:8:"variants";s:23:"regular,500,600,700,800";s:8:"fallback";s:11:"handwriting";}s:9:"erica_one";a:3:{s:4:"name";s:9:"Erica One";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:11:"preahvihear";a:3:{s:4:"name";s:11:"Preahvihear";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:18:"tenali_ramakrishna";a:3:{s:4:"name";s:18:"Tenali Ramakrishna";s:8:"variants";s:7:"regular";s:8:"fallback";s:10:"sans-serif";}s:9:"kantumruy";a:3:{s:4:"name";s:9:"Kantumruy";s:8:"variants";s:15:"300,regular,700";s:8:"fallback";s:10:"sans-serif";}s:9:"suravaram";a:3:{s:4:"name";s:9:"Suravaram";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:11:"lakki_reddy";a:3:{s:4:"name";s:11:"Lakki Reddy";s:8:"variants";s:7:"regular";s:8:"fallback";s:11:"handwriting";}s:20:"sree_krushnadevaraya";a:3:{s:4:"name";s:20:"Sree Krushnadevaraya";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:6:"unlock";a:3:{s:4:"name";s:6:"Unlock";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"hanalei_fill";a:3:{s:4:"name";s:12:"Hanalei Fill";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:8:"fasthand";a:3:{s:4:"name";s:8:"Fasthand";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:8:"moulpali";a:3:{s:4:"name";s:8:"Moulpali";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:7:"sahitya";a:3:{s:4:"name";s:7:"Sahitya";s:8:"variants";s:11:"regular,700";s:8:"fallback";s:5:"serif";}s:7:"hanalei";a:3:{s:4:"name";s:7:"Hanalei";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:5:"eczar";a:3:{s:4:"name";s:5:"Eczar";s:8:"variants";s:23:"regular,500,600,700,800";s:8:"fallback";s:5:"serif";}s:14:"inknut_antiqua";a:3:{s:4:"name";s:14:"Inknut Antiqua";s:8:"variants";s:31:"300,regular,500,600,700,800,900";s:8:"fallback";s:5:"serif";}s:7:"fruktur";a:3:{s:4:"name";s:7:"Fruktur";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:4:"asar";a:3:{s:4:"name";s:4:"Asar";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:7:"peddana";a:3:{s:4:"name";s:7:"Peddana";s:8:"variants";s:7:"regular";s:8:"fallback";s:5:"serif";}s:5:"modak";a:3:{s:4:"name";s:5:"Modak";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}s:12:"ravi_prakash";a:3:{s:4:"name";s:12:"Ravi Prakash";s:8:"variants";s:7:"regular";s:8:"fallback";s:7:"display";}}');
    ksort($google_fonts_list);	
    return $google_fonts_list;
  } // google_fonts
  
    
  static function captcha_print() {
    $captcha_code = '<p><label for="ucp_captcha">Are you human? Please solve:';
    $captcha_code .= '<img class="ucp-captcha-img" src="' . plugins_url('captcha.php?ucp-generate-image=true&color=' . urlencode('#FFFFFF') . '&noise=0&rnd=' . rand(0, 10000), __FILE__) . '" alt="Captcha" />';
    $captcha_code .= '<input class="input" type="text" size="3" name="ucp_captcha" id="ucp_captcha" />';
    $captcha_code .= '</label></p><br />';
    return $captcha_code;
  } // captcha_print
   
    
  static function ucp_submit_form(){
    global $wpdb;
    
    if($_POST['fields']['ucp_captcha'] != $_SESSION['captcha']){
      wp_send_json_error('captcha');
      die(); 
    }
    
    unset($_POST['fields']['ucp_captcha']);    
    
    $name = isset($_POST['fields']['name'])?$_POST['fields']['name']:'';
    $email = isset($_POST['fields']['email'])?$_POST['fields']['email']:'';
    
    if(!is_email($email) || strlen($name)<1){
      wp_send_json_error('Please enter a valid name and email address!'); 
    }
    
    $fields = $_POST['fields'];
    unset($_POST['fields']['name']);
    unset($_POST['fields']['email']);
    $custom_fields = serialize($_POST['fields']);
    
    switch($_POST['form_sendto']){
      case 'mailchimp':
      UCP::mc_add_subscriber($fields);
      break;
      case 'zapier':
      UCP::zapier_send($fields);
      break;
      case 'autoresponder':
      UCP::autoresponder_send($fields);
      break;      
    }    
    
    //local
    $userip = UCP_utility::getUserIP();
    $userlocation = UCP_utility::getUserLocation($userip);
    $save_lead = $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->ucp_leads . '(`type`,`email`,`name`,`custom`,`timestamp`,`ip`,`location`,`user_agent`) VALUES(%s,%s,%s,%s,%s,%s,%s,%s)', $_POST['form_type'],$email,$name,$custom_fields,date("Y-m-d H:i:s"),$userip,$userlocation,$_SERVER['HTTP_USER_AGENT'] ) );
        
    if($save_lead == true){
      if(is_email($_POST['form_admin_email']) && strlen($_POST['form_email_subject'])>0 && strlen($_POST['form_email_body'])>0 ){
        wp_mail( $_POST['form_admin_email'], 'New UCP Contact form Message', 'From: ' . $name . ' ('.$email.') ' . "\n\n" . 'Phone:' . $fields['phone'] . "\n\n". 'Message:' . $fields['message'] );
        wp_mail( $email, $_POST['form_email_subject'], $_POST['form_email_body'] );
      }      
      wp_send_json_success('success');
    } else {
      wp_send_json_error('error');
    }
    die();
  } // ucp_submit_form
  
  static function display_template($template = false){
    ?>
    <!DOCTYPE html>
    <!--[if IE 8]>
    <html xmlns="http://www.w3.org/1999/xhtml" class="ie8 wp-toolbar"  lang="en-US">
    <![endif]-->
    <!--[if !(IE 8) ]><!-->
    <html xmlns="http://www.w3.org/1999/xhtml" class="wp-toolbar"  lang="en-US">
    <!--<![endif]-->
    <?php
        
    global $wpdb;
    $options = self::get_options();
    
    $template_html=false;
    if(isset($_GET['template'])){
      $template = $_GET['template']; 
    }
    
    if(isset($template)){
      $template_data = $wpdb->get_row($wpdb->prepare('SELECT page_title,page_desc,html FROM ' . $wpdb->ucp_templates . ' WHERE slug = %s LIMIT 1', $template));
    }
    
    wp_enqueue_style('ucp-font-awesome', UCP_PLUGIN_URL . 'css/font-awesome/font-awesome.min.css', array(), UCP::$version);
      
    wp_enqueue_script('ucp-frontend', UCP_PLUGIN_URL . 'js/ucp-frontend.js', array('jquery'), UCP::$version, true);
    
    wp_register_script( 'ucp-frontend', UCP_PLUGIN_URL . 'js/ucp-frontend.js' );
    $ucp_frontend_variables = array(
      'ucp_ajax_url' => admin_url( 'admin-ajax.php' )
    );
    wp_localize_script( 'ucp-frontend', 'ucp_frontend_variables', $ucp_frontend_variables );
    wp_enqueue_script( 'ucp-frontend' );
     
    //GA Tracking
    if ( $options['ga_track_events'] == '1' && !empty($options['ga_tracking_id'])) {
      echo "
      <script type=\"text/javascript\">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', '{$options['ga_tracking_id']}', 'auto');
        ga('send', 'pageview');
      </script>";
    }

      
    ?>
    <head>
    <?php
    ob_start();
    do_action('wp_head');
    $wp_head = ob_get_clean();
    
    if( $template_data && strlen($template_data->page_title)>0 ){
      $meta_description = '';
      $wp_head = preg_replace('/<title>(.*)<\/title>/siU', '<title>'.$template_data->page_title.'</title>', $wp_head);
      preg_match('/<meta\sname="description"\scontent="(.*)"/i', $meta_description, $version);
      echo '<pre>';
      print_r($meta_description);
      echo '</pre>';
      if($meta_description){
        preg_replace('/<meta\sname="description"\scontent="(.*)"/i', $template_data->page_desc, $wp_head);
      } else {
        $wp_head = $wp_head.'<meta name="description" content="'.$template_data->page_desc.'" />';
      }
    }
    
    echo $wp_head;
    
    //Check if we are using ParticlesJS
    if( $template_data && strpos($template_data->html,'ucp-animated-background')>0 ){
      echo '<script src="'.UCP_PLUGIN_URL.'js/particles.min.js" type="text/javascript"></script>'; 
    }
    
    //Check if we are using Flipclock
    if( $template_data && strpos($template_data->html,'ucp_countdown_flip')>0 ){
      echo '<link rel="stylesheet" href="'.UCP_PLUGIN_URL.'css/flipclock.css" />'; 
      echo '<script src="'.UCP_PLUGIN_URL.'js/flipclock.min.js" type="text/javascript"></script>'; 
    }
    
    //Check if we are using Text Countdown   
    if( $template_data && strpos($template_data->html,'ucp_countdown_text')>0 ){
      echo '<script src="'.UCP_PLUGIN_URL.'js/jquery.countdown.min.js" type="text/javascript"></script>'; 
    } else {
     echo '<script src="'.UCP_PLUGIN_URL.'js/jquery.countdown.min.js" type="text/javascript"></script>'; 
    }
    
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    
    <style id="ucp_template_default">
    /* CSS style reset */
    
    html, body, div, span, applet, object, iframe,
    h1, h2, h3, h4, h5, h6, p, blockquote, pre,
    a, abbr, acronym, address, big, cite, code,
    del, dfn, em, img, ins, kbd, q, s, samp,
    small, strike, strong, sub, sup, tt, var,
    b, u, i, center,
    dl, dt, dd, ol, ul, li,
    fieldset, form, label, legend,
    table, caption, tbody, tfoot, thead, tr, th, td,
    article, aside, canvas, details, embed, 
    figure, figcaption, footer, header, hgroup, 
    menu, nav, output, ruby, section, summary,
    time, mark, audio, video {
      margin: 0;
      padding: 0;
      border: 0;
      vertical-align: baseline;
    }
    /* HTML5 display-role reset for older browsers */
    article, aside, details, figcaption, figure, 
    footer, header, hgroup, menu, nav, section {
      display: block;
    }
    body {
      line-height: 1;
    }
    ol, ul {
      list-style: none;
    }
    blockquote, q {
      quotes: none;
    }
    blockquote:before, blockquote:after,
    q:before, q:after {
      content: '';
      content: none;
    }
    table {
      border-collapse: collapse;
      border-spacing: 0;
    }
    
    /* End style reset */
    
    body{
      width:100%;
      overflow-x:hidden;
      line-height: 1.3;
    }
    .container{
      font-family:'Open Sans', sans-serif;
    }
    
    .video-background {
      background: #000;
      position: fixed;
      top: 0; right: 0; bottom: 0; left: 0;
      z-index: -99;
    }
    .video-foreground,
    .video-background iframe{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
    
    @media (min-aspect-ratio: 16/9) {
      .video-foreground { height: 300%; top: -100%; }
    }
    @media (max-aspect-ratio: 16/9) {
      .video-foreground { width: 300%; left: -100%; }
    }
    @media all and (max-width: 600px) {
      .vid-info { width: 50%; padding: .5rem; }
      .vid-info h1 { margin-bottom: .2rem; }
    }
    @media all and (max-width: 500px) {
      .vid-info .acronym { display: none; }
    }
        
    #ucp-animated-background{
      background-color:#333;
      background: #000;
      position: fixed;
      top: 0; right: 0; bottom: 0; left: 0;
      z-index: -99;
    }
    
    h1,h2{
      text-align:center;
    }
    
    #ucp-template{
      overflow-x:hidden;
    }
    
    .ucp-module{
      box-sizing:border-box;
    }
    
    .ucp-module > .ucp-element{
      text-align:center;
      position:relative;
    }
    
    .ucp-element img{
      max-width:100%;
    }
    
    .socialicons{
      text-align:center;
    }
    .socialicons a{
      margin:0 4px;
    }
    
    .ucp-element input[type="text"],.ucp-element input[type="email"],.ucp-element input[type="tel"],.ucp-element textarea{
      font-size:14px;
      width:100%;
      margin-bottom:4px;
      padding:4px;
    }
    .ucp-element input[type="submit"]{
      font-size: 16px;
      width: 100%;
      padding:6px;
      border:none;
    }
    
    .fcountdown-timer{
      text-align:center;
      font-size:40px;
      color:#424242;
    }
    
    .ucp-element .button-large{
      color: rgb(255, 255, 255);
      font-size: 41px;
      background-color: rgb(255, 165, 0);
      text-align: center;
      border-radius:2px;
      padding:4px 10px;
      display: inline-block;
    }
    
    .ucp-element .button-large:hover{
      background-color: rgb(255, 207, 0);
      cursor:pointer;
      text-decoration:none;
    }
    
    .ucp-element .flip-clock-wrapper{
      font-size:26px !important;
    }
    
    .ucp-row .ucp-module{
        position: relative;
        box-sizing:content-box;
        min-height: 1px;
        padding-right: 0;
        padding-left: 0;
        background-position: center;
    }
    
    .ucp-element input,
    .ucp-element textarea{
      max-width:400px;
      margin-left:auto;
      margin-right:auto;
    }
    
    .divider{
      display:block;
      height:10px;
      width:100%;
    }
    
    h1.headingl{
      font-size:34px;
      padding:10px 0 10px 0;
    }
    
    h2.headings{
      font-size:24px;
      padding:10px 0 10px 0;
    }
    
    #ucp_captcha{
      display: inline-block;
      width: 40px;
      margin-left: 6px; 
    }
    
    .ucp-captcha-img{
      vertical-align:middle;
      margin:0 4px;
    }
    
    #ucp_template_footer_js{
      display:none;
    }
    
    .ucp-module .fcountdown-timer {
      width: auto;
      display: inline-block;
    }
    </style>
    
    
    
    
    </head>
    <body>
    
    
    
    <div id="ucp-template">
    <?php  
      if($template_data){
        $template_html = $template_data->html;
        if(!isset($_GET['ucp_editing'])){
          $template_html = str_replace('ucp_script_disabled','script',$template_html);
        }
        echo do_shortcode(stripslashes($template_html));
      } else {
      ?>
      
          <div class="container">
          
            <div class="ucp-row row ucp-row-empty">
               
            </div>
            <div class="ucp-new-page-message">
            Page is empty.<br /><br />
            <span><i class="fa fa-arrow-left" aria-hidden="true"></i> Add new elements from the sidebar.</span>
            </div>
      </div>
      
      <style id="ucp_template_style"></style> 
      <style id="ucp_template_custom_style"></style>
      
      <script type="text/javascript" id="ucp_template_animation_js"></script> 
      <?php 
      } 
    ?>
      
    </div>
    <?php 
    do_action('wp_footer');
    ?>
    </body>
  </html>
  <?php 
  } // display_template
} // class
