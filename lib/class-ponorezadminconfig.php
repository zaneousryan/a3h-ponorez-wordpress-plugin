<?php
/**
 * Admin screens for PonoRez configuration.
 */

final class PonoRezAdminConfig {
    /* Plain old HTML table for listing activities. Intended to be updated via an AJAX call. */
    static public function prActivityList () {
        $psc = PR()->providerService();
        $serviceCreds = PR()->serviceLogin();
        $activities = array();
        
        // Look up the info if we have the login.
        if ($serviceCreds['username']) {
            $activities = $psc->getActivities(array('serviceLogin' => $serviceCreds))
                        ->return;
        }
        if ($activities): ?>
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
  <?php else: ?>
  <p>Enter login information above to see your activity list.</p>
  <?php endif; 

        wp_die();                                            
    }

    /* Get a list of available templates. */
    static public function getTemplateList () {
        $templateDir = realpath(dirname(__FILE__) . '/../') . '/templates/';

        $fileList = glob($templateDir . '/*.html');
        $output = array();

        foreach ($fileList as $f) {
            $output[] = pathinfo($f, PATHINFO_FILENAME);
        }

        return $output;
        
    }
    
    /* Build the default admin page. */
    static public function adminConfigPage () {
        $psc = PR()->providerService();
        $serviceCreds = PR()->serviceLogin();

        // Set up our various calendar styles
        $selectedStyle = get_option('pr_default_style');
        $styles = array('blacktie', 'blitzer', 'cupertino', 'darkhive', 'dotluv', 'eggplant', 'excitedbike',
                        'flick', 'hotsneakers', 'humanity', 'lefrog', 'mintchocolate', 'overcast', 'peppergrinder',
                        'redmond', 'smoothness', 'southstreet', 'start', 'sunny', 'swankypurse',
                        'trontastic', 'uidark', 'uilightdefault', 'vadar');

        // Get our default template
        $defaultTemplate = get_option('pr_default_template');
        
   ?>
<div class="wrap"><div id="icon-tools" class="icon32"></div>
  <h2>PonoRez Account Configuration</h2>
  <form method="POST" action="options.php">
    <?php 
       settings_fields('pr-settings');
       do_settings_sections('pr-settings'); 
       ?>
    <label for="pr_username"><b>Username:</b></label>
    <input id="pr_username" type="text" name="pr_username" value="<?php echo esc_attr(get_option('pr_username')); ?>" />
    <label for="pr_password"><b>Password:</b></label>
    <input id="pr_password" type="password" name="pr_password" value="<?php echo esc_attr(get_option('pr_password')); ?>" />
    <br />
    <label for="pr_default_style"><b>Default Style:</b></label>
    <select id="pr_default_style" name="pr_default_style">
      <?php foreach ($styles as $style): ?>
      <?php printf('<option value="%s"%s>%s</option>',
                                       $style,
                                       ($selectedStyle === $style) ? ' SELECTED' : '',
                                       $style);
            ?>
      <?php endforeach; ?>
    </select>
    <br />
    <label for="pr_default_template"><b>Default Template:</b></label>
    <select id="pr_default_template" name="pr_default_template">
      <?php foreach (self::getTemplateList() as $template): ?>
      <?php printf('<option value="%s"%s>%s</option>',
            $template,
            ($defaultTemplate === $template) ? ' SELECTED' : '',
            $template); ?>
      <?php endforeach; ?>
    </select>
    <br />
    <?php submit_button(); ?>
  </form>
  <div id="prActivityTable">
    <p>Enter login information above to see your activity list.</p>
  </div>
</div>
<script>
  function prUpdateActivityList () {
    var formData = { action : 'pr_activity_list' };

    jQuery.get(ajaxurl, formData, function (result) {
      jQuery('#prActivityTable').html(result);
    });        
  }
 
  jQuery(document).ready(function () {
    // Update the activity list right when the document is ready.
    prUpdateActivityList();
  });
</script>
<?php
    }

    public function registerSettings () {
        register_setting('pr-settings', 'pr_username');
        register_setting('pr-settings', 'pr_password');
        register_setting('pr-settings', 'pr_default_style');
        register_setting('pr-settings', 'pr_default_template');
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
        //wp_enqueue_script( 'jquery-form' );
        add_action('wp_ajax_pr_store_login', array($this, 'ajaxStoreLogin'));
        add_action('wp_ajax_pr_activity_list', array($this, 'prActivityList'));
    }
}


        
   
