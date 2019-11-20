<div id="wrapper-<?php echo $myActivityID; ?>">

	<style>
		.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { color: <?php echo get_option('primaryColor'); ?>; }
		.button.button-book-now { background: <?php echo get_option('primaryColor'); ?>; color: <?php echo get_option('textColor'); ?> }
		.button.button-book-now:hover { background: <?php echo get_option('secondaryColor'); ?>; }
		.booking-form .date-selector a { color: <?php echo get_option('primaryColor'); ?>; }
		.booking-form .date-selector a:hover { color: <?php echo get_option('secondaryColor'); ?>; }
		.ponorezmodal .modal-content.photos{max-width: 936px; width:100%;}
		.form-control.date{width: 95%;}	
		ul.wp-block-gallery{margin: 0;}
		ul.wp-block-gallery li{margin: 0; padding:10px 0px 1px 12px;}
		@media only screen and (max-width: 768px){ul.wp-block-gallery li{padding-right:12px;}}
		.wp-block-gallery li{list-style: none; list-style-type: none;}.elementor-widget-wrap {cursor: pointer;height: 100%;position: relative;overflow: hidden;width: 100%;text-align:center;}.elementor-widget-wrap .fadedbox {background-color: #666666;position: absolute;top: 0;left: 0;color: #fff;-webkit-transition: all 300ms ease-out;-moz-transition: all 300ms ease-out; -o-transition: all 300ms ease-out;-ms-transition: all 300ms ease-out; transition: all 300ms ease-out;opacity: 0; width: 100%; height: 98%;}.elementor-widget-wrap:hover .fadedbox { opacity: 0.8; }.elementor-widget-wrap .text {-webkit-transition: all 300ms ease-out;-moz-transition: all 300ms ease-out;-o-transition: all 300ms ease-out;-ms-transition: all 300ms ease-out;transition: all 300ms ease-out;transform: translateY(30px);-webkit-transform: translateY(30px);}.elementor-widget-wrap .title {text-transform: uppercase; opacity: 0;transition-delay: 0.2s;transition-duration: 0.3s;}.elementor-widget-wrap:hover .title,.elementor-widget-wrap:focus .title {opacity: 1;transform: translateY(0px);-webkit-transform: translateY(0px);}.title h2{color:#FFF;padding-top: 42.67%;}		.ui-widget-header { background: none; background-color: <?php echo get_option('primaryColor'); ?> ; border: none; }
		a img.image_picker_image{border: 3px solid #666; transition: .5s all; border-radius: 5px;}
		a img.image_picker_image:hover{border-color: #FFCC66;}
	</style>

	<!-- Trigger/Open Main Modal -->
	<a class="button button-book-now" href="#modal-main" rel="modal:open"><?php echo $bookNowText; ?></a>

	<div id="modal-main" class="ponorezmodal">
		<div class='modal-content photos'>
			<ul class="wp-block-gallery columns-2 is-cropped">
				<li>
					<div class="elementor-widget-wrap">
						<a href="#modal-Mat-Main" rel="modal:open"><img src="<?php echo plugins_url() . '/a3h-ponorez-wordpress-plugin/assets/images/traditional-cap.jpg'; ?>" /></a>
					</div>
				</li>
				<li>
					<div class="elementor-widget-wrap">
						<a href="#modal-Table-Main" rel="modal:open"><img src="<?php echo plugins_url() . '/a3h-ponorez-wordpress-plugin/assets/images/tables-cap.jpg'; ?>" /></a>
					</div>
				</li>
			</ul>	
		</div>
	</div>
	
	<!-- The Traditional Modal -->
	<div id="modal-Mat-Main" class="ponorezmodal">

		<!-- Modal content -->
		<div class="modal-content">

			<form class="booking-form ponorezActivity-Mat-Main">

				<div class="modal-header clearfix">

					<h3>Traditional Seating</h3>
					<a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

				</div>

				<div class="modal-body">

					<?php 

						//Set Activity ID
						echo do_shortcode('[loadPonorezActivity id="'.$myActivityID.'"]');
					?>	
						<div id="availableGuests12199">
							<div class="form-row">
								<label>Adult (13 Yrs & Older)</label>
								<select class="form-control" id="trad_t3544">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
								</select>
							</div>
							<div class="form-row">
								<label>Child (3-12 Yrs)</label>
								<select class="form-control" id="trad_t3545">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
								</select>
							</div>
							<div class="form-row">
								<label>Infant</label>
								<select class="form-control" id="trad_t3546">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
								</select>
							</div>
						</div>

					<?php	
						// Attach active guest types to booking function		// Attach active guest types to booking function
						$printGT1 = 'addGuests(3544, document.getElementById(\'trad_t3544\').value); ';

						$printGT2 = 'addGuests(3545, document.getElementById(\'trad_t3545\').value); ';

						$printGT3 = 'addGuests(3546, document.getElementById(\'trad_t3546\').value); ';

						//Load Google Analytics ID
						$googleAnalyticsID = get_option('googleAnalyticsID');
						$setGoogleAnalyticsID = 'setgoogleanalytics(\'' . $googleAnalyticsID . '\');';

						//Load the DatePicker Field
					?>
					<script>
						function showMinAvailable20(){
							var activityControl = <?php echo $myActivityID;?>,
								dateControl = 'date_Mat_Main',
								totalGuestCount = 0,
								minAvailable = { guests: {} };

							minAvailable.guests[3544] = document.getElementById('trad_t3544').value;
							totalGuestCount += parseInt(document.getElementById('trad_t3544').value);

							minAvailable.guests[3545] = document.getElementById('trad_t3545').value;
							totalGuestCount += parseInt(document.getElementById('trad_t3545').value);

							minAvailable.guests[3546] = document.getElementById('trad_t3546').value;
							totalGuestCount += parseInt(document.getElementById('trad_t3546').value);

							if (totalGuestCount == 0) {
								console.log(parseInt(document.getElementById('guests_a<?php echo $myActivityID;?>_t3544').value));
								alert('Please select guest count for all guest types');
								//return null;
							}else if( totalGuestCount >= 15 ){
								alert('For parties of more than 14 people, please call in your reservation.');
								window.location.replace("tel:+18002485828");
							}else {
								// Show calendar (only if all guest type counts are correct)
								calendar(activityControl, dateControl, false, minAvailable, new Date().getDate()<25?1:2);
							}
						}
					</script>
					<label>Choose Date</label>
					<div class="form-row date-selector">
						<input class="form-control date" id='date_Mat_Main' onclick='showMinAvailable20()'>
							<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showMinAvailable20();">
								<i class="fa fa-calendar" aria-hidden="true"></i>
							</a>
					</div>

				</div>

				<div class="modal-footer">

					<div class="form-row">

						<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
						<input type="button" class="button button-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_Mat_Main').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php echo $printGT1; echo $printGT2; echo $printGT3; if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

					</div>

				</div>

			</form>

		</div>
	
	</div>

	<!-- The Table and Chairs Modal -->
	<div id="modal-Table-Main" class="ponorezmodal">

		<!-- Modal content -->
		<div class="modal-content">

			<form class="booking-form ponorezActivity-Table-Main">

				<div class="modal-header clearfix">

					<h3>Table &amp; Chairs</h3>
					<a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

				</div>

				<div class="modal-body">

					<?php 

						//Set Activity ID
						echo do_shortcode('[loadPonorezActivity id="'.$myActivityID.'"]');

					?>	
						<div id="availableGuests12199">
							<div class="form-row">
								<label>Adult (13 Yrs & Older)</label>
								<select class="form-control" id="table_t3542">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
								</select>
							</div>
							<div class="form-row">
								<label>Child (3-12 Yrs)</label>
								<select class="form-control" id="table_t3543">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
								</select>
							</div>
							<div class="form-row">
								<label>Infant</label>
								<select class="form-control" id="table_t3546">
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
								</select>
							</div>
						</div>

					<?php	

						// Attach active guest types to booking function		// Attach active guest types to booking function
						$printGT1 = 'addGuests(3542, document.getElementById(\'table_t3542\').value); ';

						$printGT2 = 'addGuests(3543, document.getElementById(\'table_t3543\').value); ';

						$printGT3 = 'addGuests(3546, document.getElementById(\'table_t3546\').value); ';

						//Load Google Analytics ID
						$googleAnalyticsID = get_option('googleAnalyticsID');
						$setGoogleAnalyticsID = 'setgoogleanalytics(\'' . $googleAnalyticsID . '\');';

						//Load the DatePicker Field
				?>
					<script>
						function showMinAvailable21(){
							var activityControl = <?php echo $myActivityID;?>,
								dateControl = 'date_Table_Main',
								totalGuestCount = 0,
								minAvailable = { guests: {} };

							minAvailable.guests[3542] = document.getElementById('table_t3542').value;
							totalGuestCount += parseInt(document.getElementById('table_t3542').value);

							minAvailable.guests[3543] = document.getElementById('table_t3543').value;
							totalGuestCount += parseInt(document.getElementById('table_t3543').value);

							minAvailable.guests[3546] = document.getElementById('table_t3546').value;
							totalGuestCount += parseInt(document.getElementById('table_t3546').value);

							if (0 == totalGuestCount) {
								alert('Please select guest count for all guest types');
								//return null;
							}else if( totalGuestCount >= 15 ){
								alert('For parties of more than 14 people, please call in your reservation.');
								window.location.replace("tel:+18002485828");
							}else {
								// Show calendar (only if all guest type counts are correct)
								calendar(activityControl, dateControl, false, minAvailable, new Date().getDate()<25?1:2);
							}
						}
					</script>
					<label>Choose Date</label>
					<div class="form-row date-selector">
						<input class="form-control date" id='date_Table_Main' onclick='showMinAvailable21()'>
							<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showMinAvailable21();">
								<i class="fa fa-calendar" aria-hidden="true"></i>
							</a>
					</div>

				</div>

				<div class="modal-footer">

					<div class="form-row">

						<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
						<input type="button" class="button button-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_Table_Main').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php echo $printGT1; echo $printGT2; echo $printGT3; if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

					</div>

				</div>

			</form>

		</div>
	
	</div>

</div>
