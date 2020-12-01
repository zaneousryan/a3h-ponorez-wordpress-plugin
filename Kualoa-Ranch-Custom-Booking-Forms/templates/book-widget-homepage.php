<div class="back_row">

	<h3 class="form_head"><?php the_field('book_your_experience', $current_id);?></h3>

	<form class="row" id="pre-booking">

		<div class="col-md-10">

			<div class="form-group event">

				<select class="form-control events_cls" id="activitySelect">

					<option value="">Choose Your Adventure</option>
					
					<!-- <option value="modal-kayak-adventure">Kayak Adventure Tour</option> -->
					<!-- <option value="modal-taste-of-kualoa">Taste of Kualoa Farm Tour</option> -->
					<!-- <option value="modal-total-experience">"Best of Kualoa" Experience</option> -->
					<!-- <option value="modal-1hour-horseback-tour">1-Hour Horseback Tour</option> -->
					<option value="modal-2hour-horseback-tour">2-Hour Horseback Tour</option>
					<!-- <option value="modal-horseback-adventure">Horseback Adventure</option> -->
					<option value="modal-1hour-raptor">1-Hour ATV Raptor Tour</option>
					<option value="modal-2hour-raptor">2-Hour ATV Raptor Tour</option>
					<!-- <option value="modal-25hour-raptor">Exclusive ATV Raptor Tour with Lunch</option> -->
<!-- 					<option value="modal-raptor-adventure">ATV Raptor Adventure Package</option>
 -->					<option value="modal-movie-sites">Hollywood Movie Site Tour</option>
					<!-- <option value="modal-premier-movie-sites">Premier Hollywood Movie Site Tour</option> -->
					<option value="modal-jungle-expedition">Jurassic Jungle Expedition Tour</option>
					<option value="modal-secret-island">Secret Island Beach Activities</option>
					<!-- <option value="modal-ocean-voyage">Fishpond & Ocean Voyage Tour</option> -->
					<!-- <option value="modal-1hour-ebike">1-Hour E-Bike Tour</option> -->
					<option value="modal-2hour-ebike">2-Hour E-Bike Tour</option>
					<option value="modal-zipline">Jurassic Valley Zipline</option>

				</select>

			</div>

			<small class="white_smalls"><?php the_field('book_your_experience_small_text', $current_id);?></small>

		</div>

		<!--<div class="col-md-5">

			<div class="form-group date">

				<input class="form-control events_cls" type="text" id="datepicker" readonly="readonly" placeholder="Choose Date">

			</div>

		</div>-->
		

		<div class="col-md-2">

			<a id="form-submit" class="btn-primary btns_cls" href="" rel="modal:open">Reserve Now</a>

		</div>

	</form>
						
</div>

<style>
	
	@media (max-width: 800px) {
		
		.after_banner_section .form-group.date { margin-bottom: 35px; }
		
	}
	
	.btns_cls { margin-top: 0px; border-radius: 25px; background: #fff; color: #7580fa; padding: 10px 14px; font-size: 16px; font-family: 'Brandon Grotesque-Regular'; width: 100%; font-weight: bold; border-color: #fff; }
	.btns_cls:hover { background: transparent; color: #fff; border: 1px solid #fff; }
	
</style>

<script>

	$('#form-submit').click( function() {
		
		var $activityValue = $('#activitySelect').val();
		var $dateValue = $('#datepicker').val();
		
		if( $activityValue == '') {
			
			alert('Please select an activity.');
			
			return false;
			
		}
		
		if( $('#activitySelect').val() != '' && $('#datepicker').val() == '' ) {
			
			alert('Please select a date.');
			
			return false;
			
		}
		
	});
	
	$('#activitySelect').change( function() {
		
		var $selectedActivity = $( "#activitySelect" ).val();
		var $urlFormat = '#';
		var $modalTrigger = $urlFormat+$selectedActivity;

		$("#form-submit").prop("href", $modalTrigger);
		
		if ( $selectedActivity == 'modal-1hour-ebike') {
			
			var $groupID = "group1023";
			
			$("#form-submit").click( function() {
				
				$("input#date_g1023").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1001_t274").val( $( "#guestTypeSelector" ).val() );
				
			});
							
		} else if ( $selectedActivity == 'modal-2hour-ebike') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1001").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1002_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-1hour-horseback-tour') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1002").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1002_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-2hour-horseback-tour') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1003").val( $( "#datepicker" ).val() );

				//$("select#guests_g1003_t274").val( $( "#guestTypeSelector" ).val() );
				
			});

		} else if ( $selectedActivity == 'modal-movie-sites') {
		
			$("#form-submit").click( function() {
			
				$("input#date_g1004").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1004_t274").val( $( "#guestTypeSelector" ).val() );
					
			});

		} else if ( $selectedActivity == 'modal-jungle-expedition') {
		
			$("#form-submit").click( function() {

				$("input#date_g1005").val( $( "#datepicker" ).val() );

				//$("select#guests_g1005_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-horseback-adventure') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1006").val( $( "#datepicker" ).val() );

				//$("select#guests_g1006_t274").val( $( "#guestTypeSelector" ).val() );
				
			});

		} else if ( $selectedActivity == 'modal-total-experience') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1007").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1007_t274").val( $( "#guestTypeSelector" ).val() );
							
			});

		} else if ( $selectedActivity == 'modal-taste-of-kualoa') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1009").val( $( "#datepicker" ).val() );

				//$("select#guests_g1009_t274").val( $( "#guestTypeSelector" ).val() );
				
			});

		} else if ( $selectedActivity == 'modal-zipline') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1012").val( $( "#datepicker" ).val() );

				//$("select#guests_g1012_t274").val( $( "#guestTypeSelector" ).val() );
									
			});

		} else if ( $selectedActivity == 'modal-ocean-voyage') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1013").val( $( "#datepicker" ).val() );

				//$("select#guests_g1013_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-secret-island') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1014").val( $( "#datepicker" ).val() );

				//$("select#guests_g1014_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-premier-movie-sites') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1015").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1015_t274").val( $( "#guestTypeSelector" ).val() );
					
			});

		} else if ( $selectedActivity == 'modal-25hour-raptor') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1021").val( $( "#datepicker" ).val() );

				//$("select#guests_g1016_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-2hour-raptor') {
		
			$("#form-submit").click( function() {
				
				$("input#date_g1016").val( $( "#datepicker" ).val() );

				//$("select#guests_g1016_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-1hour-raptor') {
		
			$("#form-submit").click( function() {

				$("input#date_g1017").val( $( "#datepicker" ).val() );

				//$("select#guests_g1017_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-raptor-adventure') {
		
			$("#form-submit").click( function() {
						
				$("input#date_g1022").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1018_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		} else if ( $selectedActivity == 'modal-kayak-adventure') {
		
			$("#form-submit").click( function() {
						
				$("input#date_g1019").val( $( "#datepicker" ).val() );
				
				//$("select#guests_g1018_t274").val( $( "#guestTypeSelector" ).val() );
			
			});

		}

	});
	
</script>