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
				</div>
			</div>
	
		<?php endif; ?>
		
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
							
							$guestType1Status = get_option( 'guestType1ID' );

							if ( empty( $guestType1Status ) ) {

								$guestClass1 = 'guestRow';

							} else {

								$guestClass1 ='guestDefined';

							}

						?>
					
						<tr class="<?php print $guestClass1; ?>">
							<td>
								<input id="guestType1" type="text" name="guestType1" value="<?php echo esc_attr(get_option('guestType1')); ?>"/>
							</td>
							<td>
								<input id="guestType1ID" type="text" name="guestType1ID" value="<?php echo esc_attr(get_option('guestType1ID')); ?>"/>
							</td>
							<td>
								<input id="guestType1Min" type="text" name="guestType1Min" value="<?php echo esc_attr(get_option('guestType1Min')); ?>"/>
							</td>
							<td>
								<input id="guestType1Max" type="text" name="guestType1Max" value="<?php echo esc_attr(get_option('guestType1Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType2Status = get_option( 'guestType2ID' );

							if ( empty( $guestType2Status ) ) {

								$guestClass2 = 'guestRow';

							} else {

								$guestClass2 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass2; ?>">
							<td>
								<input id="guestType2" type="text" name="guestType2" value="<?php echo esc_attr(get_option('guestType2')); ?>"/>
							</td>
							<td>
								<input id="guestType2ID" type="text" name="guestType2ID" value="<?php echo esc_attr(get_option('guestType2ID')); ?>"/>
							</td>
							<td>
								<input id="guestType2Min" type="text" name="guestType2Min" value="<?php echo esc_attr(get_option('guestType2Min')); ?>"/>
							</td>
							<td>
								<input id="guestType2Max" type="text" name="guestType2Max" value="<?php echo esc_attr(get_option('guestType2Max')); ?>"/>
							</td>
						</tr>

						<?php 

							$guestType3Status = get_option( 'guestType3ID' );

							if ( empty( $guestType3Status ) ) {

								$guestClass3 = 'guestRow';

							} else {

								$guestClass3 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass3; ?>">
							<td>
								<input id="guestType3" type="text" name="guestType3" value="<?php echo esc_attr(get_option('guestType3')); ?>"/>
							</td>
							<td>
								<input id="guestType3ID" type="text" name="guestType3ID" value="<?php echo esc_attr(get_option('guestType3ID')); ?>"/>
							</td>
							<td>
								<input id="guestType3Min" type="text" name="guestType3Min" value="<?php echo esc_attr(get_option('guestType3Min')); ?>"/>
							</td>
							<td>
								<input id="guestType3Max" type="text" name="guestType3Max" value="<?php echo esc_attr(get_option('guestType3Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType4Status = get_option( 'guestType4ID' );

							if ( empty( $guestType4Status ) ) {

								$guestClass4 = 'guestRow';

							} else {

								$guestClass4 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass4; ?>">
							<td>
								<input id="guestType4" type="text" name="guestType4" value="<?php echo esc_attr(get_option('guestType4')); ?>"/>
							</td>
							<td>
								<input id="guestType4ID" type="text" name="guestType4ID" value="<?php echo esc_attr(get_option('guestType4ID')); ?>"/>
							</td>
							<td>
								<input id="guestType4Min" type="text" name="guestType4Min" value="<?php echo esc_attr(get_option('guestType4Min')); ?>"/>
							</td>
							<td>
								<input id="guestType4Max" type="text" name="guestType4Max" value="<?php echo esc_attr(get_option('guestType4Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType5Status = get_option( 'guestType5ID' );

							if ( empty( $guestType5Status ) ) {

								$guestClass5 = 'guestRow';

							} else {

								$guestClass5 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass5; ?>">
							<td>
								<input id="guestType5" type="text" name="guestType5" value="<?php echo esc_attr(get_option('guestType5')); ?>"/>
							</td>
							<td>
								<input id="guestType5ID" type="text" name="guestType5ID" value="<?php echo esc_attr(get_option('guestType5ID')); ?>"/>
							</td>
							<td>
								<input id="guestType5Min" type="text" name="guestType5Min" value="<?php echo esc_attr(get_option('guestType5Min')); ?>"/>
							</td>
							<td>
								<input id="guestType5Max" type="text" name="guestType5Max" value="<?php echo esc_attr(get_option('guestType5Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType6Status = get_option( 'guestType6ID' );

							if ( empty( $guestType6Status ) ) {

								$guestClass6 = 'guestRow';

							} else {

								$guestClass6 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass6; ?>">
							<td>
								<input id="guestType6" type="text" name="guestType6" value="<?php echo esc_attr(get_option('guestType6')); ?>"/>
							</td>
							<td>
								<input id="guestType6ID" type="text" name="guestType6ID" value="<?php echo esc_attr(get_option('guestType6ID')); ?>"/>
							</td>
							<td>
								<input id="guestType6Min" type="text" name="guestType6Min" value="<?php echo esc_attr(get_option('guestType6Min')); ?>"/>
							</td>
							<td>
								<input id="guestType6Max" type="text" name="guestType6Max" value="<?php echo esc_attr(get_option('guestType6Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType7Status = get_option( 'guestType7ID' );

							if ( empty( $guestType7Status ) ) {

								$guestClass7 = 'guestRow';

							} else {

								$guestClass7 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass7; ?>">
							<td>
								<input id="guestType7" type="text" name="guestType7" value="<?php echo esc_attr(get_option('guestType7')); ?>"/>
							</td>
							<td>
								<input id="guestType7ID" type="text" name="guestType7ID" value="<?php echo esc_attr(get_option('guestType7ID')); ?>"/>
							</td>
							<td>
								<input id="guestType7Min" type="text" name="guestType7Min" value="<?php echo esc_attr(get_option('guestType7Min')); ?>"/>
							</td>
							<td>
								<input id="guestType7Max" type="text" name="guestType7Max" value="<?php echo esc_attr(get_option('guestType7Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType8Status = get_option( 'guestType8ID' );

							if ( empty( $guestType8Status ) ) {

								$guestClass8 = 'guestRow';

							} else {

								$guestClass8 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass8; ?>">
							<td>
								<input id="guestType8" type="text" name="guestType8" value="<?php echo esc_attr(get_option('guestType8')); ?>"/>
							</td>
							<td>
								<input id="guestType8ID" type="text" name="guestType8ID" value="<?php echo esc_attr(get_option('guestType8ID')); ?>"/>
							</td>
							<td>
								<input id="guestType8Min" type="text" name="guestType8Min" value="<?php echo esc_attr(get_option('guestType8Min')); ?>"/>
							</td>
							<td>
								<input id="guestType8Max" type="text" name="guestType8Max" value="<?php echo esc_attr(get_option('guestType8Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType9Status = get_option( 'guestType9ID' );

							if ( empty( $guestType9Status ) ) {

								$guestClass9 = 'guestRow';

							} else {

								$guestClass9 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass9; ?>">
							<td>
								<input id="guestType9" type="text" name="guestType9" value="<?php echo esc_attr(get_option('guestType9')); ?>"/>
							</td>
							<td>
								<input id="guestType9ID" type="text" name="guestType9ID" value="<?php echo esc_attr(get_option('guestType9ID')); ?>"/>
							</td>
							<td>
								<input id="guestType9Min" type="text" name="guestType9Min" value="<?php echo esc_attr(get_option('guestType9Min')); ?>"/>
							</td>
							<td>
								<input id="guestType9Max" type="text" name="guestType9Max" value="<?php echo esc_attr(get_option('guestType9Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType10Status = get_option( 'guestType10ID' );

							if ( empty( $guestType10Status ) ) {

								$guestClass10 = 'guestRow';

							} else {

								$guestClass10 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass10; ?>">
							<td>
								<input id="guestType10" type="text" name="guestType10" value="<?php echo esc_attr(get_option('guestType10')); ?>"/>
							</td>
							<td>
								<input id="guestType10ID" type="text" name="guestType10ID" value="<?php echo esc_attr(get_option('guestType10ID')); ?>"/>
							</td>
							<td>
								<input id="guestType10Min" type="text" name="guestType10Min" value="<?php echo esc_attr(get_option('guestType10Min')); ?>"/>
							</td>
							<td>
								<input id="guestType10Max" type="text" name="guestType10Max" value="<?php echo esc_attr(get_option('guestType10Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType11Status = get_option( 'guestType11ID' );

							if ( empty( $guestType11Status ) ) {

								$guestClass11 = 'guestRow';

							} else {

								$guestClass11 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass11; ?>">
							<td>
								<input id="guestType11" type="text" name="guestType11" value="<?php echo esc_attr(get_option('guestType11')); ?>"/>
							</td>
							<td>
								<input id="guestType11ID" type="text" name="guestType11ID" value="<?php echo esc_attr(get_option('guestType11ID')); ?>"/>
							</td>
							<td>
								<input id="guestType11Min" type="text" name="guestType11Min" value="<?php echo esc_attr(get_option('guestType11Min')); ?>"/>
							</td>
							<td>
								<input id="guestType11Max" type="text" name="guestType11Max" value="<?php echo esc_attr(get_option('guestType11Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType12Status = get_option( 'guestType12ID' );

							if ( empty( $guestType12Status ) ) {

								$guestClass12 = 'guestRow';

							} else {

								$guestClass12 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass12; ?>">
							<td>
								<input id="guestType12" type="text" name="guestType12" value="<?php echo esc_attr(get_option('guestType12')); ?>"/>
							</td>
							<td>
								<input id="guestType12ID" type="text" name="guestType12ID" value="<?php echo esc_attr(get_option('guestType12ID')); ?>"/>
							</td>
							<td>
								<input id="guestType12Min" type="text" name="guestType12Min" value="<?php echo esc_attr(get_option('guestType12Min')); ?>"/>
							</td>
							<td>
								<input id="guestType12Max" type="text" name="guestType12Max" value="<?php echo esc_attr(get_option('guestType12Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType13Status = get_option( 'guestType13ID' );

							if ( empty( $guestType13Status ) ) {

								$guestClass13 = 'guestRow';

							} else {

								$guestClass13 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass13; ?>">
							<td>
								<input id="guestType13" type="text" name="guestType13" value="<?php echo esc_attr(get_option('guestType13')); ?>"/>
							</td>
							<td>
								<input id="guestType13ID" type="text" name="guestType13ID" value="<?php echo esc_attr(get_option('guestType13ID')); ?>"/>
							</td>
							<td>
								<input id="guestType13Min" type="text" name="guestType13Min" value="<?php echo esc_attr(get_option('guestType13Min')); ?>"/>
							</td>
							<td>
								<input id="guestType13Max" type="text" name="guestType13Max" value="<?php echo esc_attr(get_option('guestType13Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType14Status = get_option( 'guestType14ID' );

							if ( empty( $guestType14Status ) ) {

								$guestClass14 = 'guestRow';

							} else {

								$guestClass14 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass14; ?>">
							<td>
								<input id="guestType14" type="text" name="guestType14" value="<?php echo esc_attr(get_option('guestType14')); ?>"/>
							</td>
							<td>
								<input id="guestType14ID" type="text" name="guestType14ID" value="<?php echo esc_attr(get_option('guestType14ID')); ?>"/>
							</td>
							<td>
								<input id="guestType14Min" type="text" name="guestType14Min" value="<?php echo esc_attr(get_option('guestType14Min')); ?>"/>
							</td>
							<td>
								<input id="guestType14Max" type="text" name="guestType14Max" value="<?php echo esc_attr(get_option('guestType14Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType15Status = get_option( 'guestType15ID' );

							if ( empty( $guestType15Status ) ) {

								$guestClass15 = 'guestRow';

							} else {

								$guestClass15 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass15; ?>">
							<td>
								<input id="guestType15" type="text" name="guestType15" value="<?php echo esc_attr(get_option('guestType15')); ?>"/>
							</td>
							<td>
								<input id="guestType15ID" type="text" name="guestType15ID" value="<?php echo esc_attr(get_option('guestType15ID')); ?>"/>
							</td>
							<td>
								<input id="guestType15Min" type="text" name="guestType15Min" value="<?php echo esc_attr(get_option('guestType15Min')); ?>"/>
							</td>
							<td>
								<input id="guestType15Max" type="text" name="guestType15Max" value="<?php echo esc_attr(get_option('guestType15Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType16Status = get_option( 'guestType16ID' );

							if ( empty( $guestType16Status ) ) {

								$guestClass16 = 'guestRow';

							} else {

								$guestClass16 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass16; ?>">
							<td>
								<input id="guestType16" type="text" name="guestType16" value="<?php echo esc_attr(get_option('guestType16')); ?>"/>
							</td>
							<td>
								<input id="guestType16ID" type="text" name="guestType16ID" value="<?php echo esc_attr(get_option('guestType16ID')); ?>"/>
							</td>
							<td>
								<input id="guestType16Min" type="text" name="guestType16Min" value="<?php echo esc_attr(get_option('guestType16Min')); ?>"/>
							</td>
							<td>
								<input id="guestType16Max" type="text" name="guestType16Max" value="<?php echo esc_attr(get_option('guestType16Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType17Status = get_option( 'guestType17ID' );

							if ( empty( $guestType17Status ) ) {

								$guestClass17 = 'guestRow';

							} else {

								$guestClass17 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass17; ?>">
							<td>
								<input id="guestType17" type="text" name="guestType17" value="<?php echo esc_attr(get_option('guestType17')); ?>"/>
							</td>
							<td>
								<input id="guestType17ID" type="text" name="guestType17ID" value="<?php echo esc_attr(get_option('guestType17ID')); ?>"/>
							</td>
							<td>
								<input id="guestType17Min" type="text" name="guestType17Min" value="<?php echo esc_attr(get_option('guestType17Min')); ?>"/>
							</td>
							<td>
								<input id="guestType17Max" type="text" name="guestType17Max" value="<?php echo esc_attr(get_option('guestType17Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType18Status = get_option( 'guestType18ID' );

							if ( empty( $guestType18Status ) ) {

								$guestClass18 = 'guestRow';

							} else {

								$guestClass18 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass18; ?>">
							<td>
								<input id="guestType18" type="text" name="guestType18" value="<?php echo esc_attr(get_option('guestType18')); ?>"/>
							</td>
							<td>
								<input id="guestType18ID" type="text" name="guestType18ID" value="<?php echo esc_attr(get_option('guestType18ID')); ?>"/>
							</td>
							<td>
								<input id="guestType18Min" type="text" name="guestType18Min" value="<?php echo esc_attr(get_option('guestType18Min')); ?>"/>
							</td>
							<td>
								<input id="guestType18Max" type="text" name="guestType18Max" value="<?php echo esc_attr(get_option('guestType18Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType19Status = get_option( 'guestType19ID' );

							if ( empty( $guestType19Status ) ) {

								$guestClass19 = 'guestRow';

							} else {

								$guestClass19 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass19; ?>">
							<td>
								<input id="guestType19" type="text" name="guestType19" value="<?php echo esc_attr(get_option('guestType19')); ?>"/>
							</td>
							<td>
								<input id="guestType19ID" type="text" name="guestType19ID" value="<?php echo esc_attr(get_option('guestType19ID')); ?>"/>
							</td>
							<td>
								<input id="guestType19Min" type="text" name="guestType19Min" value="<?php echo esc_attr(get_option('guestType19Min')); ?>"/>
							</td>
							<td>
								<input id="guestType19Max" type="text" name="guestType19Max" value="<?php echo esc_attr(get_option('guestType19Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$guestType20Status = get_option( 'guestType20ID' );

							if ( empty( $guestType20Status ) ) {

								$guestClass20 = 'guestRow';

							} else {

								$guestClass20 ='guestDefined';

							}

						?>
						
						<tr class="<?php print $guestClass20; ?>">
							<td>
								<input id="guestType20" type="text" name="guestType20" value="<?php echo esc_attr(get_option('guestType20')); ?>"/>
							</td>
							<td>
								<input id="guestType20ID" type="text" name="guestType20ID" value="<?php echo esc_attr(get_option('guestType20ID')); ?>"/>
							</td>
							<td>
								<input id="guestType20Min" type="text" name="guestType20Min" value="<?php echo esc_attr(get_option('guestType20Min')); ?>"/>
							</td>
							<td>
								<input id="guestType20Max" type="text" name="guestType20Max" value="<?php echo esc_attr(get_option('guestType20Max')); ?>"/>
							</td>
						</tr>
						
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
							
							$upgradeType1Status = get_option( 'upgradeType1ID' );

							if ( empty( $upgradeType1Status ) ) {

								$upgradeClass1 = 'upgradeRow';

							} else {

								$upgradeClass1 ='upgradeDefined';

							}

						?>
					
						<tr class="<?php print $upgradeClass1; ?>">
							<td>
								<input id="upgradeType1" type="text" name="upgradeType1" value="<?php echo esc_attr(get_option('upgradeType1')); ?>"/>
							</td>
							<td>
								<input id="upgradeType1ID" type="text" name="upgradeType1ID" value="<?php echo esc_attr(get_option('upgradeType1ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType1Min" type="text" name="upgradeType1Min" value="<?php echo esc_attr(get_option('upgradeType1Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType1Max" type="text" name="upgradeType1Max" value="<?php echo esc_attr(get_option('upgradeType1Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType2Status = get_option( 'upgradeType2ID' );

							if ( empty( $upgradeType2Status ) ) {

								$upgradeClass2 = 'upgradeRow';

							} else {

								$upgradeClass2 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass2; ?>">
							<td>
								<input id="upgradeType2" type="text" name="upgradeType2" value="<?php echo esc_attr(get_option('upgradeType2')); ?>"/>
							</td>
							<td>
								<input id="upgradeType2ID" type="text" name="upgradeType2ID" value="<?php echo esc_attr(get_option('upgradeType2ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType2Min" type="text" name="upgradeType2Min" value="<?php echo esc_attr(get_option('upgradeType2Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType2Max" type="text" name="upgradeType2Max" value="<?php echo esc_attr(get_option('upgradeType2Max')); ?>"/>
							</td>
						</tr>

						<?php 

							$upgradeType3Status = get_option( 'upgradeType3ID' );

							if ( empty( $upgradeType3Status ) ) {

								$upgradeClass3 = 'upgradeRow';

							} else {

								$upgradeClass3 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass3; ?>">
							<td>
								<input id="upgradeType3" type="text" name="upgradeType3" value="<?php echo esc_attr(get_option('upgradeType3')); ?>"/>
							</td>
							<td>
								<input id="upgradeType3ID" type="text" name="upgradeType3ID" value="<?php echo esc_attr(get_option('upgradeType3ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType3Min" type="text" name="upgradeType3Min" value="<?php echo esc_attr(get_option('upgradeType3Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType3Max" type="text" name="upgradeType3Max" value="<?php echo esc_attr(get_option('upgradeType3Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType4Status = get_option( 'upgradeType4ID' );

							if ( empty( $upgradeType4Status ) ) {

								$upgradeClass4 = 'upgradeRow';

							} else {

								$upgradeClass4 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass4; ?>">
							<td>
								<input id="upgradeType4" type="text" name="upgradeType4" value="<?php echo esc_attr(get_option('upgradeType4')); ?>"/>
							</td>
							<td>
								<input id="upgradeType4ID" type="text" name="upgradeType4ID" value="<?php echo esc_attr(get_option('upgradeType4ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType4Min" type="text" name="upgradeType4Min" value="<?php echo esc_attr(get_option('upgradeType4Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType4Max" type="text" name="upgradeType4Max" value="<?php echo esc_attr(get_option('upgradeType4Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType5Status = get_option( 'upgradeType5ID' );

							if ( empty( $upgradeType5Status ) ) {

								$upgradeClass5 = 'upgradeRow';

							} else {

								$upgradeClass5 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass5; ?>">
							<td>
								<input id="upgradeType5" type="text" name="upgradeType5" value="<?php echo esc_attr(get_option('upgradeType5')); ?>"/>
							</td>
							<td>
								<input id="upgradeType5ID" type="text" name="upgradeType5ID" value="<?php echo esc_attr(get_option('upgradeType5ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType5Min" type="text" name="upgradeType5Min" value="<?php echo esc_attr(get_option('upgradeType5Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType5Max" type="text" name="upgradeType5Max" value="<?php echo esc_attr(get_option('upgradeType5Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType6Status = get_option( 'upgradeType6ID' );

							if ( empty( $upgradeType6Status ) ) {

								$upgradeClass6 = 'upgradeRow';

							} else {

								$upgradeClass6 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass6; ?>">
							<td>
								<input id="upgradeType6" type="text" name="upgradeType6" value="<?php echo esc_attr(get_option('upgradeType6')); ?>"/>
							</td>
							<td>
								<input id="upgradeType6ID" type="text" name="upgradeType6ID" value="<?php echo esc_attr(get_option('upgradeType6ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType6Min" type="text" name="upgradeType6Min" value="<?php echo esc_attr(get_option('upgradeType6Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType6Max" type="text" name="upgradeType6Max" value="<?php echo esc_attr(get_option('upgradeType6Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType7Status = get_option( 'upgradeType7ID' );

							if ( empty( $upgradeType7Status ) ) {

								$upgradeClass7 = 'upgradeRow';

							} else {

								$upgradeClass7 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass7; ?>">
							<td>
								<input id="upgradeType7" type="text" name="upgradeType7" value="<?php echo esc_attr(get_option('upgradeType7')); ?>"/>
							</td>
							<td>
								<input id="upgradeType7ID" type="text" name="upgradeType7ID" value="<?php echo esc_attr(get_option('upgradeType7ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType7Min" type="text" name="upgradeType7Min" value="<?php echo esc_attr(get_option('upgradeType7Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType7Max" type="text" name="upgradeType7Max" value="<?php echo esc_attr(get_option('upgradeType7Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType8Status = get_option( 'upgradeType8ID' );

							if ( empty( $upgradeType8Status ) ) {

								$upgradeClass8 = 'upgradeRow';

							} else {

								$upgradeClass8 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass8; ?>">
							<td>
								<input id="upgradeType8" type="text" name="upgradeType8" value="<?php echo esc_attr(get_option('upgradeType8')); ?>"/>
							</td>
							<td>
								<input id="upgradeType8ID" type="text" name="upgradeType8ID" value="<?php echo esc_attr(get_option('upgradeType8ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType8Min" type="text" name="upgradeType8Min" value="<?php echo esc_attr(get_option('upgradeType8Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType8Max" type="text" name="upgradeType8Max" value="<?php echo esc_attr(get_option('upgradeType8Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType9Status = get_option( 'upgradeType9ID' );

							if ( empty( $upgradeType9Status ) ) {

								$upgradeClass9 = 'upgradeRow';

							} else {

								$upgradeClass9 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass9; ?>">
							<td>
								<input id="upgradeType9" type="text" name="upgradeType9" value="<?php echo esc_attr(get_option('upgradeType9')); ?>"/>
							</td>
							<td>
								<input id="upgradeType9ID" type="text" name="upgradeType9ID" value="<?php echo esc_attr(get_option('upgradeType9ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType9Min" type="text" name="upgradeType9Min" value="<?php echo esc_attr(get_option('upgradeType9Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType9Max" type="text" name="upgradeType9Max" value="<?php echo esc_attr(get_option('upgradeType9Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType10Status = get_option( 'upgradeType10ID' );

							if ( empty( $upgradeType10Status ) ) {

								$upgradeClass10 = 'upgradeRow';

							} else {

								$upgradeClass10 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass10; ?>">
							<td>
								<input id="upgradeType10" type="text" name="upgradeType10" value="<?php echo esc_attr(get_option('upgradeType10')); ?>"/>
							</td>
							<td>
								<input id="upgradeType10ID" type="text" name="upgradeType10ID" value="<?php echo esc_attr(get_option('upgradeType10ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType10Min" type="text" name="upgradeType10Min" value="<?php echo esc_attr(get_option('upgradeType10Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType10Max" type="text" name="upgradeType10Max" value="<?php echo esc_attr(get_option('upgradeType10Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType11Status = get_option( 'upgradeType11ID' );

							if ( empty( $upgradeType11Status ) ) {

								$upgradeClass11 = 'upgradeRow';

							} else {

								$upgradeClass11 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass11; ?>">
							<td>
								<input id="upgradeType11" type="text" name="upgradeType11" value="<?php echo esc_attr(get_option('upgradeType11')); ?>"/>
							</td>
							<td>
								<input id="upgradeType11ID" type="text" name="upgradeType11ID" value="<?php echo esc_attr(get_option('upgradeType11ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType11Min" type="text" name="upgradeType11Min" value="<?php echo esc_attr(get_option('upgradeType11Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType11Max" type="text" name="upgradeType11Max" value="<?php echo esc_attr(get_option('upgradeType11Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType12Status = get_option( 'upgradeType12ID' );

							if ( empty( $upgradeType12Status ) ) {

								$upgradeClass12 = 'upgradeRow';

							} else {

								$upgradeClass12 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass12; ?>">
							<td>
								<input id="upgradeType12" type="text" name="upgradeType12" value="<?php echo esc_attr(get_option('upgradeType12')); ?>"/>
							</td>
							<td>
								<input id="upgradeType12ID" type="text" name="upgradeType12ID" value="<?php echo esc_attr(get_option('upgradeType12ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType12Min" type="text" name="upgradeType12Min" value="<?php echo esc_attr(get_option('upgradeType12Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType12Max" type="text" name="upgradeType12Max" value="<?php echo esc_attr(get_option('upgradeType12Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType13Status = get_option( 'upgradeType13ID' );

							if ( empty( $upgradeType13Status ) ) {

								$upgradeClass13 = 'upgradeRow';

							} else {

								$upgradeClass13 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass13; ?>">
							<td>
								<input id="upgradeType13" type="text" name="upgradeType13" value="<?php echo esc_attr(get_option('upgradeType13')); ?>"/>
							</td>
							<td>
								<input id="upgradeType13ID" type="text" name="upgradeType13ID" value="<?php echo esc_attr(get_option('upgradeType13ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType13Min" type="text" name="upgradeType13Min" value="<?php echo esc_attr(get_option('upgradeType13Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType13Max" type="text" name="upgradeType13Max" value="<?php echo esc_attr(get_option('upgradeType13Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType14Status = get_option( 'upgradeType14ID' );

							if ( empty( $upgradeType14Status ) ) {

								$upgradeClass14 = 'upgradeRow';

							} else {

								$upgradeClass14 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass14; ?>">
							<td>
								<input id="upgradeType14" type="text" name="upgradeType14" value="<?php echo esc_attr(get_option('upgradeType14')); ?>"/>
							</td>
							<td>
								<input id="upgradeType14ID" type="text" name="upgradeType14ID" value="<?php echo esc_attr(get_option('upgradeType14ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType14Min" type="text" name="upgradeType14Min" value="<?php echo esc_attr(get_option('upgradeType14Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType14Max" type="text" name="upgradeType14Max" value="<?php echo esc_attr(get_option('upgradeType14Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType15Status = get_option( 'upgradeType15ID' );

							if ( empty( $upgradeType15Status ) ) {

								$upgradeClass15 = 'upgradeRow';

							} else {

								$upgradeClass15 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass15; ?>">
							<td>
								<input id="upgradeType15" type="text" name="upgradeType15" value="<?php echo esc_attr(get_option('upgradeType15')); ?>"/>
							</td>
							<td>
								<input id="upgradeType15ID" type="text" name="upgradeType15ID" value="<?php echo esc_attr(get_option('upgradeType15ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType15Min" type="text" name="upgradeType15Min" value="<?php echo esc_attr(get_option('upgradeType15Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType15Max" type="text" name="upgradeType15Max" value="<?php echo esc_attr(get_option('upgradeType15Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType16Status = get_option( 'upgradeType16ID' );

							if ( empty( $upgradeType16Status ) ) {

								$upgradeClass16 = 'upgradeRow';

							} else {

								$upgradeClass16 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass16; ?>">
							<td>
								<input id="upgradeType16" type="text" name="upgradeType16" value="<?php echo esc_attr(get_option('upgradeType16')); ?>"/>
							</td>
							<td>
								<input id="upgradeType16ID" type="text" name="upgradeType16ID" value="<?php echo esc_attr(get_option('upgradeType16ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType16Min" type="text" name="upgradeType16Min" value="<?php echo esc_attr(get_option('upgradeType16Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType16Max" type="text" name="upgradeType16Max" value="<?php echo esc_attr(get_option('upgradeType16Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType17Status = get_option( 'upgradeType17ID' );

							if ( empty( $upgradeType17Status ) ) {

								$upgradeClass17 = 'upgradeRow';

							} else {

								$upgradeClass17 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass17; ?>">
							<td>
								<input id="upgradeType17" type="text" name="upgradeType17" value="<?php echo esc_attr(get_option('upgradeType17')); ?>"/>
							</td>
							<td>
								<input id="upgradeType17ID" type="text" name="upgradeType17ID" value="<?php echo esc_attr(get_option('upgradeType17ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType17Min" type="text" name="upgradeType17Min" value="<?php echo esc_attr(get_option('upgradeType17Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType17Max" type="text" name="upgradeType17Max" value="<?php echo esc_attr(get_option('upgradeType17Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType18Status = get_option( 'upgradeType18ID' );

							if ( empty( $upgradeType18Status ) ) {

								$upgradeClass18 = 'upgradeRow';

							} else {

								$upgradeClass18 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass18; ?>">
							<td>
								<input id="upgradeType18" type="text" name="upgradeType18" value="<?php echo esc_attr(get_option('upgradeType18')); ?>"/>
							</td>
							<td>
								<input id="upgradeType18ID" type="text" name="upgradeType18ID" value="<?php echo esc_attr(get_option('upgradeType18ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType18Min" type="text" name="upgradeType18Min" value="<?php echo esc_attr(get_option('upgradeType18Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType18Max" type="text" name="upgradeType18Max" value="<?php echo esc_attr(get_option('upgradeType18Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType19Status = get_option( 'upgradeType19ID' );

							if ( empty( $upgradeType19Status ) ) {

								$upgradeClass19 = 'upgradeRow';

							} else {

								$upgradeClass19 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass19; ?>">
							<td>
								<input id="upgradeType19" type="text" name="upgradeType19" value="<?php echo esc_attr(get_option('upgradeType19')); ?>"/>
							</td>
							<td>
								<input id="upgradeType19ID" type="text" name="upgradeType19ID" value="<?php echo esc_attr(get_option('upgradeType19ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType19Min" type="text" name="upgradeType19Min" value="<?php echo esc_attr(get_option('upgradeType19Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType19Max" type="text" name="upgradeType19Max" value="<?php echo esc_attr(get_option('upgradeType19Max')); ?>"/>
							</td>
						</tr>
						
						<?php 

							$upgradeType20Status = get_option( 'upgradeType20ID' );

							if ( empty( $upgradeType20Status ) ) {

								$upgradeClass20 = 'upgradeRow';

							} else {

								$upgradeClass20 ='upgradeDefined';

							}

						?>
						
						<tr class="<?php print $upgradeClass20; ?>">
							<td>
								<input id="upgradeType20" type="text" name="upgradeType20" value="<?php echo esc_attr(get_option('upgradeType20')); ?>"/>
							</td>
							<td>
								<input id="upgradeType20ID" type="text" name="upgradeType20ID" value="<?php echo esc_attr(get_option('upgradeType20ID')); ?>"/>
							</td>
							<td>
								<input id="upgradeType20Min" type="text" name="upgradeType20Min" value="<?php echo esc_attr(get_option('upgradeType20Min')); ?>"/>
							</td>
							<td>
								<input id="upgradeType20Max" type="text" name="upgradeType20Max" value="<?php echo esc_attr(get_option('upgradeType20Max')); ?>"/>
							</td>
						</tr>
						
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