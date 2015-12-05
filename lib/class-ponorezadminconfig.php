<?php
/**
 * Admin screens for PonoRez configuration.
 */

final class PonoRezAdminConfig {

    /* Build the default admin page. */
    static public function adminConfigPage () {
        $psc = PR()->providerService();
        $serviceCreds = PR()->serviceLogin();
        $activities = array();
        
        // Look up the info if we have the login.
        if ($serviceCreds['username']) {
            $activities = $psc->getActivities(array('serviceLogin' => $serviceCreds))
                        ->return;
        }
   ?>
<div class="wrap"><div id="icon-tools" class="icon32"></div>
  <h2>PonoRez Account Configuration</h2>
  <form id="prLoginForm">
    <?php 
          //settings_fields('pr-settings');
          //do_settings_sections('pr-settings'); 
       ?>
    <label for="pr_username"><b>Username:</b></label>
    <input id="pr_username" type="text" name="pr_username" value="<?php echo esc_attr(get_option('pr_username')); ?>" />
    <label for="pr_password"><b>Password:</b></label>
    <input id="pr_password" type="password" name="pr_password" value="<?php echo esc_attr(get_option('pr_password')); ?>" />
    <button id="loginButton" class="button button-primary">
      Save Changes
    </button>
    <div id="loginResult"></div>
  </form>
  <h2>Available Activities</h2>
  <table class="wp-list-table widefat">
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Island</th>
        <th>Description</th>
        <th>Notes</th>
        <th>Times</th>
        <th>Shortcode</th>
      </tr>
    </thead>
    <tbody id="the-list">
      <?php foreach ($activities as $act): ?>
      <tr>
        <th class="check-column" scope="row">
          <input type="checkbox" name="pr_activity_id_<?php echo $act->id; ?>" />
        </th>
        <td><strong><?php echo $act->name; ?></strong></td>
        <td><?php echo $act->island; ?></td>
        <td><?php echo $act->description; ?></td>
        <td><?php echo $act->notes; ?></td>
        <td><?php echo $act->times; ?></td>
        <td><code>[pr_activity id=<?php echo $act->id; ?>]</code></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script>
  jQuery(document).ready(function () {
    jQuery('#prLoginForm').submit(function(event) {
      var formData = {
        action      : 'pr_store_login',
        pr_username : jQuery('#pr_username').val(),
        pr_password : jQuery('#pr_password').val()
      };
      var resultDiv = jQuery('#loginResult');

      event.preventDefault();
      
      jQuery.post(ajaxurl, formData, function (result) {
        if (true == result['success']) {
          resultDiv.html('Information saved.');
        }
        else {
          resultDiv.html('Error: ' + result.message);
        }
      });
    });
  });
</script>
<?php
    }

    public function registerSettings () {
        register_setting('pr-settings', 'pr_username');
        register_setting('pr-settings', 'pr_password');
    }

    public function addSettingsMenu () {
        add_menu_page( 
            'A3H PonoRez for WordPress',
            'A3H PonoRez for WordPress',
            'manage_options', 
            'a3h_ponorez', 
            array('PonoRezAdminConfig', 'adminConfigPage')
        );
    }

    /**
     * Test the login information and store it. Return good information.
     */
    public function ajaxStoreLogin () {
        // Submitted parameters
        $username = $_POST['pr_username'];
        $password = $_POST['pr_password'];

        $psc = PR()->providerService();
        $testResult = $psc->testLogin(array('serviceLogin' => array('username' => $username,
                                                                    'password' => $password)));

        // Return values kept here.
        $ajaxResult = array();
        
        if (true == $testResult->return) {
            update_option('pr_username', $username);
            update_option('pr_password', $password);

            $ajaxResult['success'] = true;
        }
        else {
            $ajaxResult['success'] = false;
            $ajaxResult['message'] = $testResult->out_status;
        }

	header( "Content-Type: application/json" );
        
        echo json_encode($ajaxResult);

        wp_die();
    }
    
    public function init () {
        add_action('admin_menu', array($this, 'addSettingsMenu'));
        add_action('admin_init', array($this, 'registerSettings'));

        // Setup JavaScript
        wp_enqueue_script( 'jquery-form' );
        add_action('wp_ajax_pr_store_login', array($this, 'ajaxStoreLogin'));
    }
}


        
   
