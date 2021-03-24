<div id="wrapper-<?php echo $myActivityID; ?>">

	<style>
		.ui-widget-header { background: none; background-color: <?php echo get_option('primaryColor'); ?>!important ; border: none; }
	.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { color: <?php echo get_option('primaryColor'); ?>!important; }
	.pr-btn-book-now { background: <?php echo get_option('primaryColor'); ?>!important; color: <?php echo get_option('textColor'); ?>!important }
	.pr-btn-book-now:hover { background: <?php echo get_option('secondaryColor'); ?>!important; }
	.booking-form .date-selector a { color: <?php echo get_option('primaryColor'); ?>!important; }
	.booking-form .date-selector a:hover { color: <?php echo get_option('secondaryColor'); ?>!important; }
	</style>

	<!-- Trigger/Open Modal -->
	<a class="pr-btn-book-now" id="ponorez-book-button-<?php echo $overlayId; ?>" href="#pono-rez-booking-modal-<?php echo $overlayId; ?>" rel="modal:open"><?php echo $bookNowText; ?></a>
	<!-- The Modal -->
	<div id="pono-rez-booking-modal-<?php echo $overlayId; ?>" class="ponorezmodal">

		<!-- Modal content -->
		<div class="modal-content">

			<form class="booking-form ponorezActivity-<?php echo $myActivityID; ?>">

				<div class="modal-header clearfix">

					<?php echo '<h3>' . $formTitle . '</h3>'; ?>
					<a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

				</div>

				<div class="modal-body">

					<?php 

						//Set Activity ID
						echo do_shortcode('[loadPonorezActivity id="'.$myActivityID.'"]');

						echo '<div id="availableGuests'. $myActivityID . '" class="hide-guest00">';

						//Load Guest Types Select Fields
						foreach ($guestTypes as $guest) { 
					
							$html = '';

							for($i=1; $i<=20; $i++){
								$gType = ${'guestType' . $i . 'Label'};
								$gID = ${'guestType' . $i . 'ID'};
								$gMin = ${'guestType' . $i . 'MinGuest'};
								$gMax = ${'guestType' . $i . 'MaxGuest'};

								if (isset($guestTypes[0]) && $guest == $gID) {
									$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$gID.'" name="'.$gType.'" min="'.$gMin.'" max="'.$gMax.'"]');
								}
							}

							print $html;

						}

						echo '</div>';

						// Attach active guest types to booking function
						foreach ($guestTypes as $guest) { 

							for($i=0; $i<=19; $i++){
								$x=$i+1;

								if (isset($guestTypes[$i]) && $guest == $guestTypes[$i]) {
									${'printGT' . $x} = 'addGuests(' . $guestTypes[$i] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[$i] .'\').value); ';
								}
							}

						}

						//Load Private Guest Type Fields	
						foreach ($privateGuests as $privateGuestID) { 

							$html = '';

							for($i=1; $i<=20; $i++){
								$gType = ${'guestType' . $i . 'Label'};
								$gID = ${'guestType' . $i . 'ID'};
								$gMin = ${'guestType' . $i . 'MinGuest'};
								$gMax = ${'guestType' . $i . 'MaxGuest'};

								if (isset($privateGuests[0]) && $privateGuestID == null) {
								}elseif (isset($privateGuests[0]) && $privateGuestID == $gID) {
									$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$gID.'" name="'.$gType.'" min="'.$gMin.'" max="'.$gMax.'"]');
								}
							}

							print $html;

						}

						// Attach active private tour option to booking function
						foreach ($privateGuests as $privateGuestID) { 

							for($i=0; $i<=19; $i++){

								if (isset($privateGuests[$i]) && $privateGuestID == null) {
								} elseif (isset($privateGuests[$i]) && $privateGuestID == $privateGuests[$i]) {
									$printPG1 = 'addGuests(' . $privateGuests[$i] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[$i] .'\').value); ';
									$printPG1js = '#guests_a' . $myActivityID . '_t' . $privateGuests[$i];
								}
							}
							
						}

						//Load the DatePicker Field
						?>
							<script>
								function showMinAvailable0(){
									var activityControl = <?php echo $myActivityID;?>,
										dateControl = 'date_a<?php echo $myActivityID; ?>',
										totalGuestCount = 0,
										minAvailable = { guests: {} };
									<?php
										foreach ($guestTypes as $guest) {
											for($i=1; $i<=20; $i++){
												$gID = ${'guestType' . $i . 'ID'};

												if (isset($guestTypes[0]) && $guest == $gID) {
													?>
													minAvailable.guests[<?php echo $gID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $gID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $gID;?>').value);
													<?php
												}
											} 
										}
									?>

								  if (0 == totalGuestCount) {
								    alert('Please select guest count for all guest types');
								    //return null;
								  }
								  else {
								    // Show calendar (only if all guest type counts are correct)
								    calendar(activityControl, dateControl, false, minAvailable);
								  }
								}
							</script>
							<?php 
							$selected_date = get_query_var('date');
							if($selected_date){
								?>
								<style type="text/css">.hide-this{display: none;}</style>
								<?php
							}
							?>
							<label class="hide-this">Choose Date</label>
							<div class="form-row date-selector hide-this">
								<input class="form-control" id='date_a<?php echo $myActivityID; ?>' onclick='showMinAvailable0()' value='<?php echo $selected_date;?>'>
									<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showMinAvailable0();">
										<i class="fa fa-calendar" aria-hidden="true"></i>
									</a>
							</div>
							<?php 
							$fix_guest = get_query_var('fix_guest');
							if($fix_guest == '1'){
								?>
								<style type="text/css">.hide-guest00{
									display: none;
								}</style>
								<script type="text/javascript">
									jQuery('.hide-guest00 input[name=guestCheckbox]').click();
									jQuery('.hide-guest00 select').val(1);
									
								</script>
								<?php
							}
							else if($fix_guest != 0){
								$guest_id = explode(",",$fix_guest);
								$temp = 'guests_a'.$myActivityID.'_t'.$guest_id[0];
								?>
								<script type="text/javascript">
									jQuery("select#<?php echo $temp; ?>").val(1);
									jQuery("input#<?php echo $temp; ?>").click();
									jQuery("#<?php echo $temp; ?>").parent().css('display','none');
								</script>
								<?php
							}
							?>

						<?php

						//Load Upgrade Types Select Fields
						foreach ($upgradeTypes as $upgrade) { 

							$html = '';

							for($i=1; $i<=20; $i++){
								$uType = ${'upgradeType' . $i . 'Label'};
								$uID = ${'upgradeType' . $i . 'ID'};
								$uMin = ${'upgradeType' . $i . 'Min'};
								$uMax = ${'upgradeType' . $i . 'Max'};

								if(isset($upgradeTypes[0]) && $upgradeTypes[0] != null){
									if ($upgrade == $uID) {
										$html .= do_shortcode('[loadPonorezUpgradeField id="'.$uID.'" name="'.$uType.'" min="'.$uMin.'" max="'.$uMax.'"]');
									}
								}
							}

							print $html;

						}

						// Attach active upgrade types to booking function
						foreach ($upgradeTypes as $upgrade) { 

							for($i=0; $i<=19; $i++){
								$x = $i + 1;

								if(isset($upgradeTypes[0]) && $upgradeTypes[0] != null){
									if ($upgrade == $upgradeTypes[$i]) {
										${'printUG' . $x} = 'addUpgrades(' . $upgradeTypes[$i] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[$i] .'\').value); ';
									}
								}

							}
						}

						//Load Accommodation and Transportation Fields

						$accommodationStatusCheck = get_option('accommodationStatus');
						$couponsStatusCheck = get_option('couponsStatus');
						$promoCodeFieldJS = 'setpromotionalcode(document.getElementById(\'promotionalcode_' . $myActivityID . '\').value);';

						//Load Google Analytics ID
						$googleAnalyticsID = get_option('googleAnalyticsID');
						$setGoogleAnalyticsID = 'setgoogleanalytics(\'' . $googleAnalyticsID . '\');';

						if(!empty( $accommodationStatusCheck ) && $accommodationType == 'fixed') {

							//Load Hotels Select
							echo '<div class="form-row">';
							echo '<label>Select Accommodation</label>';
							echo '<label style="font-weight: normal; font-size: 12px; display: block;">Select Hotel</label>';
							echo do_shortcode('[loadPonorezAccommodation]');
							echo '</div>';

							//Load Hotel Room Number Field
							echo '<div class="form-row">';
							echo '<label style="font-weight: normal; font-size: 12px; margin-top: 10px; display: block;">Room number</label>';
							echo do_shortcode('[loadPonorezHotelRoom]');
							echo do_shortcode('[loadPonoreztransportation]');
							echo '</div>';

							if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') {

								if(empty( $promotionalCode )) {	

									echo '<div class="form-row">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								} else {

									echo '<div class="form-row" style="display: none;">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								}
							
							} else {

								// Do nothing

								}

						} elseif(!empty( $accommodationStatusCheck ) && $accommodationType == 'popup') {

							if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') {

								if(empty( $promotionalCode )) {	

									echo '<div class="form-row">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								} else {

									echo '<div class="form-row" style="display: none;">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								}
							
							} else {

								// Do nothing

								}

						} elseif(!empty( $accommodationStatusCheck ) && $accommodationType == 'checkout') {

							if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') {

								if(empty( $promotionalCode )) {	

									echo '<div class="form-row">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								} else {

									echo '<div class="form-row" style="display: none;">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								}
							
							} else {

								// Do nothing

								}

						} elseif(!empty( $accommodationStatusCheck ) && $accommodationType == 'disabled') {

							if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') {

								if(empty( $promotionalCode )) {	

									echo '<div class="form-row">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								} else {

									echo '<div class="form-row" style="display: none;">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								}
							
							} else {

								// Do nothing

								}

						} else {

							if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') {

								if(empty( $promotionalCode )) {	

									echo '<div class="form-row">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								} else {

									echo '<div class="form-row" style="display: none;">';
									echo '<label>Promotional Code</label>';
									echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $myActivityID . '" />';
									echo '</div>';

								}
							
							} else {

								// Do nothing

							}

						}

					?>	

				</div>

				<div class="modal-footer">

					<div class="form-row">

						<?php	

							if(!empty( $accommodationStatusCheck ) && $accommodationType == 'fixed') {

						?>

							<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
							<input type="button" class="pr-btn-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} ?> setHotel(jQuery('#hotel_a<?php echo $myActivityID; ?>').val()); setRoom(jQuery('#room_a<?php echo $myActivityID; ?>').val()); setTransportationRoute(jQuery('[name=\'transportationroute_a<?php echo $myActivityID; ?>\']:visible:checked').val()); setAccommodationFixed(); <?php if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

						<?php	

							} elseif(!empty( $accommodationStatusCheck ) && $accommodationType == 'popup') {

						?>

							<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
							<input type="button" class="pr-btn-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} ?> setAccommodationFixed(); <?php if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

						<?php

							} elseif(!empty( $accommodationStatusCheck ) && $accommodationType == 'checkout') {

						?>

							<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
							<input type="button" class="pr-btn-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

						<?php

							} else {
						?>

							<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
							<input type="button" class="pr-btn-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} ?> setAccommodationFixed(); <?php if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

						<?php

							}

						?>	

					</div>

				</div>

				<script>

					jQuery('<?php if (isset($printPG1js)) { echo $printPG1js; } if (isset($printPG2js)) { echo $printPG2js; } if (isset($printPG3js)) {	echo $printPG3js; } if (isset($printPG4js)) { echo $printPG4js; } if (isset($printPG5js)) {	echo $printPG5js; } if (isset($printPG6js)) { echo $printPG6js; } if (isset($printPG7js)) { echo $printPG7js; } if (isset($printPG8js)) { echo $printPG8js; } if (isset($printPG9js)) {	echo $printGT9js; } if (isset($printPG10js)) { echo $printPG10js; } if (isset($printPG11js)) { echo $printPG11js; } if (isset($printPG12js)) { echo $printPG12js; } if (isset($printPG13js)) { echo $printPG13js; } if (isset($printPG14js)) { echo $printPG14js; } if (isset($printPG15js)) { echo $printPG15js; } if (isset($printPG16js)) { echo $printPG16js; } if (isset($printPG17js)) { echo $printPG17js; } if (isset($printPG18js)) { echo $printPG18js; } if (isset($printPG19js)) { echo $printPG19js; } if (isset($printPG20js)) { echo $printPG20js; } ?>').bind('change', function (e) { 

						if( jQuery('<?php if (isset($printPG1js)) { echo $printPG1js; } if (isset($printPG2js)) { echo $printPG2js; } if (isset($printPG3js)) {	echo $printPG3js; } if (isset($printPG4js)) { echo $printPG4js; } if (isset($printPG5js)) {	echo $printPG5js; } if (isset($printPG6js)) { echo $printPG6js; } if (isset($printPG7js)) { echo $printPG7js; } if (isset($printPG8js)) { echo $printPG8js; } if (isset($printPG9js)) {	echo $printGT9js; } if (isset($printPG10js)) { echo $printPG10js; } if (isset($printPG11js)) { echo $printPG11js; } if (isset($printPG12js)) { echo $printPG12js; } if (isset($printPG13js)) { echo $printPG13js; } if (isset($printPG14js)) { echo $printPG14js; } if (isset($printPG15js)) { echo $printPG15js; } if (isset($printPG16js)) { echo $printPG16js; } if (isset($printPG17js)) { echo $printPG17js; } if (isset($printPG18js)) { echo $printPG18js; } if (isset($printPG19js)) { echo $printPG19js; } if (isset($printPG20js)) { echo $printPG20js; } ?>').val() == 0) {

							jQuery('#availableGuests<?php echo $myActivityID; ?>').show();

						} else {

							jQuery('#availableGuests<?php echo $myActivityID; ?>').hide();
						}         

					});

					jQuery('<?php if (isset($printPG1js)) { echo $printPG1js; } if (isset($printPG2js)) { echo $printPG2js; } if (isset($printPG3js)) {	echo $printPG3js; } if (isset($printPG4js)) { echo $printPG4js; } if (isset($printPG5js)) {	echo $printPG5js; } if (isset($printPG6js)) { echo $printPG6js; } if (isset($printPG7js)) { echo $printPG7js; } if (isset($printPG8js)) { echo $printPG8js; } if (isset($printPG9js)) {	echo $printGT9js; } if (isset($printPG10js)) { echo $printPG10js; } if (isset($printPG11js)) { echo $printPG11js; } if (isset($printPG12js)) { echo $printPG12js; } if (isset($printPG13js)) { echo $printPG13js; } if (isset($printPG14js)) { echo $printPG14js; } if (isset($printPG15js)) { echo $printPG15js; } if (isset($printPG16js)) { echo $printPG16js; } if (isset($printPG17js)) { echo $printPG17js; } if (isset($printPG18js)) { echo $printPG18js; } if (isset($printPG19js)) { echo $printPG19js; } if (isset($printPG20js)) { echo $printPG20js; } ?>').click(function() {

						jQuery('#availableGuests<?php echo $myActivityID; ?> select').prop('selectedIndex',0);			

						jQuery('<?php if (isset($printPG1js)) { echo $printPG1js; } if (isset($printPG2js)) { echo $printPG2js; } if (isset($printPG3js)) {	echo $printPG3js; } if (isset($printPG4js)) { echo $printPG4js; } if (isset($printPG5js)) {	echo $printPG5js; } if (isset($printPG6js)) { echo $printPG6js; } if (isset($printPG7js)) { echo $printPG7js; } if (isset($printPG8js)) { echo $printPG8js; } if (isset($printPG9js)) {	echo $printGT9js; } if (isset($printPG10js)) { echo $printPG10js; } if (isset($printPG11js)) { echo $printPG11js; } if (isset($printPG12js)) { echo $printPG12js; } if (isset($printPG13js)) { echo $printPG13js; } if (isset($printPG14js)) { echo $printPG14js; } if (isset($printPG15js)) { echo $printPG15js; } if (isset($printPG16js)) { echo $printPG16js; } if (isset($printPG17js)) { echo $printPG17js; } if (isset($printPG18js)) { echo $printPG18js; } if (isset($printPG19js)) { echo $printPG19js; } if (isset($printPG20js)) { echo $printPG20js; } ?>').change(function() {

							if (jQuery(this).prop('checked')) {

								console.log('Shared Guests fields value was set to 0.');
								console.log('Shared Guests fields were hidden.');

							} else {

								console.log('Shared Guests fields were displayed.');

							}

						});

					});

				</script>

			</form>

			<script>
				
				jQuery(document).ready(function() {
					
					jQuery("#promotionalcode_<?php echo $myActivityID ?>").val("<?php echo $promotionalCode; ?>"); 
				
				});
				
			</script>

		</div>
	
	</div>
	
</div>
