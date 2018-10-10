<?php
/*
 * UnderConstructionPage PRO
 * Interface - Tab - License
 * (c) Web factory Ltd, 2015 - 2017
 */

class UCP_tab_license extends UCP {
  static function display() {
    $options = parent::get_options();
    $meta = parent::get_meta();

    echo '<div class="tab-content">';
    echo '<table class="form-table">';
    echo '<tr>
          <th scope="row"><label for="license_key">' . __('License Key', 'under-construction-page') . '</label></th>
          <td><input class="regular-text" name="' . UCP_OPTIONS_KEY . '[license_key]" type="text" id="license_key" value="' . esc_attr($options['license_key']) . '" placeholder="12345678-12345678-12345678-12345678">
          <p class="description">License key is located in the confirmation email you received after purchasing.';
    if (!parent::is_activated()) {
      echo '<br>If you don\'t have a license - <a target="_blank" href="https://underconstructionpage.com/#pricing">purchase one now</a>; in case of problems <a href="#contact" data-tab="support" class="change_tab">contact support</a>.';
    }
    echo '</p></td></tr>';
    if (parent::is_activated()) {
      if ($options['license_expires'] == '2035-01-01') {
        $valid = 'indefinitely';
      } else {
        $valid = 'until ' . date('F jS, Y', strtotime($options['license_expires']));
        if (date('Y-m-d') == $options['license_expires']) {
          $valid .= '; expires today';
        } elseif (date('Y-m-d', time() + 30 * DAY_IN_SECONDS) > $options['license_expires']) {
          $tmp = (strtotime($options['license_expires'] . date(' G:i:s')) - time()) / DAY_IN_SECONDS;
          $valid .= '; expires in ' . round($tmp) . ' days';
        }
      }
      echo '<tr>
          <th scope="row"><label for="">' . __('License Status', 'under-construction-page') . '</label></th>
          <td><b style="color: #66b317;">Active</b><br>
          Type: ' . str_replace('pro', 'PRO', $options['license_type']);
      echo '<br>Valid ' . $valid . '</td>
          </tr>';
    } else {
      echo '<tr>
          <th scope="row"><label for="">' . __('License Key Status', 'under-construction-page') . '</label></th>
          <td><b style="color: #ea1919;">Inactive</b>';
      if (!empty($options['license_type'])) {
        echo '<br>Type: ' . $options['license_type'];
      }
      if (!empty($options['license_expires'])) {
        echo '<br>Expired on ' . date('F jS, Y', strtotime($options['license_expires']));
      }
      echo '</td></tr>';
    }
    echo '</table>';
    echo get_submit_button(__('Save and Validate License Key', 'under-construction-page'), 'primary large', 'submit-license', true, array());
    
    echo '</div>';
  } // display
} // class UCP_tab_license
