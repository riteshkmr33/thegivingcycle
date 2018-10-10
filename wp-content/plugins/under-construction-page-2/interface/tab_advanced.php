<?php
/*
 * UnderConstructionPage PRO
 * Interface - Tab - Advanced
 * (c) Web factory Ltd, 2015 - 2017
 */

class UCP_tab_advanced extends UCP {
  static function display() {
    $tabs[] = array('id' => 'tab_advanced_services', 'class' => 'tab-content', 'label' => __('External Services', 'under-construction-page'), 'callback' => array(__CLASS__, 'tab_services'));
    $tabs[] = array('id' => 'tab_advanced_misc', 'class' => 'tab-content', 'label' => __('Miscellaneous', 'under-construction-page'), 'callback' => array(__CLASS__, 'tab_misc'));
    $tabs[] = array('id' => 'tab_advanced_advanced', 'class' => 'tab-content', 'label' => __('Advanced', 'under-construction-page'), 'callback' => array(__CLASS__, 'tab_advanced'));
    $tabs[] = array('id' => 'tab_advanced_tools', 'class' => 'tab-content', 'label' => __('Tools', 'under-construction-page'), 'callback' => array(__CLASS__, 'tab_tools'));
    $tabs[] = array('id' => 'tab_advanced_affiliates', 'class' => 'tab-content', 'label' => __('Affiliate Links', 'under-construction-page'), 'callback' => array(__CLASS__, 'tab_affiliates'));
    
    echo '<div id="tabs_advanced" class="ui-tabs ucp-tabs-2nd-level">';
    echo '<ul>';
    foreach ($tabs as $tab) {
      echo '<li><a href="#' . $tab['id'] . '">' . $tab['label'] . '</a></li>';
    }
    echo '</ul>';

    foreach ($tabs as $tab) {
      if(is_callable($tab['callback'])) {
        echo '<div style="display: none;" id="' . $tab['id'] . '" class="' . $tab['class'] . '">';
        call_user_func($tab['callback']);
        echo '</div>';
      }
    } // foreach
    echo '</div>'; // second level of tabs
    
    self::dialogs();
  } // display


  // todo
  static function dialogs() {
    echo '<div id="autoresponder-config-dialog" style="display: none;" title="UI Dialog"><span class="ui-helper-hidden-accessible"><input type="text"></span>';
    echo '<table class="form-table">';

    echo '<tr>';
    echo '<th><label for="autoresponder_html">Autoresponder Form HTML Code</label></th>';
    echo '<td><textarea rows="7" class="code" name="autoresponder_html" id="autoresponder_html">';
    echo '</textarea>';
    echo '<p class="description">todo To limit access to the site and prevent abuse, the link can automatically expire after a specified date/time, or certain amount of actions performed by users.</p></td>';
    echo '</tr>';

    echo '<tr id="link_expire_value_container_number">';
    echo '<th><label for="link_expire_value">Detected Values</label></th>';
    echo '<td><div id="form-fields-preview" data-default="Paste the form HTML code in the field above"><i>Paste the form HTML code in the field above</i></div>';
    echo '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th>';
    echo '<a style="display: none;" href="#" class="js-action button button-primary" id="fill-form-values">Use Detected Values</a></th>';
    echo '<td class="textright"><a href="#" class="js-action button button-secondary ucp-close-ui-dialog">Cancel</a></td>';
    echo '</tr>';

    echo '</table>';
    echo '</div>'; // autoresponder config dialog
    
    echo '<div id="affiliate-link-dialog" style="display: none;" title="UI Dialog"><span class="ui-helper-hidden-accessible"><input type="text"></span>';
    echo '<table class="form-table">';

    echo '<tr>';
    echo '<th><label for="link_name2">Name / Description</label></th>';
    echo '<td><input type="text" value="" class="regular-text" name="link_name2" id="link_name2" placeholder="Twitter traffic">';
    echo '<p class="description">For internal use only.</p></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th>';
    echo '<input type="hidden" name="link_id2" id="link_id2">';
    echo '<a href="#" class="js-action button button-primary" id="save-new-affiliate-link"><span class="dashicons dashicons-update"></span>Add New Affiliate Link</a><a href="#" class="js-action button button-primary" id="save-affiliate-link"><span class="dashicons dashicons-update"></span>Save Changes</a></th>';
    echo '<td class="textright"><a href="#" class="js-action button button-secondary ucp-close-ui-dialog">Cancel</a></td>';
    echo '</tr>';

    echo '</table>';
    echo '</div>'; // affiliate link dialog
  } // dialogs
  
  
  static function tab_services() {
    $options = parent::get_options();
    $autoresponder_methods = array(array('val' => 'post', 'label' => __('POST', 'under-construction-page')),
                                   array('val' => 'get', 'label' => __('GET', 'under-construction-page')));

    echo '<table class="form-table">';

    echo '<tr>';
    echo '<th><label for="">Local Database</label></th>';
    echo '<td>';
    echo '<p class="description">All contact form and newsletter form submissions are automatically saved to the local database and available as <a href="#" class="change_tab" data-tab="leads">Leads</a>.<br>There is no need to configure anything.</p></td>';
    echo '</tr>';
    
    if(UCP::get_licence_type()>=2){    
      echo '<tr>
      <th scope="row"><label for="">MailChimp</label></th>
      <td>';
      echo '<div id="mc_api_key_wrapper" class="field_wrapper">';
      echo '<label for="mc_api_key">API Key</label>';
      echo '<input id="mc_api_key" type="text" class="regular-text code" name="' . UCP_OPTIONS_KEY . '[mc_api_key]' . '" value="' . esc_attr($options['mc_api_key']) . '" placeholder="685458ab84eefb58244addc54ef54c-us3">';
      echo '</div>';
  
      echo '<div id="mc_list_wrapper" class="field_wrapper">';
      echo '<label for="mc_list">Lists</label>';
  
      if (empty($options['mc_lists'])) {
        $options['mc_lists'][] = array('val' => '', 'label' => 'no MailChimp lists available');
      }
  
      echo '<select name="' . UCP_OPTIONS_KEY . '[mc_list]' . '" id="mc_list">';
      UCP_utility::create_select_options($options['mc_lists'], $options['mc_list']);
      echo '</select> <a id="refresh-mc-lists" href="#" class="js-action button button-secondary"><span class="dashicons dashicons-update"></span>Refresh lists</a>';
      echo '</div>';
      
      echo '<div id="" class="field_wrapper">';
      echo '<label for="mc_double_optin" style="margin: -13px 8px 0 0;">Double Optin</label>';
      UCP_utility::create_toogle_switch('mc_double_optin', array('saved_value' => $options['mc_double_optin'], 'option_key' => UCP_OPTIONS_KEY . '[mc_double_optin]'));
      echo '</div>';
  
      echo '<p class="description">MailChimp API keys are located in <a href="https://us2.admin.mailchimp.com/account/api/" target="_blank">Account - Extras - API keys</a> on MC.<br>Besides lists UCP also pulls in list segments. Select them if you want to add emails to a specific segment.</p>';
      echo '</td></tr>';
    } // MC
    
    if(UCP::get_licence_type()>=3){
      echo '<tr>
      <th scope="row"><label for="zapier_webhook_url">Zapier Webhook URL</label></th>
      <td>';
      echo '<input id="zapier_webhook_url" type="url" class="regular-text code" name="' . UCP_OPTIONS_KEY . '[zapier_webhook_url]' . '" value="' . esc_attr($options['zapier_webhook_url']) . '" placeholder="https://hooks.zapier.com/hooks/catch/548698/haabef/">';
      echo '<p class="description">Create a Zap with the "Webhooks by Zapier" as the trigger app and configure it as a "catch hook". Under "View Webhook" you\'ll see an URL - copy/paste it above.<br>UCP sends the following fields on every newsletter form submit: email TODO</p>';
      echo '</td></tr>';
    } // Zapier
    
    if(UCP::get_licence_type()>=2){
      echo '<tr>
      <th scope="row"><label for="autoresponder_action_url">Universal Autoresponder</label></th>
      <td>';
  
      echo '<div class="field_wrapper">';
      echo '<a href="#" class="js-action button button-secondary configure-autoresponder">Auto Configure Autoresponder</a>';
      echo '</div>';
  
      echo '<div class="field_wrapper">';
      echo '<label for="autoresponder_action_url">Form Action URL</label>';
      echo '<input id="autoresponder_action_url" type="text" class="regular-text code" name="' . UCP_OPTIONS_KEY . '[autoresponder_action_url]' . '" value="' . esc_attr($options['autoresponder_action_url']) . '" placeholder="https://">';
      echo '</div>';
  
      echo '<div class="field_wrapper">';
      echo '<label for="autoresponder_method">Form Method</label>';
      echo '<select name="' . UCP_OPTIONS_KEY . '[autoresponder_method]' . '" id="autoresponder_method">';
      UCP_utility::create_select_options($autoresponder_methods, $options['autoresponder_method']);
      echo '</select>';
      echo '</div>';
  
      echo '<div class="field_wrapper">';
      echo '<label for="autoresponder_email_field">Email Field Name</label>';
      echo '<input id="autoresponder_email_field" type="text" class="regular-text" name="' . UCP_OPTIONS_KEY . '[autoresponder_email_field]' . '" value="' . esc_attr($options['autoresponder_email_field']) . '" placeholder="email">';
      echo '</div>';
  
      echo '<div class="field_wrapper">';
      echo '<label for="autoresponder_name_field">Name Field Name</label>';
      echo '<input id="autoresponder_name_field" type="text" class="regular-text" name="' . UCP_OPTIONS_KEY . '[autoresponder_name_field]' . '" value="' . esc_attr($options['autoresponder_name_field']) . '" placeholder="name">';
      echo '</div>';
  
      echo '<div class="field_wrapper">';
      echo '<label for="autoresponder_extra_data">Additional Data</label>';
      echo '<input id="autoresponder_extra_data" type="text" class="regular-text" name="' . UCP_OPTIONS_KEY . '[autoresponder_extra_data]' . '" value="' . esc_attr($options['autoresponder_extra_data']) . '" placeholder="field1=data1&field2=value2">';
      echo '</div>';
  
      echo '<p class="description">Any autoresponder that can generate an HTML form can work with UCP. Generate the form, open the <a href="" class="js-action configure-autoresponder">auto configurator</a> and paste the HTML code.</p>';
      echo '</td></tr>';
    }
    echo '</table>';

    parent::footer_save_button();
  } // tab_services
  
  
  static function tab_misc() {
    $options = parent::get_options();
    
    echo '<table class="form-table">';
    
    echo '<tr valign="top">
    <th scope="row"><label for="ga_tracking_toggle">' . __('Google Analytics Tracking', 'under-construction-page') . '</label></th>
    <td>';
    UCP_utility::create_toogle_switch('ga_tracking_toggle', array('saved_value' => (empty($options['ga_tracking_id']) || strlen($options['ga_tracking_id']) < 10)? 0: 1, 'option_key' => UCP_OPTIONS_KEY . '[ga_tracking_toggle]'));
    echo '<p class="description">TODO Google Analytics has to be configured in the customizer for the active template in order for this option to work! Tracked events: page scrolling, conversions and outgoing clicks.</p>';
    
    echo '<div id="ga_tracking_wrapper">';
    echo '<div class="field_wrapper"><br><label for="ga_tracking_id"><b>Tracking ID</b></label><input id="ga_tracking_id" type="text" class="code" name="' . UCP_OPTIONS_KEY . '[ga_tracking_id]" value="' . esc_attr($options['ga_tracking_id']) . '" placeholder="UA-xxxxxx-xx">';
    echo '<p class="description">' . __('Unique tracking ID is found in your GA tracking profile settings.', 'under-construction-page') . '</p></div>';

    if(UCP::get_licence_type() >= 2) {    
      echo '<div class="field_wrapper"><br><label style="margin-top: -8px;" for="ga_track_events"><b>Track Events with GA</b></label>';
      UCP_utility::create_toogle_switch('ga_track_events', array('saved_value' => $options['ga_track_events'], 'option_key' => UCP_OPTIONS_KEY . '[ga_track_events]'));
        echo '<p class="description">todo Tracked events: page scrolling, conversions and outgoing clicks.</p>';
      echo '</div>';
    }
    
    echo '</div>'; // ga_tracking_wrapper
    echo '</td></tr>';
    
    echo '<tr>
    <th scope="row"><label for="no_index">Discourage Search Engines</label></th>
    <td>';
    UCP_utility::create_toogle_switch('no_index', array('saved_value' => $options['no_index'], 'option_key' => UCP_OPTIONS_KEY . '[no_index]'));
    echo '<p class="description">It is up to search engines to honor this option but when enabled a "noindex" directive will be set in robots.txt, HTTP headers and meta tags.</p>';
    echo '</td></tr>';
    
    echo '</table>';

    parent::footer_save_button();
  } // tab_misc
  
  
  static function tab_advanced() {
    $options = parent::get_options();
    
    echo '<table class="form-table">';

    echo '<tr>
    <th scope="row"><label for="send_nocache_headers">Send no-cache Headers</label></th>
    <td>';
    UCP_utility::create_toogle_switch('send_nocache_headers', array('saved_value' => $options['send_nocache_headers'], 'option_key' => UCP_OPTIONS_KEY . '[send_nocache_headers]'));
    echo '<p class="description">If you want to be sure browsers don\'t catch your under construction page and users see the normal site as soon as you disable UCP - enable no-cache header. Trade-off is a barely noticable speed loss.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="disable_feeds">Disable Feeds</label></th>
    <td>';
    UCP_utility::create_toogle_switch('disable_feeds', array('saved_value' => $options['disable_feeds'], 'option_key' => UCP_OPTIONS_KEY . '[disable_feeds]'));
    echo '<p class="description">Prevent any access to your content by disabling content feeds such as RSS. All access rules apply.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="disable_rpc">Disable RPC</label></th>
    <td>';
    UCP_utility::create_toogle_switch('disable_rpc', array('saved_value' => $options['disable_rpc'], 'option_key' => UCP_OPTIONS_KEY . '[disable_rpc]'));
    echo '<p class="description">Prevent 3rd party apps from interacting with your site by disabling RPC. All access rules apply.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="disable_rest_api">Disable REST API</label></th>
    <td>';
    UCP_utility::create_toogle_switch('disable_rest_api', array('saved_value' => $options['disable_rest_api'], 'option_key' => UCP_OPTIONS_KEY . '[disable_rest_api]'));
    echo '<p class="description">Prevent 3rd party apps from interacting with your site by disabling REST API. All access rules apply.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="redirect_toggle">Redirect to URL Instead of Displaying UCP</label></th>
    <td>';
    UCP_utility::create_toogle_switch('redirect_toggle', array('saved_value' => !empty($options['redirect']), 'option_key' => UCP_OPTIONS_KEY . '[redirect_toggle]'));
    echo '<div id="redirect_wrapper" class="field_wrapper">';
    echo '<label for="redirect">Redirect to URL: </label>';
    echo '<input id="redirect" type="url" class="regular-text code" name="' . UCP_OPTIONS_KEY . '[redirect]' . '" value="' . esc_attr($options['redirect']) . '" placeholder="https://">';
    echo '</div>';
    echo '<p class="description">Instead of showing the under construcion page users will be redirected (HTTP code 302) to the specified URL. All access rules still apply! Those who are whitelisted in any way will see the normal site.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="shortcodes">Enable 3rd Party Shortcodes &amp; CSS/JS files</label></th>
    <td>';
    UCP_utility::create_toogle_switch('shortcodes', array('saved_value' => $options['shortcodes'], 'option_key' => UCP_OPTIONS_KEY . '[shortcodes]'));
    echo '<p class="description">If you\'re not using 3rd party shortcodes and are having problems with plugins adding CSS/JS code to your under construction pages - disable this option.</p>';
    echo '</td></tr>';
    
    if (UCP::get_licence_type() >= 2) {
      echo '<tr>
      <th scope="row"><label for="affiliate_cookie_lifetime">Affiliate Cookie Lifetime</label></th>
      <td>';
      echo '<input name="' . UCP_OPTIONS_KEY . '[affiliate_cookie_lifetime]' . '" type="number" min="1" max="700" step="1" placeholder="60" id="affiliate_cookie_lifetime" class="small-text" value="' . $options['affiliate_cookie_lifetime'] . '"> days';
      echo '<p class="description">Lifetime in days for affiliate cookies after which they expire and actions are no longer attributed to that affiliate. Industry standard is 60 days.</p>';
      echo '</td></tr>';
    }

    echo '</table>';

    parent::footer_save_button();
  } // tab_advanced
  
  
  static function tab_tools() {
    echo '<table class="form-table">';

    echo '<tr>
    <th scope="row"><label for="">Export Settings</label></th>
    <td><a href="' . add_query_arg(array('action' => 'ucp_export_settings'), admin_url('admin.php')) . '" class="button button-secondary">Export Settings</a>';
    echo '<p class="description">The export file contains only settings. Templates are not included and have to be exported separately, from the customizer. License related data is also not included.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="">Import Settings</label></th>
    <td><input type="file" name="ucp_settings_import" id="ucp_settings_import" accept=".txt"><input type="submit" name="submit-import" id="submit-import" class="button button-secondary confirm_action" data-confirm="Are you sure you want to import settings? All current settings will be overwritten. There is NO UNDO!" value="Import Settings">';
    echo '<p class="description">Import only TXT export files generated by UCP. On import, all settings are overwritten. There is NO undo.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="">Reset Statistics</label></th>
    <td><a href="' . add_query_arg(array('action' => 'ucp_reset_stats', 'redirect' => urlencode($_SERVER['REQUEST_URI'])), admin_url('admin.php')) . '" class="button button-secondary confirm_action" data-confirm="Are you sure you want to reset all statistics? There is NO UNDO!">Reset Statistics</a>';
    echo '<p class="description">All statistics visible on the <a href="#" data-tab="main" class="change_tab">Main</a> tab will be reset. This does not include Direct Access Links stats or Affiliate stats.</p>';
    echo '</td></tr>';

    echo '<tr>
    <th scope="row"><label for="">Reset All Settings</label></th>
    <td>';
    echo '<a href="' . add_query_arg(array('action' => 'ucp_reset_settings', 'redirect' => urlencode($_SERVER['REQUEST_URI'])), admin_url('admin.php')) . '" class="button button-secondary confirm_action" data-confirm="Are you sure you want to reset all settings? There is NO UNDO!">Reset All Settings</a>';
    echo '<p class="description">All settings including Direct Access Links and Affiliate links will be reset to default. Leads and stats are not affected by the reset, nor are the templates. There is NO undo.</p>';
    echo '</td></tr>';

    echo '</table>';
  } // tab_tools
  
  
  static function tab_affiliates() {
    if( UCP::get_licence_type() >= 2) {
      global $wpdb;
      $options = parent::get_options();
      $links = array();
  
      $links = $wpdb->get_results('SELECT * FROM ' . $wpdb->ucp_links . ' WHERE type = "affiliate" ORDER BY id ASC');
      
      echo '<table id="affiliate_links" class="condensed">
        <tr class="header">
          <th class="actions"><a data-tooltip="Add new affiliate link" href="#" class="js-action add-affiliate-link"><span class="dashicons dashicons-plus"></span></a><a data-tooltip="Delete all affiliate links" class="js-action delete-action delete-all-affiliate-links" href="#"><span class="dashicons dashicons-trash"></span></a></th>
          <th>Name / Description</th>
          <th>Link</th>
          <th class="narrow">Sessions</th>
          <th class="narrow">Views</th>
          <th class="narrow">Conversions</th>
        </tr>';
  
      foreach ($links as $link) {
        if (!$link->sessions || !$link->conversions) {
          $conversions = '';
        } else {
          $conversions = ' (';
          $conversions .= number_format(100 * $link->conversions / $link->sessions, 1);
          $conversions .= '%)';
        }
  
        echo '<tr data-link-id="' . esc_attr($link->id) . '" data-link-name="' . esc_attr($link->name) . '">';
        echo '<td class="actions"><a data-tooltip="Edit affiliate link" class="js-action edit-action edit-affiliate-link" href="#"><span class="dashicons dashicons-edit"></span></a><a data-tooltip="Delete affiliate link" class="js-action delete-action delete-affiliate-link" href="#"><span class="dashicons dashicons-trash"></span></a></td>';
        $time_tooltip = 'Created on ' . $link->created;
        if ($link->modified && $link->modified[0] != '0') {
          $time_tooltip .= '; modified on ' . $link->modified;
        }
  
        echo '<td><span data-tooltip="' . esc_attr($time_tooltip) . '" class="link_name">' . esc_html($link->name) . '</span></td>';
        $short_link = trailingslashit(str_replace(array('https://', 'http://'), '', get_bloginfo('url')));
        echo '<td><code class="clipboard-copy tooltipped" title="Click to copy link to clipboard" data-tooltip="Click to copy link to clipboard" data-clipboard-text="' . trailingslashit(get_bloginfo('url')) . '?ucp-aff=' . $link->secret_key . '">' . $short_link . '?ucp-aff=' . $link->secret_key . '</code></td>';
        echo '<td class="narrow">' . number_format($link->sessions, 0) . '</td>';
        echo '<td class="narrow">' . number_format($link->views, 0) . '</td>';
        echo '<td class="narrow">' . number_format($link->conversions, 0) . $conversions . '</td>';
        echo '</tr>';
      } // foreach link
      echo '</table>';
      
      echo '<p class="' . (!empty($links)? 'hidden': '') . '" id="no-affiliate-links">You don\'t have any Affiliate Links. <a href="#" class="js-action add-affiliate-link">Create one</a> to start tracking traffic and conversions coming to your under construction pages.</p>';  
      
      echo '<p class="description tab-content"><br>Affiliate Links enable you to track traffic and conversions coming to your under construction page from various sources. On the first visit, users are given a cookie with a lifetime of ' . $options['affiliate_cookie_lifetime'] . ' days and the "users" counter is incremented by one, as well as the views counter. All continuing visits (in ' . $options['affiliate_cookie_lifetime'] . ' days, for that user) are counted only as views. During that period all conversions will also be added to the appropriate affiliate link.<br>
      Affiliate links are ignored for whitelisted users and no sessions, views or conversions are incremented if the user views the normal site.</p>';
    } else {
      echo '<p>Upgrade to UnderConstructionPage Pro to enable Affiliate Links</p>';
    }
  } // tab_affiliates
} // class UCP_tab_advanced
