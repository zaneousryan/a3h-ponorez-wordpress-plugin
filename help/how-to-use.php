	    <div class="wrap">
     
        <h2>How to use PonoRez Booking System for Wordpress</h2>
         
        <h2 class="nav-tab-wrapper">
            <a href="?page=a3h_ponorez_help&tab=plugin-configuration" class="nav-tab <?php echo $active_tab == 'plugin-configuration' ? 'nav-tab-active' : ''; ?>">Plugin Configuration</a>
            <a href="?page=a3h_ponorez_help&tab=activity-shortcodes" class="nav-tab <?php echo $active_tab == 'activity-shortcodes' ? 'nav-tab-active' : ''; ?>">Activity Shortcodes</a>
            <a href="?page=a3h_ponorez_help&tab=group-shortcodes" class="nav-tab <?php echo $active_tab == 'group-shortcodes' ? 'nav-tab-active' : ''; ?>">Group Shortcodes</a>
        </h2>
       	
       	<?php
		
			if( isset( $_GET[ 'tab' ] ) ) {
				
				$active_tab = $_GET[ 'tab' ];
			
			} else { 
				
				$active_tab = 'plugin-configuration' ;
				
			}
		?>
		
         
		<?php
         
        if( $active_tab == 'plugin-configuration' ) {
		
		?>

			<div class="wp-tab-panel" style="max-height: 100%; border-top: none;">

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; border-bottom: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Connecting to your PonoRez account</span></h2>
				<p>In order for this plugin to work you have to provide your PonoRez account credentials (username and password).
				<p>		
					After typing in your credetials click <strong>Save Account Info</strong> button. If the provided information is correct you will see a success notication
					<div style="margin: 0 20px 20px 0; max-width: 400px; background-color: #f7f7f7; border-left: 4px solid #46b450; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1); padding: 1px 12px;"><p><strong>You have successfully connected to your PonoRez account.</strong></p></div>
				</p>
				<p>
					However, if the provided credetials are not correct you will see an error message 
					<div style="margin: 0 20px 20px 0; max-width: 400px; background-color: #f7f7f7; border-left: 4px solid #dc3232; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1); padding: 1px 12px;"><p><strong>Login failed. Please check your PonoRez account credetials!</strong></p></div>
					in which case you need to make sure you have to check and update them.
				</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Configuring plugin options</span></h2>
				<h3 class="hndle">Booking Forms Type</h3>		
				<p>This option will let you select between displaying your booking forms directly on your website pages or in an overlay popup.</p>
				<p>You have the possibility to set this for both single activity booking forms and group ones.</p>

				<h3 class="hndle">Calendar and Submit Buttons Style Settings</h3>
				<p>This section options will let you personalize the calendar and all form related buttons color.</p>
				<p><strong style="color: #0073aa;">Primary color</strong> will let you set the color used for the default state of all buttons and calendar icon.</p>
				<p><strong style="color: #0073aa;">Secondary color</strong>  will let you set the color used for the mouse over state of the buttons and calendar icon.</p>
				<p><strong style="color: #0073aa;">Text color</strong> will let you set the color used for the buttons text.</p>
				<p>The <strong style="color: #0073aa;">Set Book Now Button text</strong> will let you set the text you want your buttons to show (ex. <strong>Book Now</strong> or <strong>Make Reservation</strong> etc).</p>
				<p><strong>Set Book Now Button text:</strong> will let you set the text you want to display on the form submit (BOOK NOW) buttons.</p>

				<h3 class="hndle"><span>Enable Accommodation and Trasportaton</span></h3>
				<p>By checking this options you will globally enable the usage of <strong style="color: #0073aa;">Accommodation and Transportation</strong> options in your booking forms.</p>
				<p>Please note that the accommodation and transportation options are working in conjunction and they can be configured through the use of the shortcode parameter <strong>accommodation=""</strong>.</p>
				<p>For more information on how to configure them please refer to the <strong>Activity Shortcodes and Group Shortcodes sections of this page</strong>.</p>

				<h3 class="hndle"><span>Enable Promotional Codes</span></h3>
				<p>By checking this option you will globally enable the usage of <strong style="color: #0073aa;">Promotional Codes</strong> options in your booking forms.</p>
				<p>Please note that the promotinal codes option can be configured through the use of the shortcode parameter <strong>allowdiscounts=''</strong>.</p>
				<p>For more information on how to configure it please refer to the <strong>Activity Shortcodes</strong> and <strong>Group Shortcodes</strong> sections of this page.</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Available Activities</span></h2>
				<p>After a sucessfull connection to PonoRez server this plugin will retreive all activites associated with your account.</p>
				<p>To view the full list of available activites go to <strong style="color: #0073aa;">Activities List</strong> tab.</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Available Activity Groups</span></h2>

				<p>You can see the full list of available groups by navigating to <strong>Groups List tab</strong>.</p>

				<h3 class="hndle">Creating a group</h3>
				<p>If you want to use activity groups booking forms you will have to first define these groups.</p>
				<p>To do that you need to go to <strong>Activities List tab</strong> and <strong>select the checkboxes</strong> in line with targeted activities, type a name in the "<strong>New Group Name</strong>" field and click <strong>Add Group</strong> button.</p>
				<p>Please note that <strong>the group name must start with a letter and can contain only letters and numbers</strong>.</p>

				<h3><span>Deleting a group</span></h3>
				<p>You can delete a group by <strong>selecting the checkbox</strong> in line with targeted group(s) and clicking the <strong>Delete Groups button</strong>.</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Displaying an activity booking form on your website</span></h2>
				<p>You can generate a booking form for any of the listed activities by <strong>copying and pasting the shortcode</strong> listed beside the activity name: <code>[ponorezActivityBooking id="ID" guests=""]</code>.</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Displaying a group booking form on your website</span></h2>
				<p>You can generate a booking form for any of the listed groups by <strong>copying and pasting the shortcode</strong> listed beside the group name: <code>[ponorezGroupBooking name="NAME" guests=""]</code>.</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Guest Type Configuration</span></h2>
				<p>This section will let you define the guest types you want to use. For each guest type you will need to define a <strong>Name/Label</strong>, <strong>the guest type ID</strong> and the <strong>minimum and maximum</strong> number of allowed guests.</p>
				<p>The guest type IDs must be identical to the ones defined in your PonoRez account dashboard. If you are not sure what guest types to use please check this information by logging into your PonoRez account dashboard and navigating to <strong style="color: #0073aa;">Settings > Guest Types</strong>.</p>
				<p>You can add up to 20 guest types.</p>
				<p>Please note that <strong>defining your guest types has to be completed before you start adding forms to you website</strong> as the booking forms shortcodes will require the <strong>guests="IDS"</strong> parameter to be defined it order for the form to work.</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Upgrade Type Configuration</span></h2>
				<p>This section will let you define the upgrade types you want to use. For each upgrade type you will need to define a <strong>Name/Label</strong>, <strong>the upgrade type ID</strong> and the <strong>minimum and maximum</strong> number of allowed upgrades.</p>
				<p>The upgrade type IDs must be identical to the ones defined in your PonoRez account dashboard. If you are not sure what upgrade types to use please check this information by logging into your PonoRez account dashboard and navigating to <strong style="color: #0073aa;">Settings > Upgrades &amp; Surcharges</strong>.</p>
				<p>You can add up to 20 upgrade types.</p>
				<p>Please note that <strong>defining your upgrade types has to be completed before you start adding forms to you website</strong> as the booking forms shortcodes will require the <strong>upgrades="IDS"</strong> parameter to be defined it order for the form to work.</p>

				<h2 class="hndle" style="font-size: 1.7em; padding-bottom: 12px; padding-top: 12px; border-bottom: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Google Analytics Setup</span></h2>
				<p>If you are planning to use the Google Analytics tracking option paste your tracking ID in the existing field and click Save.</p>

			</div>  
            
        <?php
			
        } elseif ( $active_tab == 'activity-shortcodes' ) {
			
		?>

			<div class="wp-tab-panel" style="max-height: 100%; border-top: none;">

				<h3 class="hndle" style="padding-bottom: 12px; border-bottom: 1px solid #e1e1e1; margin-bottom: 12px;"><span>How to use the single activity shortcode</span></h3>
				<p>The most compact version of activity shortcode is <code>[ponorezActivityBooking id="ID" guests=""]</code>.</p>
				<p>Please note the <strong>id="ID"</strong> and <strong>guests=""</strong> parameters as they are mandatory. Without defining either of them the shortcode will not work.</p>
				<p>So the shortcode, in it's minimal format should look like this <code>[ponorezActivityBooking id="1234" guests="123,234,345"]</code></p>

				<h3><strong>guests="" parameter</strong></h3>
				<p>Usage instructions: list your guest type IDs (as defined in the Guest Types tab) separated by comma. Example: <code>guests="123,234,345"</code>. Value must be enclosed between "" and the are NO SPACES ALLOWED between values.</p>	
				<p>The order in which the IDs are listed on this parameter will dictate the order in which your guest types fields are printed on you form. <code>guests="123,234,345"</code> vs <code>guests="345, 123, 234"</code></p>

				<h3 class="hndle" style="padding-bottom: 12px; border-bottom: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Other parameters</span></h3>
				<p>Beside ID and guests parameters, this shortcode has the a few other ones that will help you configure your booking forms.</p>

				<h3><strong>upgrades="" parameter</strong></h3>
				<p>Usage instructions: list your upgrade type IDs (as defined in the Upgrade Types tab) separated by comma. Example: <code>upgrades="123,234,345"</code>. Value must be enclosed between "" and the are NO SPACES ALLOWED between values.</p>	
				<p>The order in which the IDs are listed on this parameter will dictate the order in which your upgrade types fields are printed on you form. <code>upgrades="123,234,345"</code> vs <code>upgrades="345, 123, 234"</code></p>
				<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" upgrades="123,234,345"]</code></li>

				<h3><strong>accommodation='' parameter</strong></h3>
				<p><strong>accommodation=""</strong> has 4 possible values are <strong>fixed</strong>, <strong>popup</strong>, <strong>checkout</strong> and <strong>disabled</strong>.</p>

				<ul style="margin-left: 40px; list-style-type: square;">
					<li><strong>accommodation="fixed"</strong> will set the form to display the accommodation and transportation fields inline with your other form elements.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" accommodation="fixed"]</code></li>
					<li><strong>accommodation="popup"</strong> will set the display of these fields in the checking availability popup.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" accommodation="popup"]</code></li>
					<li><strong>accommodation="checkout"</strong> will set the display of these fields on the checkout page hosted by Ponorez.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" accommodation="checkout"]</code></li>
					<li><strong>accommodation="disabled"</strong> will disable the use of activity and transportation options.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" accommodation="disabled"]</code></li>
					<li><strong>accommodation=""</strong> missing value will use as default behavior setting the display of these fields on the checkout page hosted by Ponorez.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" accommodation=""]</code></li>
				</ul>

				<p>Please note that in order for this parameter to work "<strong>Enable Accommodation and Trasportaton</strong>" option must be enabled.</p>

				<h3><strong>allowdiscounts='' parameter</strong></h3>

				<p><strong>allowdiscounts=''</strong> has two possible values <strong>yes</strong> and <strong>no</strong>.</p>

				<ul style="margin-left: 40px; list-style-type: square;">
					<li><strong>allowdiscounts='yes'</strong> will display the promotional code field in your booking form.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" allowdiscounts='yes']</code></li>
					<li><strong>allowdiscounts='no'</strong> will disable the promotional code field.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" allowdiscounts='no']</code></li>
					<li><strong>allowdiscounts=''</strong> missing value will disable the promotional code field.<br>
					<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345"]</code></li>
				</ul>
				<p>Please note that in order for this parameter to work "<strong>Enable Promotional Codes</strong>" option must be enabled.</p>

				<h3><strong>promocode='' parameter</strong></h3>
				<p>Is limited to promotional codes created inside of the PonoRez system under Webmaster > Website Integration Code > Website Discounts<br>
				Will hide the promotional code field in your booking form and pre-fill the field with parameter.</p>
				<code>Example: [ponorezActivityBooking id="1234" guests="123,234,345" allowdiscounts='yes' promocode="Promotional Code"]</code>
				<p>Please note that in order for this parameter to work "<strong>Enable Promotional Codes</strong>" option must be enabled.</p>

				<h3><strong>title='' parameter</strong></h3>
				<p>Will let you set a title for your booking forms. This is especially useful to use when you are displaying your forms in the overlay mode.<br>
				<code>Example: [ponorezActivityBooking id="1234" guests="345,234,123" title='My Booking Form Title']</code></p>

				<h2><strong>Displaying multiple booking forms on the same page</strong></h2>		
				<p>Currently this pugin can be used to generate up to 14 booking form on the same page by using the following shortcode variations:</p>
				<code>[ponorezActivityBooking-01 id="1234" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-02 id="2345" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-03 id="3456" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-04 id="4567" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-05 id="5678" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-06 id="6789" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-07 id="1234" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-08 id="2345" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-09 id="3456" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-10 id="4567" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-11 id="5678" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-12 id="6789" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-13 id="1234" guests="345,234,123"]</code><br>
				<code>[ponorezActivityBooking-14 id="2345" guests="345,234,123"]</code>

			</div>
        <?php
			
        } elseif ( $active_tab == 'group-shortcodes' ) {
			
		?>

			<div class="wp-tab-panel" style="max-height: 100%; border-top: none;">

				<h3 class="hndle" style="padding-bottom: 12px; border-bottom: 1px solid #e1e1e1; margin-bottom: 12px;"><span>How to use the activities group shortcode</h2></span></h3>
				<p>The most compact version of activity shortcode is <code>[ponorezGroupBooking id="GROUPNAME" guests=""]</code>.</p>
				<p>Please note the <strong>name="GROUPNAME"</strong> and <strong>guests=""</strong> parameters as they are mandatory. Without defining either of them the shortcode will not work.</p>
				<p>So the shortcode, in it's minimal format should look like this <code>[ponorezGroupBooking name="GROUPNAME" guests="123,234,345"]</code></p>

				<h3><strong>guests="" parameter</strong></h3>
				<p>Usage instructions: list your guest type IDs (as defined in the Guest Types tab) separated by comma. Example: <code>guests="123,234,345"</code>. Value must be enclosed between "" and the are NO SPACES ALLOWED between values.</p>	
				<p>The order in which the IDs are listed on this parameter will dictate the order in which your guest types fields are printed on you form. <code>guests="123,234,345"</code> vs <code>guests="345, 123, 234"</code></p>

				<h3 class="hndle" style="padding-bottom: 12px; border-bottom: 1px solid #e1e1e1; margin-bottom: 12px;"><span>Other parameters</span></h3>
				<p>Beside ID and guests parameters, this shortcode has the a few other ones that will help you configure your booking forms.</p>

				<h3><strong>upgrades="" parameter</strong></h3>
				<p>Usage instructions: list your upgrade type IDs (as defined in the Upgrade Types tab) separated by comma. Example: <code>upgrades="123,234,345"</code>. Value must be enclosed between "" and the are NO SPACES ALLOWED between values.</p>	
				<p>The order in which the IDs are listed on this parameter will dictate the order in which your upgrade types fields are printed on you form. <code>upgrades="123,234,345"</code> vs <code>upgrades="345, 123, 234"</code></p>
				<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345" upgrades="123,234,345"]</code></li>

				<h3><strong>accommodation="" parameter</strong></h3>
				<p><strong>accommodation=""</strong> has 2 possible values are <strong>fixed</strong> and <strong>disabled</strong>.</p>

				<ul style="margin-left: 40px; list-style-type: square;">
					<li><strong>accommodation="fixed"</strong> will set the form to display the accommodation and transportation fields inline with your other form elements.<br>
					<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345" accommodation="fixed"]</code></li>
					<li><strong>accommodation="disabled"</strong> will disable the use of activity and transportation options.<br>
					<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345" accommodation="disabled"]</code></li>
					<li><strong>accommodation=""</strong> missing value will use as default behavior setting the display of these fields on the checkout page hosted by Ponorez.<br>
					<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345" accommodation=""]</code></li>
				</ul>

				<p>Please note that in order for this parameter to work "<strong>Enable Accommodation and Trasportaton</strong>" option must be enabled.</p>

				<h3><strong>allowdiscounts='' parameter</strong></h3>

				<p><strong>allowdiscounts=''</strong> has two possible values <strong>yes</strong> and <strong>no</strong>.</p>

				<ul style="margin-left: 40px; list-style-type: square;">
					<li><strong>allowdiscounts='yes'</strong> will display the promotional code field in your booking form.<br>
					<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345" allowdiscounts='yes']</code></li>
					<li><strong>allowdiscounts='no'</strong> will disable the promotional code field.<br>
					<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345" allowdiscounts='no']</code></li>
					<li><strong>allowdiscounts=''</strong> missing value will disable the promotional code field.<br>
					<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345"]</code></li>
				</ul>
				<p>Please note that in order for this parameter to work "<strong>Enable Promotional Codes</strong>" option must be enabled.</p>

				<h3><strong>promocode='' parameter</strong></h3>
				<p>Is limited to promotional codes created inside of the PonoRez system under Webmaster > Website Integration Code > Website Discounts<br>
				Will hide the promotional code field in your booking form and pre-fill the field with parameter.</p>
				<code>Example: [ponorezGroupBooking name="groupname" guests="123,234,345" allowdiscounts='yes' promocode="Promotional Code"]</code>
				<p>Please note that in order for this parameter to work "<strong>Enable Promotional Codes</strong>" option must be enabled.</p>

				<h3><strong>title='' parameter</strong></h3>
				<p>Will let you set a title for your booking forms. This is especially useful to use when you are displaying your forms in the overlay mode.<br>
				<code>Example: [ponorezGroupBooking name="groupname" guests="345,234,123" title='My Group Booking Form Title']</code></p>

				<h2><strong>Displaying multiple booking forms on the same page</strong></h2>		
				<p>Currently this pugin can be used to generate up to 14 booking form on the same page by using the following shortcode variations:</p>
				<code>[ponorezGroupBooking-01 name="groupname1" guests="123,234,345"]</code><br>
				<code>[ponorezGroupBooking-02 name="groupname2" guests="345,234,123"]</code><br>
				<code>[ponorezGroupBooking-03 name="groupname3" guests="234,345,123"]</code><br>
				<code>[ponorezGroupBooking-04 name="groupname4" guests="123,234,345"]</code><br>
				<code>[ponorezGroupBooking-05 name="groupname5" guests="234,345,123"]</code><br>
				<code>[ponorezGroupBooking-06 name="groupname6" guests="345,234,123"]</code><br>
				<code>[ponorezGroupBooking-07 name="groupname1" guests="123,234,345"]</code><br>
				<code>[ponorezGroupBooking-08 name="groupname2" guests="345,234,123"]</code><br>
				<code>[ponorezGroupBooking-09 name="groupname3" guests="234,345,123"]</code><br>
				<code>[ponorezGroupBooking-10 name="groupname4" guests="123,234,345"]</code><br>
				<code>[ponorezGroupBooking-11 name="groupname5" guests="234,345,123"]</code><br>
				<code>[ponorezGroupBooking-12 name="groupname6" guests="345,234,123"]</code><br>
				<code>[ponorezGroupBooking-13 name="groupname1" guests="123,234,345"]</code><br>
				<code>[ponorezGroupBooking-14 name="groupname2" guests="345,234,123"]</code>

			</div>

		<?php
			
        } // end if/else
         
		?>
         
    </div><!-- /.wrap -->