<?php
/**
 * Admin screens for PonoRez configuration.
 */

final class PonoRezAdminConfig {
	
	
	/* Get single activity templates list. */
	static public function getTemplateList() {
		
		$templateDir = realpath( dirname( __FILE__ ) . '/../' ) . '/templates/activities-single/';
		$fileList = glob( $templateDir . '/*.php' );
		$output = array();

		foreach ( $fileList as $f ) {
			
			$output[] = pathinfo( $f, PATHINFO_FILENAME );
			
		}

		return $output;

	}

	/* Get activity groups templates list. */
	static public function getGroupTemplateList() {
		
		$templateDir = realpath( dirname( __FILE__ ) . '/../' ) . '/templates/activities-group/';
		$fileList = glob( $templateDir . '/*.php' );
		$output = array();

		foreach ( $fileList as $f ) {
			
			$output[] = pathinfo( $f, PATHINFO_FILENAME );
			
		}

		return $output;

	}
	
	/* Plain old HTML table for listing activities. Intended to be updated via an AJAX call. */
	static public function prActivityList() {
		
		$psc = PR()->providerService();
		$serviceCreds = PR()->serviceLogin();
		$activities = array();
		$groups = get_option( 'pr_activity_groups' );

		// Look up the info if we have the login.
		if ( $serviceCreds[ 'username' ] ) {
			
			$activityList = new PonoRezActivityList( $psc, $serviceCreds );
			$activities = $activityList->displayItems( array( 'filter' => @$_GET[ 'pra_filter' ], 'page' => @$_GET[ 'pra_page' ], 'count' => 100 ) );
			
		}

		?>
		
		<?php if ( $groups ): ?>
		
			<div class="wp-tab-panel" id="ponorez-groups-list">

				<div id="ponorez-account-settings">

					<div class="inside">

						<h3 class="hndle"><span>Activity Groups</span></h3>

						<table class="wp-list-table widefat">
							<thead>
								<tr>
									<th></th>
									<th>Name</th>
									<th>Activities</th>
									<th>Shortcode</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($groups as $groupName => $activityIds): ?>
								<tr>
									<th class="check-column" scope="row">
										<input type="checkbox" class="pr_group_name" pr-group-name="<?php echo $groupName; ?>" name="pr_group_name_<?php echo $groupName; ?>"/>
									</th>
									<td>
										<?php echo $groupName; ?>
									</td>
									<td>
										<?php echo implode(', ', $activityIds); ?>
									</td>
									<td><code>[ponorezGroupBooking&nbsp;name="<?php echo $groupName; ?>" guests=""]</code>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<button type="button" id="pr_delete_groups" class="button button-primary">Delete Groups</button>

					</div>

				</div>
			</div>
		
		<?php endif; ?>
		
			<div class="wp-tab-panel" id="ponorez-activities-list">

				<div id="ponorez-account-settings">

					<h3 class="hndle"><span>Available Activities</span></h3>

					<div>
						<div>
							<input type="text" id="pr_group_name" name="pr_group_name" placeholder="New group name">
							<button type="button" id="pr_add_group" class="button button-primary">Add Group</button>
							<button type="button" id="pr_refresh" class="button">Refresh List</button>
						</div>

						<div id="last">
							<a href="#" id="pra_prev_page" data-page="<?php echo $activityList->prevPage() ?>" data-count="<?php echo $activityList->resultsPerPage ?>">&lt; Prev</a> |&nbsp;Page
							<?php echo $activityList->currentPage ?> of
							<?php echo $activityList->maxPage ?>&nbsp|
							<a href="#" id="pra_next_page" data-page="<?php echo $activityList->nextPage() ?>" data-count="<?php echo $activityList->resultsPerPage ?>">Next &gt;</a>
							<input type="text" id="pra_activity_filter" placeholder="Filter list" value="<?php echo @$_GET['pra_filter']?>"/>
							<button class="button" id="pra_filter_go">Go</button>
						</div>
					</div>

					<div class="clear"></div>

					<?php if (0 < count($activities)): ?>
					<table class="wp-list-table widefat">
						<thead>
							<tr>
								<th></th>
								<th><strong>Activity Name</strong>
								</th>
								<th><strong>Island</strong>
								</th>
								<th><strong>Activity Time</strong>
								</th>
								<th><strong>Sort Order</strong>
								</th>
								<th><strong>Shortcode</strong>
								</th>
								<th><strong>Included in group</strong>
								</th>
							</tr>
						</thead>
						<tbody id="the-list">
							<?php foreach ($activities as $act): $groupName = pr_key_in_array($act->id, $groups); ?>
							<tr>
								<th class="check-column" scope="row">
									<input type="checkbox" class="pr_activity_id" pr-activity-id="<?php echo $act->id; ?>" name="pr_activity_id_<?php echo $act->id; ?>"/>
								</th>
								<td>
									<strong>
										<?php echo $act->name; ?>
									</strong>
								</td>
								<td>
									<?php echo $act->island; ?>
								</td>

								<td>
									<?php echo $act->times; ?>
								</td>
								<td><input type="text" size="3">
								</td>
								<td>
									[ponorezActivityBooking&nbsp;id="<?php echo $act->id; ?>" guests=""]
								</td>
								<td>
									<?php if ($groupName) echo $groupName; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<div class="clear"></div>

					<?php else: ?>
					<br>
					<p><em>No activities found.</em>
					</p>
					<?php endif; ?>
				</div>
			</div>
		<?php wp_die(); ?>

		<?php
	}

	/* Build the default admin page. */
	static public function adminConfigPage() {
		
		$psc = PR()->providerService();
		$serviceCreds = PR()->serviceLogin();

		// Set up our various calendar styles
		$selectedStyle = get_option( 'pr_default_style' );
		$styles = array( 'black-tie', 'blitzer', 'cupertino', 'dark-hive', 'dot-luv', 'eggplant', 'excite-bike', 'flick', 'hot-sneaks', 'humanity', 'le-frog', 'mint-choc', 'overcast', 'pepper-grinder', 'redmond', 'smoothness', 'south-street', 'start', 'sunny', 'swanky-purse', 'trontastic', 'ui-darkness', 'ui-lightness', 'vadar' ); 
		$timeout = get_option( 'pr_cache_timeout' );
		$defaultTemplate = get_option( 'pr_group_default_template' );
		$defaultGroupTemplate = get_option( 'pr_group_default_template' );

		?>
		
		<h1 style="margin-bottom: 15px;"><?php echo esc_html( get_admin_page_title() ); ?></h1>
		
		<script>

			jQuery(document).ready( function($) {
				
				$('.wp-tab-bar a').click(function(event){
					
					event.preventDefault();
					var context = $(this).closest('.wp-tab-bar').parent();
					$('.wp-tab-panel', context).hide();
					$( $(this).attr('href'), context ).show();
					
				});
				
			});

		</script>
		
		<ul class="wp-tab-bar">
			<li><a href="#ponorez-account-setup">Ponorez Account Setup</a><span>|</span></li>
			<li><a href="#ponorez-forms-settings">Booking Forms Settings</a><span>|</span></li>
			<li><a href="#ponorez-activities-list">Activities List</a><span>|</span></li>
			<li><a href="#ponorez-groups-list">Groups List</a><span>|</span></li>
			<li><a href="#ponorez-guest-types">Guest Types</a><span>|</span></li>
			<li><a href="#ponorez-upgrades">Upgrade Types</a><span>|</span></li>
			<li><a href="#ponorez-google-analytics">Google Analytics Setup</a></li>
		</ul>
		
		<?php echo do_shortcode( '[PonorezLoginTest]' ); ?>

		<form method="POST" action="options.php">
		
			<?php settings_fields('pr-settings'); ?>
			<?php do_settings_sections('pr-settings'); ?>

			<div class="wp-tab-panel" id="ponorez-account-setup">

				<h3 class="hndle"><span>PonoRez Account Setup</span></h3>

				<label for="pr_username"><strong>Your PonoRez Username:</strong></label>
				<input id="pr_username" type="text" name="pr_username" value="<?php echo esc_attr(get_option('pr_username')); ?>"/>
				<label for="pr_password"><strong>Your PonoRez Password:</strong></label>
				<input id="pr_password" type="password" name="pr_password" value="<?php echo esc_attr(get_option('pr_password')); ?>"/>

				<label for="pr_cache_timeout"><strong>Cache Timeout:</strong></label>
				<em>This value determines how often information is retrieved from the Pono Rez servers.</em>
				<select id="pr_cache_timeout" name="pr_cache_timeout">
					<option value="0" <?php echo (0==$timeout) ? ' SELECTED' : '' ?>>Disabled</option>
					<option value="3600" <?php echo (3600==$timeout) ? ' SELECTED' : '' ?>>1 Hour</option>
					<option value="21600" <?php echo (21600==$timeout) ? ' SELECTED' : '' ?>>6 Hours</option>
					<option value="86400" <?php echo (86400==$timeout) ? ' SELECTED' : '' ?>>1 Day</option>
				</select>

				<?php submit_button('Save Account Info'); ?>

			</div>
				
			<div class="wp-tab-panel" id="ponorez-forms-settings">

				<h3 class="hndle"><span>Booking Forms Type</span></h3>

				<label for="pr_group_default_template"><strong>Single Activity Booking Form Template:</strong></label>
				<select id="pr_group_default_template" name="pr_default_template">

					<?php foreach (self::getTemplateList() as $template): ?>
					<?php printf('<option value="%s"%s>%s</option>', $template, ($defaultTemplate === $template) ? ' SELECTED' : '', $template); ?>
					<?php endforeach; ?>

				</select>

				<label for="pr_group_default_template"><strong>Activities Group Booking Form Template:</strong></label>
				<select id="pr_group_default_template" name="pr_group_default_template">

					<?php foreach (self::getGroupTemplateList() as $template): ?>
					<?php printf('<option value="%s"%s>%s</option>', $template, ($defaultGroupTemplate === $template) ? ' SELECTED' : '', $template); ?>
					<?php endforeach; ?>

				</select>

				<h3 class="hndle"><span>Calendar and Submit Buttons Style Settings</span></h3>
				
				<?php
					add_action( 'admin_enqueue_scripts', 'softlights_color_picker' );
					
					function my_color_picker() {
					
						wp_enqueue_style( 'wp-color-picker' );
						wp_enqueue_script( 'colpick_scripts', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
						
					}
				?>

				<script>

					jQuery(document).ready(function($){

						$(function() {

							$('.ponorez-color-picker').wpColorPicker();

						});

					});

				</script>
				
				<label for="primaryColor"><strong>Primary Color</strong></label>
				<input type="text" class="ponorez-color-picker" id="primaryColor" name="primaryColor" value="<?php echo esc_attr(get_option('primaryColor')); ?>"/>
				<p>This color will be used as default background color for calendar header and Book Now button.</p>
				<label for="secondaryColor"><strong>Secondary Color</strong></label>
				<input type="text" class="ponorez-color-picker" id="secondaryColor" name="secondaryColor" value="<?php echo esc_attr(get_option('secondaryColor')); ?>"/>
				<p>This color will be used as secondary color for the Book Now button mouse over effect.</p>
				<label for="textColor"><strong>Text Color</strong></label>
				<input type="text" class="ponorez-color-picker" id="textColor" name="textColor" value="<?php echo esc_attr(get_option('textColor')); ?>"/>
				<p>This color will be used for the Book Now button text color.</p>
				
				<label for="bookNowText"><strong>Set Book Now Button text</strong></label>
								
				<input id="bookNowText" type="text" name="bookNowText" value="<?php echo esc_attr(get_option('bookNowText')); ?>"/>
			
				<h3 class="hndle"><span>Accommodation and Transportation Options</span></h3>
				<label for="accommodationStatus"><input type="checkbox" id="accommodationStatus" name="accommodationStatus" value="1" <?php checked( get_option('accommodationStatus'), 1 ); ?> /> <strong>Enable Accommodation and Trasportaton</strong></label>
				<p>Please note that the accommodation and transportation options are working in conjunction and can be configured through the use of the shortcode parameter  <strong>accommodation=""</strong>.<br /> For more information on how to do this please refer to the <a href="<?php echo admin_url( 'admin.php?page=a3h_ponorez_help', '' ); ?>">Help Section of this plugin.</a></p>
								
				<h3 class="hndle"><span>Other Booking Options</span></h3>
				<label for="couponsStatus"><input type="checkbox" id="couponsStatus" name="couponsStatus" value="1" <?php checked( get_option('couponsStatus'), 1 ); ?> /> <strong>Enable Promotional Codes</strong></label>
				<p>By checking this you will enable the global usage of Promo Codes.<br /> To display the promotional field in a booking form you will need to enable it individually through the use of the shortcode parameter <strong>allowdiscounts=""</strong>.<br /> For more information on how to do this please refer to the <a href="<?php echo admin_url( 'admin.php?page=a3h_ponorez_help', '' ); ?>">Help Section of this plugin.</a></p>
							
				<?php submit_button('Save Settings'); ?>

			</div>
				
			<div class="wp-tab-panel" id="ponorez-guest-types">

				<h3 class="hndle"><span>Guest Type Configuration</span> <a class="button button-primary" id="LoadGuests">Add New Guest Type</a></h3>

				<?php settings_fields('pr-settings'); ?>
				<?php do_settings_sections('pr-settings'); ?>

				<table class="wp-list-table widefat guestTypesList">
					<thead>
						<tr>
							<th><strong>Guest type Label</strong>
							</th>
							<th><strong>Guest type ID</strong>
							</th>
							<th><strong>Minimum number of seats</strong>
							</th>
							<th><strong>Maximum number of seats</strong>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							for( $i = 1; $i <= 20; $i++ ){

								//setup naming convention
								$guestType = 'guestType' . $i;
								$guestTypeID = $guestType . 'ID';
								$guestTypeMin = $guestType . 'Min';
								$guestTypeMax = $guestType . 'Max';

								//check if guest is set
								$guestStatus = get_option( $guestTypeID );

								if(empty( $guestStatus ) ){
									?><tr class='guestRow'><?php
								} else {
									?><tr class='guestDefined'><?php
								}
								?>
									<td>
										<input id="<?php print $guestType; ?>" type="text" name="<?php print $guestType; ?>" value="<?php echo esc_attr(get_option($guestType)); ?>"/>
									</td>
									<td>
										<input id="<?php print $guestTypeID; ?>" type="text" name="<?php print $guestTypeID; ?>" value="<?php echo esc_attr(get_option($guestTypeID)); ?>"/>
									</td>
									<td>
										<input id="<?php print $guestTypeMin; ?>" type="text" name="<?php print $guestTypeMin; ?>" value="<?php echo esc_attr(get_option($guestTypeMin)); ?>"/>
									</td>
									<td>
										<input id="<?php print $guestTypeMax; ?>" type="text" name="<?php print $guestTypeMax; ?>" value="<?php echo esc_attr(get_option($guestTypeMax)); ?>"/>
									</td>
								</tr>

								<?php
							}

						?>
											
						<tr class="guestRow">
							<td colspan="4">
								You have added the maximum number of Guest Types.
							</td>
						</tr>
					</tbody>
				</table>			

				<script>
					jQuery('tr.guestRow').hide();
					jQuery('tr.guestRow').first().show();

					var n = 1;
					jQuery('#LoadGuests').click(function() {

						jQuery('tr.guestRow').eq(n).show();
						n++;

					});
				</script>
				
				<?php submit_button('Save Guest Types'); ?>

			</div>
				
			<div class="wp-tab-panel" id="ponorez-upgrades">

				<h3 class="hndle"><span>Upgrades Configuration</span> <a class="button button-primary" id="LoadUpgrades">Add New Upgrade Type</a></h3>

				<?php settings_fields('pr-settings'); ?>
				<?php do_settings_sections('pr-settings'); ?>

				<table class="wp-list-table widefat upgradeTypesList">
					<thead>
						<tr>
							<th><strong>Upgrade Label</strong>
							</th>
							<th><strong>Upgrade ID</strong>
							</th>
							<th><strong>Minimum number of upgrades</strong>
							</th>
							<th><strong>Maximum number of upgrades</strong>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							for( $i = 1; $i <= 20; $i++ ){

								//setup naming convention
								$upgradeType = 'upgradeType' . $i;
								$upgradeTypeID = $upgradeType . 'ID';
								$upgradeTypeMin = $upgradeType . 'Min';
								$upgradeTypeMax = $upgradeType . 'Max';

								//check if upgrade is set
								$upgradeStatus = get_option( $upgradeTypeID );

								if(empty( $upgradeStatus ) ){
									?><tr class='upgradeRow'><?php
								} else {
									?><tr class='upgradeDefined'><?php
								}
								?>
									<td>
										<input id="<?php print $upgradeType; ?>" type="text" name="<?php print $upgradeType; ?>" value="<?php echo esc_attr(get_option($upgradeType)); ?>"/>
									</td>
									<td>
										<input id="<?php print $upgradeTypeID; ?>" type="text" name="<?php print $upgradeTypeID; ?>" value="<?php echo esc_attr(get_option($upgradeTypeID)); ?>"/>
									</td>
									<td>
										<input id="<?php print $upgradeTypeMin; ?>" type="text" name="<?php print $upgradeTypeMin; ?>" value="<?php echo esc_attr(get_option($upgradeTypeMin)); ?>"/>
									</td>
									<td>
										<input id="<?php print $upgradeTypeMax; ?>" type="text" name="<?php print $upgradeTypeMax; ?>" value="<?php echo esc_attr(get_option($upgradeTypeMax)); ?>"/>
									</td>
								</tr>

								<?php
							}

						?>
						
						<tr class="upgradeRow">
							<td colspan="4">
								You have added the maximum number of Upgrades.
							</td>
						</tr>
					</tbody>
				</table>			

				<script>
					jQuery('tr.upgradeRow').hide();
					jQuery('tr.upgradeRow').first().show();

					var n = 1;
					jQuery('#LoadUpgrades').click(function() {

						jQuery('tr.upgradeRow').eq(n).show();
						n++;

					});
				</script>
				
				<?php submit_button('Save Upgrades'); ?>

			</div>
				
			<div class="wp-tab-panel" id="ponorez-google-analytics">

				<h3 class="hndle"><span>Google Analytics Setup</span></h3>

					<?php settings_fields('pr-settings'); ?>
					<?php do_settings_sections('pr-settings'); ?>

					<label for="googleAnalyticsID"><strong>Your Google Analytics ID:</strong></label>
					<input id="googleAnalyticsID" type="text" name="googleAnalyticsID" placeholder='UA-123456789' value="<?php echo esc_attr(get_option('googleAnalyticsID')); ?>"/>

					<?php submit_button('Save Google Analytics Tracking ID'); ?>

			</div>
			
		</form>


		<?php echo do_shortcode( '[PonorezActivitiesLoader]' ); ?>		

	<?php
	}

	public function registerSettings() {
		
		//PonoRez Interface settings
		register_setting( 'pr-settings', 'pr_username' );
		register_setting( 'pr-settings', 'pr_password' );
		register_setting( 'pr-settings', 'pr_cache_timeout' );

		//Forms settings	
		register_setting( 'pr-settings', 'pr_default_template' );
		register_setting( 'pr-settings', 'pr_group_default_template' );
		register_setting( 'pr-settings', 'bookNowText' );
		register_setting( 'pr-settings', 'primaryColor' );
		register_setting( 'pr-settings', 'secondaryColor' );
		register_setting( 'pr-settings', 'textColor' );
		register_setting( 'pr-settings', 'accommodationStatus' );		
		register_setting( 'pr-settings', 'couponsStatus' );		
		register_setting( 'pr-settings', 'upgradesStatus' );
		register_setting( 'pr-settings', 'googleAnalyticsID' );
		
		//Group Specific Settings
		register_setting( 'pr-settings-groups', 'pr_activity_groups' );
		
		//Custom Guest Types Settings
		register_setting( 'pr-settings', 'guestType1');
		register_setting( 'pr-settings', 'guestType1ID');
		register_setting( 'pr-settings', 'guestType1Min');
		register_setting( 'pr-settings', 'guestType1Max');
		register_setting( 'pr-settings', 'guestType2');
		register_setting( 'pr-settings', 'guestType2ID');
		register_setting( 'pr-settings', 'guestType2Min');
		register_setting( 'pr-settings', 'guestType2Max');
		register_setting( 'pr-settings', 'guestType3');
		register_setting( 'pr-settings', 'guestType3ID');
		register_setting( 'pr-settings', 'guestType3Min');
		register_setting( 'pr-settings', 'guestType3Max');
		register_setting( 'pr-settings', 'guestType4');
		register_setting( 'pr-settings', 'guestType4ID');
		register_setting( 'pr-settings', 'guestType4Min');
		register_setting( 'pr-settings', 'guestType4Max');
		register_setting( 'pr-settings', 'guestType5');
		register_setting( 'pr-settings', 'guestType5ID');
		register_setting( 'pr-settings', 'guestType5Min');
		register_setting( 'pr-settings', 'guestType5Max');
		register_setting( 'pr-settings', 'guestType6');
		register_setting( 'pr-settings', 'guestType6ID');
		register_setting( 'pr-settings', 'guestType6Min');
		register_setting( 'pr-settings', 'guestType6Max');
		register_setting( 'pr-settings', 'guestType7');
		register_setting( 'pr-settings', 'guestType7ID');
		register_setting( 'pr-settings', 'guestType7Min');
		register_setting( 'pr-settings', 'guestType7Max');
		register_setting( 'pr-settings', 'guestType8');
		register_setting( 'pr-settings', 'guestType8ID');
		register_setting( 'pr-settings', 'guestType8Min');
		register_setting( 'pr-settings', 'guestType8Max');
		register_setting( 'pr-settings', 'guestType9');
		register_setting( 'pr-settings', 'guestType9ID');
		register_setting( 'pr-settings', 'guestType9Min');
		register_setting( 'pr-settings', 'guestType9Max');
		register_setting( 'pr-settings', 'guestType10');
		register_setting( 'pr-settings', 'guestType10ID');
		register_setting( 'pr-settings', 'guestType10Min');
		register_setting( 'pr-settings', 'guestType10Max');
		register_setting( 'pr-settings', 'guestType11');
		register_setting( 'pr-settings', 'guestType11ID');
		register_setting( 'pr-settings', 'guestType11Min');
		register_setting( 'pr-settings', 'guestType11Max');
		register_setting( 'pr-settings', 'guestType12');
		register_setting( 'pr-settings', 'guestType12ID');
		register_setting( 'pr-settings', 'guestType12Min');
		register_setting( 'pr-settings', 'guestType12Max');
		register_setting( 'pr-settings', 'guestType13');
		register_setting( 'pr-settings', 'guestType13ID');
		register_setting( 'pr-settings', 'guestType13Min');
		register_setting( 'pr-settings', 'guestType13Max');
		register_setting( 'pr-settings', 'guestType14');
		register_setting( 'pr-settings', 'guestType14ID');
		register_setting( 'pr-settings', 'guestType14Min');
		register_setting( 'pr-settings', 'guestType14Max');
		register_setting( 'pr-settings', 'guestType15');
		register_setting( 'pr-settings', 'guestType15ID');
		register_setting( 'pr-settings', 'guestType15Min');
		register_setting( 'pr-settings', 'guestType15Max');
		register_setting( 'pr-settings', 'guestType16');
		register_setting( 'pr-settings', 'guestType16ID');
		register_setting( 'pr-settings', 'guestType16Min');
		register_setting( 'pr-settings', 'guestType16Max');
		register_setting( 'pr-settings', 'guestType17');
		register_setting( 'pr-settings', 'guestType17ID');
		register_setting( 'pr-settings', 'guestType17Min');
		register_setting( 'pr-settings', 'guestType17Max');
		register_setting( 'pr-settings', 'guestType18');
		register_setting( 'pr-settings', 'guestType18ID');
		register_setting( 'pr-settings', 'guestType18Min');
		register_setting( 'pr-settings', 'guestType18Max');
		register_setting( 'pr-settings', 'guestType19');
		register_setting( 'pr-settings', 'guestType19ID');
		register_setting( 'pr-settings', 'guestType19Min');
		register_setting( 'pr-settings', 'guestType19Max');
		register_setting( 'pr-settings', 'guestType20');
		register_setting( 'pr-settings', 'guestType20ID');
		register_setting( 'pr-settings', 'guestType20Min');
		register_setting( 'pr-settings', 'guestType20Max');

		//Custom Upgrades Types Settings
		register_setting( 'pr-settings', 'upgradeType1');
		register_setting( 'pr-settings', 'upgradeType1ID');
		register_setting( 'pr-settings', 'upgradeType1Min');
		register_setting( 'pr-settings', 'upgradeType1Max');
		register_setting( 'pr-settings', 'upgradeType2');
		register_setting( 'pr-settings', 'upgradeType2ID');
		register_setting( 'pr-settings', 'upgradeType2Min');
		register_setting( 'pr-settings', 'upgradeType2Max');
		register_setting( 'pr-settings', 'upgradeType3');
		register_setting( 'pr-settings', 'upgradeType3ID');
		register_setting( 'pr-settings', 'upgradeType3Min');
		register_setting( 'pr-settings', 'upgradeType3Max');
		register_setting( 'pr-settings', 'upgradeType4');
		register_setting( 'pr-settings', 'upgradeType4ID');
		register_setting( 'pr-settings', 'upgradeType4Min');
		register_setting( 'pr-settings', 'upgradeType4Max');
		register_setting( 'pr-settings', 'upgradeType5');
		register_setting( 'pr-settings', 'upgradeType5ID');
		register_setting( 'pr-settings', 'upgradeType5Min');
		register_setting( 'pr-settings', 'upgradeType5Max');
		register_setting( 'pr-settings', 'upgradeType6');
		register_setting( 'pr-settings', 'upgradeType6ID');
		register_setting( 'pr-settings', 'upgradeType6Min');
		register_setting( 'pr-settings', 'upgradeType6Max');
		register_setting( 'pr-settings', 'upgradeType7');
		register_setting( 'pr-settings', 'upgradeType7ID');
		register_setting( 'pr-settings', 'upgradeType7Min');
		register_setting( 'pr-settings', 'upgradeType7Max');
		register_setting( 'pr-settings', 'upgradeType8');
		register_setting( 'pr-settings', 'upgradeType8ID');
		register_setting( 'pr-settings', 'upgradeType8Min');
		register_setting( 'pr-settings', 'upgradeType8Max');
		register_setting( 'pr-settings', 'upgradeType9');
		register_setting( 'pr-settings', 'upgradeType9ID');
		register_setting( 'pr-settings', 'upgradeType9Min');
		register_setting( 'pr-settings', 'upgradeType9Max');
		register_setting( 'pr-settings', 'upgradeType10');
		register_setting( 'pr-settings', 'upgradeType10ID');
		register_setting( 'pr-settings', 'upgradeType10Min');
		register_setting( 'pr-settings', 'upgradeType10Max');
		register_setting( 'pr-settings', 'upgradeType11');
		register_setting( 'pr-settings', 'upgradeType11ID');
		register_setting( 'pr-settings', 'upgradeType11Min');
		register_setting( 'pr-settings', 'upgradeType11Max');
		register_setting( 'pr-settings', 'upgradeType12');
		register_setting( 'pr-settings', 'upgradeType12ID');
		register_setting( 'pr-settings', 'upgradeType12Min');
		register_setting( 'pr-settings', 'upgradeType12Max');
		register_setting( 'pr-settings', 'upgradeType13');
		register_setting( 'pr-settings', 'upgradeType13ID');
		register_setting( 'pr-settings', 'upgradeType13Min');
		register_setting( 'pr-settings', 'upgradeType13Max');
		register_setting( 'pr-settings', 'upgradeType14');
		register_setting( 'pr-settings', 'upgradeType14ID');
		register_setting( 'pr-settings', 'upgradeType14Min');
		register_setting( 'pr-settings', 'upgradeType14Max');
		register_setting( 'pr-settings', 'upgradeType15');
		register_setting( 'pr-settings', 'upgradeType15ID');
		register_setting( 'pr-settings', 'upgradeType15Min');
		register_setting( 'pr-settings', 'upgradeType15Max');
		register_setting( 'pr-settings', 'upgradeType16');
		register_setting( 'pr-settings', 'upgradeType16ID');
		register_setting( 'pr-settings', 'upgradeType16Min');
		register_setting( 'pr-settings', 'upgradeType16Max');
		register_setting( 'pr-settings', 'upgradeType17');
		register_setting( 'pr-settings', 'upgradeType17ID');
		register_setting( 'pr-settings', 'upgradeType17Min');
		register_setting( 'pr-settings', 'upgradeType17Max');
		register_setting( 'pr-settings', 'upgradeType18');
		register_setting( 'pr-settings', 'upgradeType18ID');
		register_setting( 'pr-settings', 'upgradeType18Min');
		register_setting( 'pr-settings', 'upgradeType18Max');
		register_setting( 'pr-settings', 'upgradeType19');
		register_setting( 'pr-settings', 'upgradeType19ID');
		register_setting( 'pr-settings', 'upgradeType19Min');
		register_setting( 'pr-settings', 'upgradeType19Max');
		register_setting( 'pr-settings', 'upgradeType20');
		register_setting( 'pr-settings', 'upgradeType20ID');
		register_setting( 'pr-settings', 'upgradeType20Min');
		register_setting( 'pr-settings', 'upgradeType20Max');
	}
	
	public function display_plugin_menu() {
		
		add_menu_page( 'PonoRez Booking System', 'PonoRez', 'manage_options', 'a3h_ponorez', array( 'PonoRezAdminConfig', 'adminConfigPage' ), $icon_url = 'dashicons-palmtree', $position = 20 );		
		add_submenu_page( 'a3h_ponorez', 'Plugin Settings', 'Plugin Settings', 'manage_options', 'a3h_ponorez');
		add_submenu_page( 'a3h_ponorez', 'How to Use', 'How to use', 'manage_options', 'a3h_ponorez_help', array($this, 'display_plugin_help') );
		
	}
	
	public function display_plugin_help() {
		
		include_once( plugin_dir_path( __DIR__ ) . 'help/how-to-use.php' );
		
	}

	//Testing login credetials and store them.
	public function ajaxStoreLogin() {
		
		$username = $_POST[ 'pr_username' ];
		$password = $_POST[ 'pr_password' ];

		$psc = PR()->providerService();
		$testResult = $psc->testLogin( array( 'serviceLogin' => array( 'username' => $username, 'password' => $password ) ) ); 
		$ajaxResult = array();

		if ( true == $testResult->return ) {
			
			update_option( 'pr_username', $username );
			update_option( 'pr_password', $password );

			$ajaxResult[ 'success' ] = true;
			
		} else {
			
			$ajaxResult[ 'success' ] = false;
			$ajaxResult[ 'message' ] = $testResult->out_status;
		}

		header( "Content-Type: application/json" );

		echo json_encode( $ajaxResult );

		wp_die();
	}

	//Delete groups functionality
	public function ajaxDeleteGroups() {
		
		$groups = get_option( 'pr_activity_groups' );

		if ( !$groups ) {
			
			$groups == array();
			
		}

		$groupsToDelete = $_GET[ 'groups' ];
		$deleteCount = 0;

		foreach ( $groupsToDelete as $gn ) {
			
			if ( $groups[ $gn ] ) {
				
				unset( $groups[ $gn ] );
				$deleteCount++;
				
			}
			
		}

		// Save after deletion
		if ( 0 < $deleteCount ) {
			
			update_option( 'pr_activity_groups', $groups );
			
		}

		$ajaxResult = array( 'success' => true, 'deleteCount' => $deleteCount );
		
		header( "Content-Type: application/json" );

		echo json_encode( $ajaxResult );

		wp_die();
		
	}

	// Save new created groups
	public function ajaxStoreGroup() {
		
		$groups = get_option( 'pr_activity_groups' );

		if ( !$groups ) {
			
			$groups == array();
			
		}

		$groupName = $_GET[ 'groupname' ];
		$activityIds = $_GET[ 'idlist' ];

		// Sanitize group name (must start with a letter and contain only lower case letters and numbers). 
		$groupName = preg_replace( '/\W+/', '', strtolower( $groupName ) );
		
		if ( '' === $groupName ) {
			
			$groupName = 'g' . date( 'Ymd' );
			
		}

		// If there is no groupName or groupIds, we fail now.
		if ( !$groupName || 0 >= count( $activityIds ) ) {
			
			$ajaxResult = array(
				'success' => false,
				'message' => sprintf( 'Cannot add %d activities to group "%s".',
					count( $activityIds ),
					$groupName )
			);
			
		} else {
			
			// Store our new group.
			$groups[ $groupName ] = $activityIds;

			update_option( 'pr_activity_groups', $groups );

			$ajaxResult = array( 'success' => true, 'groupName' => $groupName, 'activityIds' => $activityIds );
		}

		header( "Content-Type: application/json" );

		echo json_encode( $ajaxResult );

		wp_die();

	}

	public function init() {
		
		if ( !is_admin() ) {
						
			return;
			
		}

		// Setup AJAX calls
		add_action( 'wp_ajax_pr_store_login', array( $this, 'ajaxStoreLogin' ) );
		add_action( 'wp_ajax_pr_activity_list', array( $this, 'prActivityList' ) );
		add_action( 'wp_ajax_pr_store_group', array( $this, 'ajaxStoreGroup' ) );
		add_action( 'wp_ajax_pr_delete_groups', array( $this, 'ajaxDeleteGroups' ) );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			
			return;
			
		}

		// Non-Ajax admin stuff.
		wp_enqueue_style( 'pr_style', plugins_url( 'assets/css/pr_admin.css', dirname( __FILE__ ) ) );
		wp_enqueue_script( 'pr_admin', plugins_url( 'assets/js/pr_admin.js', dirname( __FILE__ ) ), array( 'jquery' ) );
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
		add_action( 'admin_menu', array( $this, 'display_plugin_menu' ) );
		add_action( 'admin_init', array( $this, 'registerSettings' ) );
		
	}
	
}