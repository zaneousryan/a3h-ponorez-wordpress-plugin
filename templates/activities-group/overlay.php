<div id="wrapper-<?php echo $a[ 'name' ]; ?>">

	<style>
	.ui-widget-header { background: none; background-color: <?php echo get_option('primaryColor'); ?>!important ; border: none; }
	.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { color: <?php echo get_option('primaryColor'); ?>!important; }
	.pr-btn-book-now { background: <?php echo get_option('primaryColor'); ?>!important; color: <?php echo get_option('textColor'); ?>!important }
	.pr-btn-book-now:hover { background: <?php echo get_option('secondaryColor'); ?>!important; }
	.booking-form .date-selector a { color: <?php echo get_option('primaryColor'); ?>!important; }
	.booking-form .date-selector a:hover { color: <?php echo get_option('secondaryColor'); ?>!important; }
</style>

	<!-- Trigger/Open Modal -->
	<a class="pr-btn-book-now" href="#modal-<?php echo $a[ 'name' ]; ?>" rel="modal:open"><?php echo $bookNowText; ?></a>
	
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

						//Load the DatePicker Field
						echo '<label>Choose Date</label>';
						echo do_shortcode('[loadPonorezDatePicker]');

						//Load minAvailability Select
						echo do_shortcode('[loadPonorezMinAvailability]'); 

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
						
						//Load Accommodation and Transportation Fields
						$accommodationStatusCheck = get_option('accommodationStatus');
						$couponsStatusCheck = get_option('couponsStatus');

						if(!empty( $accommodationStatusCheck ) && $accommodationType == 'fixed') {

							//Load Hotels Select
							echo '<div class="form-row" id="accommodation">';
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
