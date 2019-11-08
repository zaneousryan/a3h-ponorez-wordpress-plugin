<div id="wrapper-<?php echo $myActivityID; ?>">

	<style>
		.ui-widget-header { background: none; background-color: <?php echo get_option('primaryColor'); ?> ; border: none; }
		.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { color: <?php echo get_option('primaryColor'); ?>; }
		.button.button-book-now { background: <?php echo get_option('primaryColor'); ?>; color: <?php echo get_option('textColor'); ?> }
		.button.button-book-now:hover { background: <?php echo get_option('secondaryColor'); ?>; }
		.booking-form .date-selector a { color: <?php echo get_option('primaryColor'); ?>; }
		.booking-form .date-selector a:hover { color: <?php echo get_option('secondaryColor'); ?>; }
	</style>

	<!-- Trigger/Open Modal -->
	<a class="button button-book-now" href="#modal-<?php echo $myActivityID; ?>" rel="modal:open"><?php echo $bookNowText; ?></a>
	
	<!-- The Modal -->
	<div id="modal-<?php echo $myActivityID; ?>" class="ponorezmodal">

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

						echo '<div id="availableGuests'. $myActivityID . '">';

							//Load Guest Types Select Fields
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

						echo '</div>';

						// Attach active guest types to booking function		// Attach active guest types to booking function
						foreach ($guestTypes as $guest) { 

							if (isset($guestTypes[0]) && $guest == $guestTypes[0]) {

								$printGT1 = 'addGuests(' . $guestTypes[0] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[0] .'\').value); ';

							} elseif (isset($guestTypes[1]) && $guest == $guestTypes[1]) {

								$printGT2 = 'addGuests(' . $guestTypes[1] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[1] .'\').value); ';

							} elseif (isset($guestTypes[2]) && $guest == $guestTypes[2]) {

								$printGT3 = 'addGuests(' . $guestTypes[2] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[2] .'\').value); ';

							} elseif (isset($guestTypes[3]) && $guest == $guestTypes[3]) {

								$printGT4 = 'addGuests(' . $guestTypes[3] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[3] .'\').value); ';

							} elseif (isset($guestTypes[4]) && $guest == $guestTypes[4]) {

								$printGT5 = 'addGuests(' . $guestTypes[4] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[4] .'\').value); ';

							} elseif (isset($guestTypes[5]) && $guest == $guestTypes[5]) {

								$printGT6 = 'addGuests(' . $guestTypes[5] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[5] .'\').value); ';	

							} elseif (isset($guestTypes[6]) && $guest == $guestTypes[6]) {

								$printGT7 = 'addGuests(' . $guestTypes[6] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[6] .'\').value); ';	

							} elseif (isset($guestTypes[7]) && $guest == $guestTypes[7]) {

								$printGT8 = 'addGuests(' . $guestTypes[7] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[7] .'\').value); ';	

							} elseif (isset($guestTypes[8]) && $guest == $guestTypes[8]) {

								$printGT9 = 'addGuests(' . $guestTypes[8] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[8] .'\').value); ';	

							} elseif (isset($guestTypes[9]) && $guest == $guestTypes[9]) {

								$printGT10 = 'addGuests(' . $guestTypes[9] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[9] .'\').value); ';	

							} elseif (isset($guestTypes[10]) && $guest == $guestTypes[10]) {

								$printGT11 = 'addGuests(' . $guestTypes[10] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[10] .'\').value); ';	

							} elseif (isset($guestTypes[11]) && $guest == $guestTypes[11]) {

								$printGT12 = 'addGuests(' . $guestTypes[11] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[11] .'\').value); ';	

							} elseif (isset($guestTypes[12]) && $guest == $guestTypes[12]) {

								$printGT13 = 'addGuests(' . $guestTypes[12] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[12] .'\').value); ';	

							} elseif (isset($guestTypes[13]) && $guest == $guestTypes[13]) {

								$printGT14 = 'addGuests(' . $guestTypes[13] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[13] .'\').value); ';	

							} elseif (isset($guestTypes[14]) && $guest == $guestTypes[14]) {

								$printGT15 = 'addGuests(' . $guestTypes[14] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[14] .'\').value); ';	

							} elseif (isset($guestTypes[15]) && $guest == $guestTypes[15]) {

								$printGT16 = 'addGuests(' . $guestTypes[15] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[15] .'\').value); ';	

							} elseif (isset($guestTypes[16]) && $guest == $guestTypes[16]) {

								$printGT17 = 'addGuests(' . $guestTypes[16] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[16] .'\').value); ';	

							} elseif (isset($guestTypes[17]) && $guest == $guestTypes[17]) {

								$printGT18 = 'addGuests(' . $guestTypes[17] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[17] .'\').value); ';	

							} elseif (isset($guestTypes[18]) && $guest == $guestTypes[18]) {


								$printGT19 = 'addGuests(' . $guestTypes[18] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[18] .'\').value); ';	

							} elseif (isset($guestTypes[19]) && $guest == $guestTypes[19]) {

								$printGT20 = 'addGuests(' . $guestTypes[19] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $guestTypes[19] .'\').value); ';	

							} else {

							}
						}

						//Load Private Guest Type Fields	
						foreach ($privateGuests as $privateGuestID) { 

							$html = '';

							if (isset($privateGuests[0]) && $privateGuestID == null) {

								// Do nothing

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType1ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType1ID.'" name="'.$guestType1Label.'" min="'.$guestType1MinGuest.'" max="'.$guestType1MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType2ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType2ID.'" name="'.$guestType2Label.'" min="'.$guestType2MinGuest.'" max="'.$guestType2MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType3ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType3ID.'" name="'.$guestType3Label.'" min="'.$guestType3MinGuest.'" max="'.$guestType3MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType4ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType4ID.'" name="'.$guestType4Label.'" min="'.$guestType4MinGuest.'" max="'.$guestType4MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType5ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType5ID.'" name="'.$guestType5Label.'" min="'.$guestType5MinGuest.'" max="'.$guestType5MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType6ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType6ID.'" name="'.$guestType6Label.'" min="'.$guestType6MinGuest.'" max="'.$guestType6MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType7ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType7ID.'" name="'.$guestType7Label.'" min="'.$guestType7MinGuest.'" max="'.$guestType7MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType8ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType8ID.'" name="'.$guestType8Label.'" min="'.$guestType8MinGuest.'" max="'.$guestType8MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType9ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType9ID.'" name="'.$guestType9Label.'" min="'.$guestType9MinGuest.'" max="'.$guestType9MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType10ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType10ID.'" name="'.$guestType10Label.'" min="'.$guestType10MinGuest.'" max="'.$guestType10MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType11ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType11ID.'" name="'.$guestType11Label.'" min="'.$guestType11MinGuest.'" max="'.$guestType11MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType12ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType12ID.'" name="'.$guestType12Label.'" min="'.$guestType12MinGuest.'" max="'.$guestType12MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType13ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType13ID.'" name="'.$guestType13Label.'" min="'.$guestType13MinGuest.'" max="'.$guestType13MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType14ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType14ID.'" name="'.$guestType14Label.'" min="'.$guestType14MinGuest.'" max="'.$guestType14MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType15ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType15ID.'" name="'.$guestType15Label.'" min="'.$guestType15MinGuest.'" max="'.$guestType15MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType16ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType16ID.'" name="'.$guestType16Label.'" min="'.$guestType16MinGuest.'" max="'.$guestType16MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType17ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType17ID.'" name="'.$guestType17Label.'" min="'.$guestType17MinGuest.'" max="'.$guestType17MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType18ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType18ID.'" name="'.$guestType18Label.'" min="'.$guestType18MinGuest.'" max="'.$guestType18MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType19ID) {

								$html .= do_shortcode('[loadPonorezPrivateGuestField id="'.$guestType19ID.'" name="'.$guestType19Label.'" min="'.$guestType19MinGuest.'" max="'.$guestType19MaxGuest.'"]');

							} elseif (isset($privateGuests[0]) && $privateGuestID == $guestType20ID) {

								$html .= do_shortcode('[loadPonorezActivityGuestField id="'.$guestType20ID.'" name="'.$guestType20Label.'" min="'.$guestType20MinGuest.'" max="'.$guestType20MaxGuest.'"]');

							} 

							print $html;

						}

						// Attach active private tour option to booking function
						foreach ($privateGuests as $privateGuestID) { 

							if (isset($privateGuests[0]) && $privateGuestID == null) {

								// Do nothing

							} elseif (isset($privateGuests[0]) && $privateGuestID == $privateGuests[0]) {

								$printPG1 = 'addGuests(' . $privateGuests[0] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[0] .'\').value); ';
								$printPG1js = '#guests_a' . $myActivityID . '_t' . $privateGuests[0];

							} elseif (isset($privateGuests[1]) && $privateGuestID == $privateGuests[1]) {

								$printPG2 = 'addGuests(' . $privateGuests[1] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[1] .'\').value); ';
								$printPG2js = '#guests_a' . $myActivityID . '_t' . $privateGuests[1];

							} elseif (isset($privateGuests[2]) && $privateGuestID == $privateGuests[2]) {

								$printPG3 = 'addGuests(' . $privateGuests[2] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[2] .'\').value); ';
								$printPG3js = '#guests_a' . $myActivityID . '_t' . $privateGuests[2];

							} elseif (isset($privateGuests[3]) && $privateGuestID == $privateGuests[3]) {

								$printPG4 = 'addGuests(' . $privateGuests[3] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[3] .'\').value); ';
								$printPG4js = '#guests_a' . $myActivityID . '_t' . $privateGuests[3];

							} elseif (isset($privateGuests[4]) && $privateGuestID == $privateGuests[4]) {

								$printPG5 = 'addGuests(' . $privateGuests[4] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[4] .'\').value); ';
								$printPG5js = '#guests_a' . $myActivityID . '_t' . $privateGuests[4];

							} elseif (isset($privateGuests[5]) && $privateGuestID == $privateGuests[5]) {

								$printPG6 = 'addGuests(' . $privateGuests[5] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[5] .'\').value); ';
								$printPG6js = '#guests_a' . $myActivityID . '_t' . $privateGuests[5];

							} elseif (isset($privateGuests[6]) && $privateGuestID == $privateGuests[6]) {

								$printPG7 = 'addGuests(' . $privateGuests[6] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[6] .'\').value); ';
								$printPG7js = '#guests_a' . $myActivityID . '_t' . $privateGuests[6];

							} elseif (isset($privateGuests[7]) && $privateGuestID == $privateGuests[7]) {

								$printPG8 = 'addGuests(' . $privateGuests[8] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[8] .'\').value); ';
								$printPG8js = '#guests_a' . $myActivityID . '_t' . $privateGuests[7];

							} elseif (isset($privateGuests[8]) && $privateGuestID == $privateGuests[8]) {

								$printPG9 = 'addGuests(' . $privateGuests[8] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[8] .'\').value); ';
								$printPG9js = '#guests_a' . $myActivityID . '_t' . $privateGuests[8];

							} elseif (isset($privateGuests[9]) && $privateGuestID == $privateGuests[9]) {

								$printPG10 = 'addGuests(' . $privateGuests[9] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[9] .'\').value); ';
								$printPG10js = '#guests_a' . $myActivityID . '_t' . $privateGuests[9];

							} elseif (isset($privateGuests[10]) && $privateGuestID == $privateGuests[10]) {

								$printPG11 = 'addGuests(' . $privateGuests[10] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[10] .'\').value); ';
								$printPG11js = '#guests_a' . $myActivityID . '_t' . $privateGuests[10];

							} elseif (isset($privateGuests[11]) && $privateGuestID == $privateGuests[11]) {

								$printPG12 = 'addGuests(' . $privateGuests[11] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[11] .'\').value); ';
								$printPG12js = '#guests_a' . $myActivityID . '_t' . $privateGuests[11];

							} elseif (isset($privateGuests[12]) && $privateGuestID == $privateGuests[12]) {

								$printPG13 = 'addGuests(' . $privateGuests[12] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[12] .'\').value); ';
								$printPG13js = '#guests_a' . $myActivityID . '_t' . $privateGuests[12];

							} elseif (isset($privateGuests[13]) && $privateGuestID == $privateGuests[13]) {

								$printPG14 = 'addGuests(' . $privateGuests[13] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[13] .'\').value); ';
								$printPG14js = '#guests_a' . $myActivityID . '_t' . $privateGuests[13];

							} elseif (isset($privateGuests[14]) && $privateGuestID == $privateGuests[14]) {

								$printPG15 = 'addGuests(' . $privateGuests[14] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[14] .'\').value); ';
								$printPG15js = '#guests_a' . $myActivityID . '_t' . $privateGuests[14];

							} elseif (isset($privateGuests[15]) && $privateGuestID == $privateGuests[15]) {

								$printPG16 = 'addGuests(' . $privateGuests[15] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[15] .'\').value); ';
								$printPG16js = '#guests_a' . $myActivityID . '_t' . $privateGuests[15];

							} elseif (isset($privateGuests[16]) && $privateGuestID == $privateGuests[16]) {

								$printPG17 = 'addGuests(' . $privateGuests[16] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[16] .'\').value); ';
								$printPG17js = '#guests_a' . $myActivityID . '_t' . $privateGuests[16];

							} elseif (isset($privateGuests[17]) && $privateGuestID == $privateGuests[17]) {

								$printPG18 = 'addGuests(' . $privateGuests[17] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[17] .'\').value); ';
								$printPG18js = '#guests_a' . $myActivityID . '_t' . $privateGuests[17];

							} elseif (isset($privateGuests[18]) && $privateGuestID == $privateGuests[18]) {

								$printPG19 = 'addGuests(' . $privateGuests[18] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[18] .'\').value); ';
								$printPG19js = '#guests_a' . $myActivityID . '_t' . $privateGuests[18];

							} elseif (isset($privateGuests[19]) && $privateGuestID == $privateGuests[19]) {

								$printPG20 = 'addGuests(' . $privateGuests[19] . ', document.getElementById(\'guests_a' . $myActivityID . '_t' . $privateGuests[19] .'\').value); ';
								$printPG20js = '#guests_a' . $myActivityID . '_t' . $privateGuests[19];

							}

						}

						//Load Google Analytics ID
						$googleAnalyticsID = get_option('googleAnalyticsID');
						$setGoogleAnalyticsID = 'setgoogleanalytics(\'' . $googleAnalyticsID . '\');';

						//Load the DatePicker Field
						?>
							<script>
								function showMinAvailable12(){
									var activityControl = <?php echo $myActivityID;?>,
										dateControl = 'date_a<?php echo $myActivityID; ?>',
										totalGuestCount = 0,
										minAvailable = { guests: {} };
									<?php
										foreach ($guestTypes as $guest) {
											if (isset($guestTypes[0]) && $guest == $guestType1ID) {
												?>
													minAvailable.guests[<?php echo $guestType1ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType1ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType1ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType2ID) {
												?>
													minAvailable.guests[<?php echo $guestType2ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType2ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType2ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType3ID) {
												?>
													minAvailable.guests[<?php echo $guestType3ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType3ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType3ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType4ID) {
												?>
													minAvailable.guests[<?php echo $guestType4ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType4ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType4ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType5ID) {
												?>
													minAvailable.guests[<?php echo $guestType5ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType5ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType5ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType6ID) {
												?>
													minAvailable.guests[<?php echo $guestType6ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType6ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType6ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType7ID) {
												?>
													minAvailable.guests[<?php echo $guestType7ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType7ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType7ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType8ID) {
												?>
													minAvailable.guests[<?php echo $guestType8ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType8ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType8ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType9ID) {
												?>
													minAvailable.guests[<?php echo $guestType9ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType9ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType9ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType10ID) {
												?>
													minAvailable.guests[<?php echo $guestType10ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType10ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType10ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType11ID) {
												?>
													minAvailable.guests[<?php echo $guestType11ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType11ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType11ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType12ID) {
												?>
													minAvailable.guests[<?php echo $guestType12ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType12ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType12ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType13ID) {
												?>
													minAvailable.guests[<?php echo $guestType13ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType13ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType13ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType14ID) {
												?>
													minAvailable.guests[<?php echo $guestType14ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType14ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType14ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType15ID) {
												?>
													minAvailable.guests[<?php echo $guestType15ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType15ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType15ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType16ID) {
												?>
													minAvailable.guests[<?php echo $guestType16ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType16ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType16ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType17ID) {
												?>
													minAvailable.guests[<?php echo $guestType17ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType17ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType17ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType18ID) {
												?>
													minAvailable.guests[<?php echo $guestType18ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType18ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType18ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType19ID) {
												?>
													minAvailable.guests[<?php echo $guestType19ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType19ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType19ID;?>').value);

												<?php
											} elseif (isset($guestTypes[0]) && $guest == $guestType20ID) {
												?>
													minAvailable.guests[<?php echo $guestType20ID;?>] = document.getElementById('guests_a<?php echo $myActivityID; ?>_t<?php echo $guestType20ID;?>').value;
													totalGuestCount += Number(document.getElementById('guests_a<?php echo $myActivityID;?>_t<?php echo $guestType20ID;?>').value);

												<?php
											} 
										}
									?>

								  if (0 == totalGuestCount) {
								    alert('Please select guest count for all guest types');
								    //return null;
								  }
								  else {
								    // Show calendar (only if all guest type counts are correct)
								    calendar(activityControl, dateControl, false, minAvailable, new Date().getDate()<25?1:2);
								  }
								}
							</script>
							<label>Choose Date</label>
							<div class="form-row date-selector">
								<input class="form-control" id='date_a<?php echo $myActivityID; ?>' onclick='showMinAvailable12()'>
									<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showMinAvailable12();">
										<i class="fa fa-calendar" aria-hidden="true"></i>
									</a>
							</div>

						<?php

						//Load Upgrade Types Select Fields
						foreach ($upgradeTypes as $upgrade) { 

							$html = '';

							if (isset($upgradeTypes[0]) && $upgradeTypes[0] != null && $upgrade == $upgradeType1ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType1ID.'" name="'.$upgradeType1Label.'" min="'.$upgradeType1Min.'" max="'.$upgradeType1Max.'"]');

							} elseif (isset($upgradeTypes[1]) != null && $upgrade == $upgradeType2ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType2ID.'" name="'.$upgradeType2Label.'" min="'.$upgradeType2Min.'" max="'.$upgradeType2Max.'"]');

							} elseif (isset($upgradeTypes[2]) != null && $upgrade == $upgradeType3ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType3ID.'" name="'.$upgradeType3Label.'" min="'.$upgradeType3Min.'" max="'.$upgradeType3Max.'"]');

							} elseif (isset($upgradeTypes[3]) != null && $upgrade == $upgradeType4ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType4ID.'" name="'.$upgradeType4Label.'" min="'.$upgradeType4Min.'" max="'.$upgradeType4Max.'"]');

							} elseif (isset($upgradeTypes[4]) != null && $upgrade == $upgradeType5ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType5ID.'" name="'.$upgradeType5Label.'" min="'.$upgradeType5Min.'" max="'.$upgradeType5Max.'"]');

							} elseif (isset($upgradeTypes[5]) != null && $upgrade == $upgradeType6ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType6ID.'" name="'.$upgradeType6Label.'" min="'.$upgradeType6Min.'" max="'.$upgradeType6Max.'"]');

							} elseif (isset($upgradeTypes[6]) != null && $upgrade == $upgradeType7ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType7ID.'" name="'.$upgradeType7Label.'" min="'.$upgradeType7Min.'" max="'.$upgradeType7Max.'"]');

							} elseif (isset($upgradeTypes[7]) != null && $upgrade == $upgradeType8ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType8ID.'" name="'.$upgradeType8Label.'" min="'.$upgradeType8Min.'" max="'.$upgradeType8Max.'"]');

							} elseif (isset($upgradeTypes[8]) != null && $upgrade == $upgradeType9ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType9ID.'" name="'.$upgradeType9Label.'" min="'.$upgradeType9Min.'" max="'.$upgradeType9Max.'"]');

							} elseif (isset($upgradeTypes[9]) != null && $upgrade == $upgradeType10ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType10ID.'" name="'.$upgradeType10Label.'" min="'.$upgradeType10Min.'" max="'.$upgradeType10Max.'"]');

							} elseif (isset($upgradeTypes[10]) != null && $upgrade == $upgradeType11ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType11ID.'" name="'.$upgradeType11Label.'" min="'.$upgradeType11Min.'" max="'.$upgradeType11Max.'"]');

							} elseif (isset($upgradeTypes[11]) != null && $upgrade == $upgradeType12ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType12ID.'" name="'.$upgradeType12Label.'" min="'.$upgradeType12Min.'" max="'.$upgradeType12Max.'"]');

							} elseif (isset($upgradeTypes[12]) != null && $upgrade == $upgradeType13ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType13ID.'" name="'.$upgradeType13Label.'" min="'.$upgradeType13Min.'" max="'.$upgradeType13Max.'"]');

							} elseif (isset($upgradeTypes[13]) != null && $upgrade == $upgradeType14ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType14ID.'" name="'.$upgradeType14Label.'" min="'.$upgradeType14Min.'" max="'.$upgradeType14Max.'"]');

							} elseif (isset($upgradeTypes[14]) != null && $upgrade == $upgradeType15ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType15ID.'" name="'.$upgradeType15Label.'" min="'.$upgradeType15Min.'" max="'.$upgradeType15Max.'"]');

							} elseif (isset($upgradeTypes[15]) != null && $upgrade == $upgradeType16ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType16ID.'" name="'.$upgradeType16Label.'" min="'.$upgradeType16Min.'" max="'.$upgradeType16Max.'"]');

							} elseif (isset($upgradeTypes[16]) != null && $upgrade == $upgradeType17ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType17ID.'" name="'.$upgradeType17Label.'" min="'.$upgradeType17Min.'" max="'.$upgradeType17Max.'"]');

							} elseif (isset($upgradeTypes[17]) != null && $upgrade == $upgradeType18ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType18ID.'" name="'.$upgradeType18Label.'" min="'.$upgradeType18Min.'" max="'.$upgradeType18Max.'"]');

							} elseif (isset($upgradeTypes[18]) != null && $upgrade == $upgradeType19ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType19ID.'" name="'.$upgradeType19Label.'" min="'.$upgradeType19Min.'" max="'.$upgradeType19Max.'"]');

							} elseif (isset($upgradeTypes[19]) != null && $upgrade == $upgradeType20ID) {

								$html .= do_shortcode('[loadPonorezUpgradeField id="'.$upgradeType20ID.'" name="'.$upgradeType20Label.'" min="'.$upgradeType20Min.'" max="'.$upgradeType20Max.'"]');

							} 

							print $html;

						}

						// Attach active upgrade types to booking function
						foreach ($upgradeTypes as $upgrade) { 

							if (isset($upgradeTypes[0]) && $upgradeTypes[0] != null && $upgrade == $upgradeTypes[0]) {

								$printUG1 = 'addUpgrades(' . $upgradeTypes[0] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[0] .'\').value); ';

							} elseif (isset($upgradeTypes[1]) && $upgrade == $upgradeTypes[1]) {

								$printUG2 = 'addUpgrades(' . $upgradeTypes[1] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[1] .'\').value); ';

							} elseif (isset($upgradeTypes[2]) && $upgrade == $upgradeTypes[2]) {

								$printUG3 = 'addUpgrades(' . $upgradeTypes[2] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[2] .'\').value); ';

							} elseif (isset($upgradeTypes[3]) && $upgrade == $upgradeTypes[3]) {

								$printUG4 = 'addUpgrades(' . $upgradeTypes[3] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[3] .'\').value); ';

							} elseif (isset($upgradeTypes[4]) && $upgrade == $upgradeTypes[4]) {

								$printUG5 = 'addUpgrades(' . $upgradeTypes[4] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[4] .'\').value); ';

							} elseif (isset($upgradeTypes[5]) && $upgrade == $upgradeTypes[5]) {

								$printUG6 = 'addUpgrades(' . $upgradeTypes[5] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[5] .'\').value); ';	

							} elseif (isset($upgradeTypes[6]) && $upgrade == $upgradeTypes[6]) {

								$printUG7 = 'addUpgrades(' . $upgradeTypes[6] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[6] .'\').value); ';	

							} elseif (isset($upgradeTypes[7]) && $upgrade == $upgradeTypes[7]) {

								$printUG8 = 'addUpgrades(' . $upgradeTypes[7] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[7] .'\').value); ';	

							} elseif (isset($upgradeTypes[8]) && $upgrade == $upgradeTypes[8]) {

								$printUG9 = 'addUpgrades(' . $upgradeTypes[8] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[8] .'\').value); ';	

							} elseif (isset($upgradeTypes[9]) && $upgrade == $upgradeTypes[9]) {

								$printUG10 = 'addUpgrades(' . $upgradeTypes[9] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[9] .'\').value); ';	

							} elseif (isset($upgradeTypes[10]) && $upgrade == $upgradeTypes[10]) {

								$printUG11 = 'addUpgrades(' . $upgradeTypes[10] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[10] .'\').value); ';	

							} elseif (isset($upgradeTypes[11]) && $upgrade == $upgradeTypes[11]) {

								$printUG12 = 'addUpgrades(' . $upgradeTypes[11] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[11] .'\').value); ';	

							} elseif (isset($upgradeTypes[12]) && $upgrade == $upgradeTypes[12]) {

								$printUG13 = 'addUpgrades(' . $upgradeTypes[12] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[12] .'\').value); ';	

							} elseif (isset($upgradeTypes[13]) && $upgrade == $upgradeTypes[13]) {

								$printUG14 = 'addUpgrades(' . $upgradeTypes[13] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[13] .'\').value); ';	

							} elseif (isset($upgradeTypes[14]) && $upgrade == $upgradeTypes[14]) {

								$printUG15 = 'addUpgrades(' . $upgradeTypes[14] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[14] .'\').value); ';	

							} elseif (isset($upgradeTypes[15]) && $upgrade == $upgradeTypes[15]) {

								$printUG16 = 'addUpgrades(' . $upgradeTypes[15] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[15] .'\').value); ';	

							} elseif (isset($upgradeTypes[16]) && $upgrade == $upgradeTypes[16]) {

								$printUG17 = 'addUpgrades(' . $upgradeTypes[16] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[16] .'\').value); ';	

							} elseif (isset($upgradeTypes[17]) && $upgrade == $upgradeTypes[17]) {

								$printUG18 = 'addUpgrades(' . $upgradeTypes[17] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[17] .'\').value); ';	

							} elseif (isset($upgradeTypes[18]) && $upgrade == $upgradeTypes[18]) {

								$printUG19 = 'addUpgrades(' . $upgradeTypes[18] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[18] .'\').value); ';	

							} elseif (isset($upgradeTypes[19]) && $upgrade == $upgradeTypes[19]) {

								$printUG20 = 'addUpgrades(' . $upgradeTypes[19] . ', document.getElementById(\'upgrades_a' . $myActivityID . '_u' . $upgradeTypes[19] .'\').value); ';	

							} else {

							}
						}

						//Load Accommodation and Transportation Fields

						$accommodationStatusCheck = get_option('accommodationStatus');
						$couponsStatusCheck = get_option('couponsStatus');
						$promoCodeFieldJS = 'setpromotionalcode(document.getElementById(\'promotionalcode_' . $myActivityID . '\').value);';

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
							<input type="button" class="button button-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} ?> setHotel(jQuery('#hotel_a<?php echo $myActivityID; ?>').val()); setRoom(jQuery('#room_a<?php echo $myActivityID; ?>').val()); setTransportationRoute(jQuery('[name=\'transportationroute_a<?php echo $myActivityID; ?>\']:visible:checked').val()); setAccommodationFixed(); <?php if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

						<?php	

							} elseif(!empty( $accommodationStatusCheck ) && $accommodationType == 'popup') {

						?>

							<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
							<input type="button" class="button button-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} ?> setAccommodationFixed(); <?php if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

						<?php

							} elseif(!empty( $accommodationStatusCheck ) && $accommodationType == 'checkout') {

						?>

							<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
							<input type="button" class="button button-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

						<?php

							} else {
						?>

							<input type="button" class="button button-close" value="Cancel" onClick="jQuery.ponorezmodal.close();">
							<input type="button" class="button button-book-now" value="<?php echo $bookNowText; ?>" onclick="reservation2('<?php echo $myActivityID; ?>', <?php echo $myActivityID; ?>, document.getElementById('date_a<?php echo $myActivityID; ?>').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0); <?php if (isset($printGT1)) { echo $printGT1; } if (isset($printGT2)) { echo $printGT2; } if (isset($printGT3)) {	echo $printGT3; } if (isset($printGT4)) { echo $printGT4; } if (isset($printGT5)) {	echo $printGT5; } if (isset($printGT6)) { echo $printGT6; } if (isset($printGT7)) { echo $printGT7; } if (isset($printGT8)) { echo $printGT8; } if (isset($printGT9)) {	echo $printGT9; } if (isset($printGT10)) { echo $printGT10; } if (isset($printGT11)) { echo $printGT11; } if (isset($printGT12)) { echo $printGT12; } if (isset($printGT13)) { echo $printGT13; } if (isset($printGT14)) { echo $printGT14; } if (isset($printGT15)) { echo $printGT15; } if (isset($printGT16)) { echo $printGT16; } if (isset($printGT17)) { echo $printGT17; } if (isset($printGT18)) { echo $printGT18; } if (isset($printGT19)) { echo $printGT19; } if (isset($printGT20)) { echo $printGT20; } ?> <?php if (isset($printPG1)) { echo $printPG1; } if (isset($printPG2)) { echo $printPG2; } if (isset($printPG3)) {	echo $printPG3; } if (isset($printPG4)) { echo $printPG4; } if (isset($printPG5)) {	echo $printPG5; } if (isset($printPG6)) { echo $printPG6; } if (isset($printPG7)) { echo $printPG7; } if (isset($printPG8)) { echo $printPG8; } if (isset($printPG9)) {	echo $printGT9; } if (isset($printPG10)) { echo $printPG10; } if (isset($printPG11)) { echo $printPG11; } if (isset($printPG12)) { echo $printPG12; } if (isset($printPG13)) { echo $printPG13; } if (isset($printPG14)) { echo $printPG14; } if (isset($printPG15)) { echo $printPG15; } if (isset($printPG16)) { echo $printPG16; } if (isset($printPG17)) { echo $printPG17; } if (isset($printPG18)) { echo $printPG18; } if (isset($printPG19)) { echo $printPG19; } if (isset($printPG20)) { echo $printPG20; } ?> <?php if (isset($printUG1)) { echo $printUG1; } if (isset($printUG2)) { echo $printUG2; } if (isset($printUG3)) {	echo $printUG3; } if (isset($printUG4)) { echo $printUG4; } if (isset($printUG5)) {	echo $printUG5; } if (isset($printUG6)) { echo $printUG6; } if (isset($printUG7)) { echo $printUG7; } if (isset($printUG8)) { echo $printUG8; } if (isset($printUG9)) {	echo $printUG9; } if (isset($printUG10)) { echo $printUG10; } if (isset($printUG11)) { echo $printUG11; } if (isset($printUG12)) { echo $printUG12; } if (isset($printUG13)) { echo $printUG13; } if (isset($printUG14)) { echo $printUG14; } if (isset($printUG15)) { echo $printUG15; } if (isset($printUG16)) { echo $printUG16; } if (isset($printUG17)) { echo $printUG17; } if (isset($printUG18)) { echo $printUG18; } if (isset($printUG19)) { echo $printUG19; } if (isset($printUG20)) { echo $printUG20; } if($upgradeTypes[0] != null){echo "setUpgradesFixed();";} ?> setAccommodationFixed(); <?php if(!empty( $couponsStatusCheck ) && $promotionalCodesStatus == 'yes') { echo $promoCodeFieldJS; } ?> <?php if (!empty($googleAnalyticsID)) { echo $setGoogleAnalyticsID; } ?> availability_popup(); return false;" />

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
