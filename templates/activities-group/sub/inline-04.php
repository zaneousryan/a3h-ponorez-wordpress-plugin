<style>
	.ui-widget-header { background: none; background-color: <?php echo get_option('primaryColor'); ?> ; border: none; }
	.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { color: <?php echo get_option('primaryColor'); ?>; }
	.button.button-book-now { background: <?php echo get_option('primaryColor'); ?>; color: <?php echo get_option('textColor'); ?> }
	.button.button-book-now:hover { background: <?php echo get_option('secondaryColor'); ?>; }
	.booking-form .date-selector a { color: <?php echo get_option('primaryColor'); ?>; }
	.booking-form .date-selector a:hover { color: <?php echo get_option('secondaryColor'); ?>; }
</style>

<?php echo '<h3>' . $a[ 'title' ] . '</h3>'; ?>

<form class="booking-form ponorezGroup-<?php echo $a[ 'name' ]; ?> clearfix">
  		
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
		echo '<label>Choose Pass Pick Up Date</label>';
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
				$x = $i - 1;

				if($i==1){
					if (isset($upgradeTypes[$x]) && $upgradeTypes[$x] != null && $upgrade == $uID) {
						$html .= do_shortcode('[loadPonorezUpgradeField id="'.$uID.'" name="'.$uType.'" min="'.$uMin.'" max="'.$uMax.'"]');
					}
				}else{
					if(isset($upgradeTypes[$x]) != null && $upgrade == $uID) {
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
	
		//Load Form Submit Button
		echo '<div class="form-row">';
		echo do_shortcode('[loadPonorezCheckGroupAvailability]');
		echo '</div>';
	
	?>

</form>

<script>
	
	jQuery(document).ready(function() {
		
		jQuery("#promotionalcode_<?php echo $a[ 'name' ] ?>").val("<?php echo $promotionalCode; ?>"); 
	
	});
	
</script>