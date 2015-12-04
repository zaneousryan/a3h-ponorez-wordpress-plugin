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
  <form method="post" action="options.php">
    <?php 
        settings_fields('pr-settings');
        do_settings_sections('pr-settings'); 
       ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">Username</th>
        <td>
          <input type="text" name="pr_username" value="<?php echo esc_attr(get_option('pr_username')); ?>" />
        </td>
        <th scope="row">Password</th>
        <td>
          <input type="password" name="pr_password" value="<?php echo esc_attr(get_option('pr_password')); ?>" />
        </td>
      </tr>
    </table>
    <?php submit_button(); ?>
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
        <td><code>[pr_activity <?php echo $act->id; ?>]</code></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
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

    public function init () {
        add_action('admin_menu', array($this, 'addSettingsMenu'));
        add_action('admin_init', array($this, 'registerSettings'));
    }
}


        
   
