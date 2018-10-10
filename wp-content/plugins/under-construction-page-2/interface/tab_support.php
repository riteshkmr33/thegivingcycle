<?php
/*
 * UnderConstructionPage PRO
 * Interface - Tab - Support
 * (c) Web factory Ltd, 2015 - 2017
 */

class UCP_tab_support extends UCP {
  static function display() {
    $options = parent::get_options();

    
    
    echo '<div id="tabs_support" class="ui-tabs ucp-tabs-2nd-level">';
    echo '<ul>';
    echo '<li><a href="#tab_support_faq">FAQ</a></li>';
    echo '<li><a href="#tab_support_contact">Contact Support</a></li>';
    echo '</ul>';
    
    if (self::is_activated()) {
      
      echo '<div style="display: none;" id="tab_support_faq" class="ucp-tab-content">';
      if (self::is_activated()) {
        
        echo '<p><b>How can I work on my site while construction mode is enabled?</b><br>Make sure your user role (probably administrator) is selected under <a class="change_tab" data-tab="access" href="#whitelisted-roles">Access - Whitelisted User Roles</a> and open the site while logged in. You can also <a class="change_tab" data-tab="access" href="#whitelisted_ips">whitelist your IP address</a>.</p>';
  
        echo '<p><b>How can I log in / access WordPress admin after construction mode has been enabled?</b><br>Enable the <a class="change_tab" data-tab="content" href="#login_button_wrap">Login Button</a> option under Content, and a login link will be shown in the lower right corner of the under construction page.</p>';
  
        echo '<p><b>How do I add my logo to the page?</b><br>Head over to <a class="change_tab" data-tab="content" href="#content_wrap">Content</a> and click "Add Media". Upload/select the logo, position it as you see fit and add other content.</p>';
  
        echo '<p><b>I\'ve made changes to UCP, but they are not visible. What do I do?</b><br>Click "Save Changes" one more time. Open your site and force refresh browser cache (Ctrl or Shift + F5). If that doesn\'t help it means you have a caching plugin installed. Purge/delete cache in that plugin or disable it.</p>';
  
        echo '<p><b>How can I get more designs? Where do I download them?</b><br>We update the plugin every 7-10 days and each update comes with at least one new theme/design. There is no other way of getting more designs nor a place to download them.</p>';
  
        echo '<p><b>How can I edit designs?</b><br>There is an option to add <a class="change_tab" data-tab="design" href="#custom_css">custom CSS</a>. If you want more than that you will have to edit the source files located in <code>/under-construction-page/themes/</code>.</p>';
  
        echo '<p><b>I have disabled UCP but the under construction page is still visible. How do I remove it?</b><br>Open your site and force refresh browser cache (Ctrl or Shift + F5). If that doesn\'t help it means you have a caching plugin installed. Purge/delete cache in that plugin or disable it.<br>If that fails too contact your hosting provider and ask to empty the site cache for you.</p>';
      }
      echo '</div>'; // faq
    
    }
    echo '<div style="display: none;" id="tab_support_contact" class="ucp-tab-content">';
    
    $user = wp_get_current_user();
    $theme = wp_get_theme();

    echo '<p>Something is not working the way it\'s suppose to? Having problems with the license or activating UCP? Contact our friendly support, they\'ll respond ASAP!</p>';

    echo '<table class="form-table">';
    echo '<tr valign="top">
    <th scope="row"><label for="support_email">Your Email Address</label></th>
    <td><input id="support_email" type="email" class="regular-text skip-save" name="support_email" value="' . $user->user_email . '" placeholder="name@domain.com">';
    echo '<p class="description">We will reply to this email, so please, double-check it.</p>';
    echo '</td></tr>';

    echo '<tr valign="top">
    <th scope="row"><label for="support_message">Message</label></th>
    <td><textarea rows="5" cols="75" id="support_message" class="skip-save" name="support_message" placeholder="Let us know how we can help you"></textarea>';
    echo '<p class="description">Please be as descriptive as possible. It will help us to provide faster &amp; better support.</p>';
    echo '</td></tr>';

    echo '<tr valign="top">
    <th scope="row"><label for="">Site Info</label></th>
    <td>';
    echo 'WordPress version: <code>' . get_bloginfo('version') . '</code><br>';
    echo 'UCP version: <code>' . self::$version . '</code><br>';
    echo 'Site URL: <code>' . get_bloginfo('url') . '</code><br>';
    echo 'WordPress URL: <code>' . get_bloginfo('wpurl') . '</code><br>';
    echo 'Theme: <code>' . $theme->get('Name') . ' v' . $theme->get('Version') . '</code><br>';
    if (self::is_activated()) {
      echo 'License key: <code>' . $options['license_key'] . '</code><br>';
      echo 'License details: <code>' . $options['license_type'] . ', ';
      if ($options['license_expires'] == '2035-01-01') {
        echo 'lifetime license';
      } else {
        echo  'expires on ' . $options['license_expires'];
      }
      echo '</code><br>';
    } else {
      echo 'License key: <code>' . (empty($options['license_key'])? 'n/a': $options['license_key']) . '</code><br>';
    }
    echo '<p class="description">Our support agents will receive this info. They need it to provide faster &amp; better support to you.</p>';
    echo '</td></tr>';

    echo '<tr valign="top">
    <th scope="row"><a href="#" class="js-action button button-primary button-large" id="ucp-send-support-message">Send Message to Support</a></th>
    <td>&nbsp;';
    echo '</td></tr>';

    echo '</table>';
    
    echo '</div>'; // contact
    
    echo '</div>'; // tabs
  } // display
} // class UCP_tab_support
