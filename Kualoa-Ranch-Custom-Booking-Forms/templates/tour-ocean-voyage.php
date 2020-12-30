<!-- The Modal -->
<div id="modal-ocean-voyage" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">

				// Activity group settings
				var group1013 = {

					supplierid: 225,
					activityids: [ 7558, 7741, 7580, 7750, 7749, 7583, 9660, 9792 ],
					guesttypeids: [ 274, 1554, 1190 ],
					
					activityprices: {
						
						7558: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						7741: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						7580: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						7750: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						7749: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						7583: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						9660: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						9792: { 274: 51.26, 1554: 38.69, 1190: 0.00 }

					},

					datecontrolid: 'date_g1013',
					pricecontrolid: 'price_g1013',

					activitycheckboxcontrolids: {
						
						7558: "activity_7558",
						7741: "activity_7741",
						7580: "activity_7580",
						7750: "activity_7750",
						7749: "activity_7749",
						7583: "activity_7583",
						9660: "activity_9660",
						9792: "activity_9792"
						
					},
					
					activitydescriptioncontrolids: {

						7558: "activity_7558_description",
						7741: "activity_7741_description",
						7580: "activity_7580_description",
						7750: "activity_7750_description",
						7749: "activity_7749_description",
						7583: "activity_7583_description",
						9660: "activity_9660_description",
						9792: "activity_9792_description"

					},
					
					activitynotavailablemessagecontrolids: {
						
						7558: "activity_7558_notavailablemessage",
						7741: "activity_7741_notavailablemessage",
						7580: "activity_7580_notavailablemessage",
						7750: "activity_7750_notavailablemessage",
						7749: "activity_7749_notavailablemessage",
						7583: "activity_7583_notavailablemessage",
						9660: "activity_9660_notavailablemessage",
						9792: "activity_9792_notavailablemessage"
						
					},

					guesttypecontrolids: {
						
						274: "guests_g1013_t274",
						1554: "guests_g1013_t1554",
						1190: "guests_g1013_t1190"
					
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

						// Show calendar (only if all guest type counts are correct)
						calendar(group.activityids, group.datecontrolid, false, minavailability);

					}

				}

				function formatMoney(n) {

					var c = 2, d = ".", t = ",", s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
					return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");

				}

				function showPriceAndAvailability(group) {
					 console.log('ocean');
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
						var freeAdultId = 3702;
						// var freeAdultPrice = 0;
						var freeAdultCount = 0;

						var freeChildId = 3703;
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

				function bookOceanVoyage(group) {

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

					setpromotionalcode(document.getElementById('promotionalcode_g1013').value); 

					setgoogleanalytics('UA-12595817-1');
					
					//availability_popup();
					availability_iframe_popup();

					return true;

				}

			</script>

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">
						
						<h3>Fishpond & Ocean Voyage Tour</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adult</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1013_t274" onchange="showPriceAndAvailability(group1013);">

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

							<label>Child (3-12 years old)</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1013_t1554" onchange="showPriceAndAvailability(group1013);">

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

							<label>Infant (2 years old & under)</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1013_t1190" onchange="showPriceAndAvailability(group1013);">

									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>

								</select>

							</div>

						</div>

						<div class="form-row">

							<label>Select a Date:</label>

							<div class="input-wrapper date-selector">
								<input id="date_g1013" class="form-control browser-default" onclick="showCalendar(group1013);" onchange="showPriceAndAvailability(group1013);" readOnly />
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1013);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="ocean-voyage-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1013);" onclick="showPriceAndAvailability(group1013);">

									<option value="0" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);">Select time</option>

									<option id="activity_7558" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 8:45 AM </option>
									<option id="activity_7741" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 9:15 AM </option>
									<option id="activity_7580" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 10:30 AM </option>
									<option id="activity_7750" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 11:00 AM </option>
									<option id="activity_7749" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 12:45 PM </option>
									<option id="activity_7583" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 1:00 PM </option>
									<option id="activity_9660" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 1:15 PM </option>
									<option id="activity_9792" onclick="selectActivity(group1013, this); showPriceAndAvailability(group1013);"> 2:30 PM </option>
									
								</select>
								
								<script>
									
									$("#ocean-voyage-times").bind("click", function() {
									
										if ( $('body select#ocean-voyage-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#ocean-voyage-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
																						
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>
						
						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1013" size="8">

							</div>

						</div>

						<div class="form-row total-price">
							<label>Total Price with taxes: <span id="price_g1013"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="bookOceanVoyage(group1013);">Book Now</a>
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