<!-- The Modal -->
<div id="modal-1hour-horseback-tour" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">
				// alert('hi');
				// Activity group settings
				var group1002 = {

				supplierid: 225,
				activityids: [ 7648,7649,7650,7651,7652,7653,7654,7655,7657,7659 ],
				guesttypeids: [ 274,1554 ],

				activityprices: {

					7648: { 274: 94.19, 1554: 62.77 },
					7649: { 274: 94.19, 1554: 62.77 },
					7650: { 274: 94.19, 1554: 62.77 },
					7651: { 274: 94.19, 1554: 62.77 },
					7652: { 274: 94.19, 1554: 62.77 },
					7653: { 274: 94.19, 1554: 62.77 },
					7654: { 274: 94.19, 1554: 62.77 },
					7655: { 274: 94.19, 1554: 62.77 },
					7657: { 274: 94.19, 1554: 62.77 },
					7659: { 274: 94.19, 1554: 94.19 }
				},

				datecontrolid: "date_g1002",
				pricecontrolid: "price_g1002",

				activitycheckboxcontrolids: {

					7648: "activity_7648",
					7649: "activity_7649",
					7650: "activity_7650",
					7651: "activity_7651",
					7652: "activity_7652",
					7653: "activity_7653",
					7654: "activity_7654",
					7655: "activity_7655",
					7657: "activity_7657",
					7659: "activity_7659"

				},

				activitydescriptioncontrolids: {

					7648: "activity_7648_description",
					7649: "activity_7649_description",
					7650: "activity_7650_description",
					7651: "activity_7651_description",
					7652: "activity_7652_description",
					7653: "activity_7653_description",
					7654: "activity_7654_description",
					7655: "activity_7655_description",
					7657: "activity_7657_description",
					7659: "activity_7659_description"

				},

				activitynotavailablemessagecontrolids: {

					7648: "activity_7648_notavailablemessage",
					7649: "activity_7649_notavailablemessage",
					7650: "activity_7650_notavailablemessage",
					7651: "activity_7651_notavailablemessage",
					7652: "activity_7652_notavailablemessage",
					7653: "activity_7653_notavailablemessage",
					7654: "activity_7654_notavailablemessage",
					7655: "activity_7655_notavailablemessage",
					7657: "activity_7657_notavailablemessage",
					7659: "activity_7659_notavailablemessage"

				},

				guesttypecontrolids:{

					274: "guests_g1002_t274",
					1554: "guests_g1002_t1554"

				},

					cancellationpolicycontrolid: 'cancellationpolicy'

				};

				function showCalendar(group) {

					var minavailability = { guests: {} };
					var failure = false;

					$.each(group.guesttypeids, function(key, value) {

						if (failure) return;

						var guesttypeid = value;
						var guestscount = getGuestsCount(group, guesttypeid, true);

						if (guestscount == null) {

							failure = true;

						} else {

							minavailability.guests[guesttypeid] = guestscount;

						}

					});

					if (!failure) {

						calendar(group.activityids, group.datecontrolid, false, minavailability);

					}

				}

				function formatMoney(n) {

					var c = 2, d = ".", t = ",", s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
					return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");

				}

				function showPriceAndAvailability(group) {
					 console.log('1horse');
					var activityid = getSelectedActivityId(group, false);
					var activitydate = getActivityDate(group, false);
					var minavailability = { guests: {} };
					var price = 0.0;
					var failure = false;
					////////////////////////////////////////////////
					console.log(group);
					var res = group.pricecontrolid.split("_");
					var promoCode = jQuery('#promotionalcode_'+res[1]).val();
					if(promoCode == '1'){

						var adult = jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val();
						var child = jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val();
						var adultPrice = group.activityprices[activityid][group.guesttypeids[0]];
						var childPrice = group.activityprices[activityid][group.guesttypeids[1]];
						var freeAdultId = 3672;
						// var freeAdultPrice = 0;
						var freeAdultCount = 0;

						var freeChildId = 3674;
						// var freeChildPrice = 0;
						var freeChildCount = 0;

					    if(child == 0){
					    	if(adult%2 == 0){
					    		// price = price/2;
					    		jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(adult/2);
					    		// alert('hi');
					    		freeAdultCount = adult/2;
					    	}
					    	else{
								// price = (price/2) + (adultPrice/2);
								jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(Math.ceil(adult/2));
								freeAdultCount = (adult-1)/2;
					    	}
					    } else {
					        if(adult == child){
					        	// price = price - (child * childPrice);
					        	jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(0);
					        	freeChildCount = child;
					        } 
					        else if(adult > child){
					        	var diff = adult - child;
					        	price = price - (child * childPrice);
					        	if(diff%2==0){
					        		price = price - ((diff/2) * adultPrice);
					        	}
					        	else{
					        		price = price - (((diff-1)/2) * adultPrice);
					        	}
					        } 
					        else if(adult < child){
					        	var diff = child - adult;
					        	price = price - (adult * childPrice);
					        	if(diff%2==0){
					        		price = price - ((diff/2) * childPrice);
					        	}
					        	else{
					        		price = price - (((diff-1)/2) * childPrice);
					        	}
					        } 
					    }
					}
					else if (promoCode == '2'){
						var adult = jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val();
						var child = jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val();
						var adultPrice = group.activityprices[activityid][group.guesttypeids[0]];
						var childPrice = group.activityprices[activityid][group.guesttypeids[1]];

					    if(child == 0){
					    	if(adult%2 == 0){
					    		price = price - (((adult/2)*adultPrice)/2);
					    		// price = price/2;
					    	}
					    	else{
								price = price - ((((adult-1)/2)*adultPrice)/2);
					    	}
				          	 
					    } else {
					        if(adult == child){
					        	price = price - ((child * childPrice)/2);
					        } 
					        else if(adult > child){
					        	var diff = adult - child;
					        	price = price - ((child * childPrice)/2);
					        	if(diff%2==0){
					        		price = price - (((diff/2) * adultPrice)/2);
					        	}
					        	else{
					        		price = price - ((((diff-1)/2) * adultPrice)/2);
					        	}
					        } 
					        else if(adult < child){
					        	var diff = child - adult;
					        	price = price - ((adult * childPrice)/2);
					        	if(diff%2==0){
					        		price = price - (((diff/2) * childPrice)/2);
					        	}
					        	else{
					        		price = price - ((((diff-1)/2) * childPrice)/2);
					        	}
					        } 
					    }
					}

					///////////
					// freeChildCount;
					// jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).change();
					sessionStorage.setItem("freeAdultCount", freeAdultCount);
					// freeAdultCount;
					////////////////////////////////////////////////
					$.each(group.guesttypeids, function(key, value) {

						if (failure) return;
						var guesttypeid = value;
						var guestscount = getGuestsCount(group, guesttypeid, false);

						if (guestscount == null) {

							failure = true;

						} else {

							if (activityid != null) {

								var guesttypeprice = group.activityprices[activityid][guesttypeid];
								price += guestscount * guesttypeprice;

							}

							minavailability.guests[guesttypeid] = guestscount;
						}

					});

				  // Show total price (only if activity is selected and all guest type counts are correct)
				  if (activityid != null && !failure) {

					  $('#' + group.pricecontrolid).html('$' + formatMoney(price));

				  } else {

					  $('#' + group.pricecontrolid).html('');

				  }

				  if (activitydate != null && !failure) {

					checkAvailability(function(data) {

						$.each(group.activityids, function(key, value) {

						// Enable or disable activities based on availability (only if activity date is selected and all guest types are correct)
						var activityid = value;
						if (!data[activityid]) $('#' + group.activitycheckboxcontrolids[activityid]).attr('checked', false);
						$('#' + group.activitycheckboxcontrolids[activityid]).prop('disabled', !data[activityid]);
						$('#' + group.activitydescriptioncontrolids[activityid]).css('color', data[activityid] ? 'black' : 'gray');
						$('#' + group.activitynotavailablemessagecontrolids[activityid]).toggle(!data[activityid]);

					  });

					}, group.activityids, activitydate, minavailability);

				  }

				}

				function getSelectedActivityId(group, showWarningIfNoActivitySelected) {

					var activityid = null;
					$.each(group.activityids, function(key, value) {

						if ($('#' + group.activitycheckboxcontrolids[value]).is(':checked')) activityid = value;
					});

					if (activityid == null && showWarningIfNoActivitySelected) {

						alert('Please select activity time.');

					}

				  return activityid;

				}

				function getGuestsCount(group, guestTypeId, showWarningIfWrongFormat) {

				  var guestscountstr = $('#' + group.guesttypecontrolids[guestTypeId]).val();
				  if (guestscountstr == '') return 0;

				  if (!/^\d+$/.test(guestscountstr)) {

					  if (showWarningIfWrongFormat) {

						  alert('Please select a guest type and count.');
					  }

					  return null;

				  }

				  return parseInt(guestscountstr);

				}

				function getActivityDate(group, showWarningIfWrongFormat) {

				  var activitydatestr = $('#' + group.datecontrolid).val();

					if (!/^\d\d?\/\d\d?\/\d\d\d\d$/.test(activitydatestr)) {

						if (showWarningIfWrongFormat) {

							alert('Please select activity date.');

						}

						return null;

					}

					return activitydatestr;

				}

				function selectActivity(group, selectedcheckbox) {

					if (!selectedcheckbox.checked) return;

					$.each(group.activityids, function(key, value) {

						if (selectedcheckbox.id == group.activitycheckboxcontrolids[value]) return;
						$('#' + group.activitycheckboxcontrolids[value]).attr('checked', false);

					});

				}

				function book1hrHorseback(group) {

					var activityid = getSelectedActivityId(group, true);
					if (activityid == null) return false;

					var activitydate = getActivityDate(group, true);
					if (activitydate == null) return false;

					reservation(group.supplierid, activityid, activitydate, '', 0.0);

					$.each(group.guesttypeids, function(key, value) {

						var guesttypeid = value;
						var guestscount = $('#' + group.guesttypecontrolids[guesttypeid]).val();
						addGuests(guesttypeid, guestscount);

					});

					setpromotionalcode(document.getElementById('promotionalcode_g1002').value); 

					setgoogleanalytics('UA-12595817-1');
					
					//availability_popup();
					availability_iframe_popup();

					return true;

				}

			</script>

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">
						
						<h3>1-Hour Horseback Tour</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adults</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1002_t274" onchange="showPriceAndAvailability(group1002);">

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
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>

								</select>

							</div>

						</div>

						<div class="form-row">

							<label>Childs (10-12 years old)</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1002_t1554" onchange="showPriceAndAvailability(group1002);">

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

								</select>

							</div>

						</div>

						<div class="form-row">

							<label>Select a Date:</label>

							<div class="input-wrapper date-selector">
								<input id="date_g1002" class="form-control browser-default" onclick="showCalendar(group1002);" onchange="showPriceAndAvailability(group1002);" readOnly />
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1002);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="1hr-horseback-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1002);" onclick="showPriceAndAvailability(group1002);">

									<option value="0" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">Select time</option>

									<option id="activity_7648" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">8:45 AM</option>
									<option id="activity_7649" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">9:15 AM</option>
									<option id="activity_7650" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">10:30 AM</option>
									<option id="activity_7651" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">10:45 AM</option>
									<option id="activity_7652" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">11:45 AM</option>
									<option id="activity_7653" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">12:00 PM</option>
									<option id="activity_7654" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">1:00 PM</option>
									<option id="activity_7655" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">1:15 PM</option>
									<option id="activity_7657" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">2:30 PM</option>
									<option id="activity_7659" onclick="selectActivity(group1002, this); showPriceAndAvailability(group1002);">4:00 PM (Not Available to Children)</option>

								</select>
								
								<script>
									
									$("#1hr-horseback-times").bind("click", function() {
									
										if ( $('body select#1hr-horseback-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#1hr-horseback-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
																						
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>

						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1002" size="8">

							</div>

						</div>
						
						<div class="form-row total-price">
							<label>Total Price with taxes: <span id="price_g1002"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="book1hrHorseback(group1002);">Book Now</a>
						<a href="#" class="btn btn-default btn-cancel" rel="modal:close">Cancel</a>

					</div>

					<style>
						
						.input-wrapper { margin-bottom: 10px; }

						.ui-widget-header { background: none; background-color: #ff5a60 ; border: none; }
						.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { color: #ff5a60; }

					</style>

				</div>

			</div>		

		</form>

	</div>
	
</div>