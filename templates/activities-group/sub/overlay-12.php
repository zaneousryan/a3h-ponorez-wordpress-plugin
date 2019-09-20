<div id="wrapper-<?php echo $a[ 'name' ]; ?>">

	<style>
		.ui-widget-header { background: none; background-color: <?php echo get_option('primaryColor'); ?> ; border: none; }
		.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { color: <?php echo get_option('primaryColor'); ?>; }
		.button.button-book-now { background: <?php echo get_option('primaryColor'); ?>; color: <?php echo get_option('textColor'); ?> }
		.button.button-book-now:hover { background: <?php echo get_option('secondaryColor'); ?>; }
		.booking-form .date-selector a { color: <?php echo get_option('primaryColor'); ?>; }
		.booking-form .date-selector a:hover { color: <?php echo get_option('secondaryColor'); ?>; }
	</style>

	<!-- Trigger/Open Modal -->
	<a class="button button-book-now" href="#modal-<?php echo $a[ 'name' ]; ?>" rel="modal:open"><?php echo $bookNowText; ?></a>
	
	<!-- The Modal -->
	<div id="modal-<?php echo $a[ 'name' ]; ?>" class="ponorezmodal">

		<!-- Modal content -->
		<div class="modal-content">

			<form class="booking-form ponorezActivity-<?php echo $a[ 'name' ]; ?>">

				<div class="modal-header clearfix">

					<?php echo '<h3>' . $a[ 'title' ] . '</h3>'; ?>
					<a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

				</div>

				<div class="modal-body">

					<?php

						//Load Guest Types Select Fields		//Load Guest Types Select Fields
						foreach ($guestTypes as $guest) { 

							$html = '';

							if (isset($guestTypes[0]) && $guest == $guestType1ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType1ID.'" name="'.$guestType1Label.'" min="'.$guestType1MinGuest.'" max="'.$guestType1MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType2ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType2ID.'" name="'.$guestType2Label.'" min="'.$guestType2MinGuest.'" max="'.$guestType2MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType3ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType3ID.'" name="'.$guestType3Label.'" min="'.$guestType3MinGuest.'" max="'.$guestType3MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType4ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType4ID.'" name="'.$guestType4Label.'" min="'.$guestType4MinGuest.'" max="'.$guestType4MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType5ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType5ID.'" name="'.$guestType5Label.'" min="'.$guestType5MinGuest.'" max="'.$guestType5MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType6ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType6ID.'" name="'.$guestType6Label.'" min="'.$guestType6MinGuest.'" max="'.$guestType6MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType7ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType7ID.'" name="'.$guestType7Label.'" min="'.$guestType7MinGuest.'" max="'.$guestType7MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType8ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType8ID.'" name="'.$guestType8Label.'" min="'.$guestType8MinGuest.'" max="'.$guestType8MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType9ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType9ID.'" name="'.$guestType9Label.'" min="'.$guestType9MinGuest.'" max="'.$guestType9MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType10ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType10ID.'" name="'.$guestType10Label.'" min="'.$guestType10MinGuest.'" max="'.$guestType10MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType11ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType11ID.'" name="'.$guestType11Label.'" min="'.$guestType11MinGuest.'" max="'.$guestType11MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType12ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType12ID.'" name="'.$guestType12Label.'" min="'.$guestType12MinGuest.'" max="'.$guestType12MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType13ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType13ID.'" name="'.$guestType13Label.'" min="'.$guestType13MinGuest.'" max="'.$guestType13MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType14ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType14ID.'" name="'.$guestType14Label.'" min="'.$guestType14MinGuest.'" max="'.$guestType14MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType15ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType15ID.'" name="'.$guestType15Label.'" min="'.$guestType15MinGuest.'" max="'.$guestType15MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType16ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType16ID.'" name="'.$guestType16Label.'" min="'.$guestType16MinGuest.'" max="'.$guestType16MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType17ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType17ID.'" name="'.$guestType17Label.'" min="'.$guestType17MinGuest.'" max="'.$guestType17MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType18ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType18ID.'" name="'.$guestType18Label.'" min="'.$guestType18MinGuest.'" max="'.$guestType18MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType19ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType19ID.'" name="'.$guestType19Label.'" min="'.$guestType19MinGuest.'" max="'.$guestType19MaxGuest.'"]');

							} elseif (isset($guestTypes[0]) && $guest == $guestType20ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType20ID.'" name="'.$guestType20Label.'" min="'.$guestType20MinGuest.'" max="'.$guestType20MaxGuest.'"]');

							} 

							print $html;

						}

						//Load the DatePicker Field
						echo '<label>Choose Date</label>';
						echo do_shortcode('[loadPonorezDatePicker]');

						//Load minAvailability Select
						echo do_shortcode('[loadPonorezMinAvailability]'); 

						//Load Upgrade Types Select Fields
						foreach ($upgradeTypes as $upgrade) { 

							$html = '';

							if ($upgradeTypes[0] != null && $upgrade == $upgradeType1ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType1ID.'" name="'.$upgradeType1Label.'" min="'.$upgradeType1Min.'" max="'.$upgradeType1Max.'"]');

							} elseif ($upgradeTypes[1] != null && $upgrade == $upgradeType2ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType2ID.'" name="'.$upgradeType2Label.'" min="'.$upgradeType2Min.'" max="'.$upgradeType2Max.'"]');

							} elseif ($upgradeTypes[2] != null && $upgrade == $upgradeType3ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType3ID.'" name="'.$upgradeType3Label.'" min="'.$upgradeType3Min.'" max="'.$upgradeType3Max.'"]');

							} elseif ($upgradeTypes[3] != null && $upgrade == $upgradeType4ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType4ID.'" name="'.$upgradeType4Label.'" min="'.$upgradeType4Min.'" max="'.$upgradeType4Max.'"]');

							} elseif ($upgradeTypes[4] != null && $upgrade == $upgradeType5ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType5ID.'" name="'.$upgradeType5Label.'" min="'.$upgradeType5Min.'" max="'.$upgradeType5Max.'"]');

							} elseif ($upgradeTypes[5] != null && $upgrade == $upgradeType6ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType6ID.'" name="'.$upgradeType6Label.'" min="'.$upgradeType6Min.'" max="'.$upgradeType6Max.'"]');

							} elseif ($upgradeTypes[6] != null && $upgrade == $upgradeType7ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType7ID.'" name="'.$upgradeType7Label.'" min="'.$upgradeType7Min.'" max="'.$upgradeType7Max.'"]');

							} elseif ($upgradeTypes[7] != null && $upgrade == $upgradeType8ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType8ID.'" name="'.$upgradeType8Label.'" min="'.$upgradeType8Min.'" max="'.$upgradeType8Max.'"]');

							} elseif ($upgradeTypes[8] != null && $upgrade == $upgradeType9ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType9ID.'" name="'.$upgradeType9Label.'" min="'.$upgradeType9Min.'" max="'.$upgradeType9Max.'"]');

							} elseif ($upgradeTypes[9] != null && $upgrade == $upgradeType10ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType10ID.'" name="'.$upgradeType10Label.'" min="'.$upgradeType10Min.'" max="'.$upgradeType10Max.'"]');

							} elseif ($upgradeTypes[10] != null && $upgrade == $upgradeType11ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType11ID.'" name="'.$upgradeType11Label.'" min="'.$upgradeType11Min.'" max="'.$upgradeType11Max.'"]');

							} elseif ($upgradeTypes[11] != null && $upgrade == $upgradeType12ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType12ID.'" name="'.$upgradeType12Label.'" min="'.$upgradeType12Min.'" max="'.$upgradeType12Max.'"]');

							} elseif ($upgradeTypes[12] != null && $upgrade == $upgradeType13ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType13ID.'" name="'.$upgradeType13Label.'" min="'.$upgradeType13Min.'" max="'.$upgradeType13Max.'"]');

							} elseif ($upgradeTypes[13] != null && $upgrade == $upgradeType14ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType14ID.'" name="'.$upgradeType14Label.'" min="'.$upgradeType14Min.'" max="'.$upgradeType14Max.'"]');

							} elseif ($upgradeTypes[14] != null && $upgrade == $upgradeType15ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType15ID.'" name="'.$upgradeType15Label.'" min="'.$upgradeType15Min.'" max="'.$upgradeType15Max.'"]');

							} elseif ($upgradeTypes[15] != null && $upgrade == $upgradeType16ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType16ID.'" name="'.$upgradeType16Label.'" min="'.$upgradeType16Min.'" max="'.$upgradeType16Max.'"]');

							} elseif ($upgradeTypes[16] != null && $upgrade == $upgradeType17ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType17ID.'" name="'.$upgradeType17Label.'" min="'.$upgradeType17Min.'" max="'.$upgradeType17Max.'"]');

							} elseif ($upgradeTypes[17] != null && $upgrade == $upgradeType18ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType18ID.'" name="'.$upgradeType18Label.'" min="'.$upgradeType18Min.'" max="'.$upgradeType18Max.'"]');

							} elseif ($upgradeTypes[18] != null && $upgrade == $upgradeType19ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType19ID.'" name="'.$upgradeType19Label.'" min="'.$upgradeType19Min.'" max="'.$upgradeType19Max.'"]');

							} elseif ($upgradeTypes[19] != null && $upgrade == $upgradeType20ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType20ID.'" name="'.$upgradeType20Label.'" min="'.$upgradeType20Min.'" max="'.$upgradeType20Max.'"]');

							} 

							print $html;

						}
						
						//Load Accommodation and Transportation Fields
						$accommodationStatusCheck = get_option('accommodationStatus');
						$couponsStatusCheck = get_option('couponsStatus');

						if(!empty( $accommodationStatusCheck ) && $accommodationType == 'fixed') {

							//Load Hotels Select
							echo '<div class="form-row" id="accommodation12">';
							echo '<label>Select Accommodation</label>';
							echo '<label style="font-weight: normal; font-size: 12px; display: block;">Select Hotel</label>';
							echo do_shortcode('[ponorezGroupAccommodationSelect]');
							echo '</div>';

							//Load Hotel Room Number Field
							echo '<div class="form-row">';
							echo '<label style="font-weight: normal; font-size: 12px; margin-top: 10px; display: block;">Room number</label>';
							echo do_shortcode('[loadPonorezHotelRoom]');
							echo do_shortcode('[loadPonorezGroupTransportation]');
							echo '</div>';

							if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') {

					if(empty( $promotionalCode )) {	

						echo '<div class="form-row">';
						echo '<label>Promotional Code</label>';
						echo '<input class="form-control" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
						echo '</div>';

					} else {

						echo '<div class="form-row" style="display: none;">';
						echo '<label>Promotional Code</label>';
						echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
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
						echo '<input class="form-control" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
						echo '</div>';

					} else {

						echo '<div class="form-row" style="display: none;">';
						echo '<label>Promotional Code</label>';
						echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
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
						echo '<input class="form-control" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
						echo '</div>';

					} else {

						echo '<div class="form-row" style="display: none;">';
						echo '<label>Promotional Code</label>';
						echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
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
						echo '<input class="form-control" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
						echo '</div>';

					} else {

						echo '<div class="form-row" style="display: none;">';
						echo '<label>Promotional Code</label>';
						echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
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
						echo '<input class="form-control" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
						echo '</div>';

					} else {

						echo '<div class="form-row" style="display: none;">';
						echo '<label>Promotional Code</label>';
						echo '<input class="form-control" name="promoCode" type="text" id="promotionalcode_' . $a[ 'name' ] . '" />';
						echo '</div>';

					}
				
				} else {

					// Do nothing

							}

						}

						//Load Total Price Calculator
						echo do_shortcode('[loadPonorezTotalPrice]'); 

					?>

				</div>

				<div class="modal-footer">

					<div class="form-row">

						<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">

						<?php

						//Load Form Submit Button
						echo do_shortcode('[loadPonorezCheckGroupAvailability]');

						?>

					</div>

				</div>

			</form>

			<script>
				
				jQuery(document).ready(function() {
					
					jQuery("#promotionalcode_<?php echo $a[ 'name' ] ?>").val("<?php echo $promotionalCode; ?>"); 
				
				});
				
			</script>

		</div>
	
	</div>	
	
</div>
