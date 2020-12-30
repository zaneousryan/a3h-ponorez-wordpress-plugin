<!-- The Modal -->
<div id="modal-1hour-raptor" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">

				// Activity group settings
				var group1017 = {
					
					supplierid: 225,
					activityids: [ 10496, 8452, 9636, 12417, 9634, 12418, 9635, 12419, 10197, 12415, 12416, 12629, 12635 ],
					guesttypeids: [ 274, 1554 ],
					
					activityprices: { 
						
						10496: { 274: 94.19, 1554: 52.30 },
						8452: { 274: 94.19, 1554: 52.30 },
						9636: { 274: 94.19, 1554: 52.30 },
						12417: { 274: 94.19, 1554: 52.30 },
						9634: { 274: 94.19, 1554: 52.30 },
						12418: { 274: 94.19, 1554: 52.30 },
						9635: { 274: 94.19, 1554: 52.30 },
						12419: { 274: 94.19, 1554: 52.30 },
						10197: { 274: 94.19, 1554: 52.30 },
						12415: { 274: 94.19, 1554: 52.30 },
						12416: { 274: 94.19, 1554: 52.30 },
						12629: { 274: 94.19, 1554: 52.30 },
						12635: { 274: 94.19, 1554: 52.30 }
						
					},
					
					datecontrolid: "date_g1017",
					pricecontrolid: "price_g1017",
					
					activitycheckboxcontrolids: {
						
						10496: "activity_10496",
						8452: "activity_8452",
						9636: "activity_9636",
						12417: "activity_12417",
						9634: "activity_9634",
						12418: "activity_12418",
						9635: "activity_9635",
						12419: "activity_12419",
						10197: "activity_10197",
						12415: "activity_12415",
						12416: "activity_12416",
						12629: "activity_12629",
						12635: "activity_12635"
						
					},
					
					activitydescriptioncontrolids: {
						
						10496: "activity_10496_description",
						8452: "activity_8452_description",
						9636: "activity_9636_description",
						12417: "activity_12417_description",
						9634: "activity_9634_description",
						12418: "activity_12418_description",
						9635: "activity_9635_description",
						12419: "activity_12419_description",
						10197: "activity_10197_description",	
						12415: "activity_12415_description",
						12416: "activity_12416_description",	
						12629: "activity_12629_description",
						12635: "activity_12635_description"	
					},
					
					activitynotavailablemessagecontrolids: {
						
						10496: "activity_10496_notavailablemessage",
						8452: "activity_8452_notavailablemessage",
						9636: "activity_9636_notavailablemessage",
						12417: "activity_12417_notavailablemessage",
						9634: "activity_9634_notavailablemessage",
						12418: "activity_12418_notavailablemessage",
						9635: "activity_9635_notavailablemessage",
						12419: "activity_12419_notavailablemessage",
						10197: "activity_10197_notavailablemessage",
						12415: "activity_12415_notavailablemessage",
						12416: "activity_12416_notavailablemessage",
						12629: "activity_12629_notavailablemessage",
						12635: "activity_12635_notavailablemessage"
						
					},
	
					guesttypecontrolids: {
						
						274: "guests_g1017_t274",
						1554: "guests_g1017_t1554"
						
					},
					
					cancellationpolicycontrolid: 'cancellationpolicy',
					
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
					 console.log('reptor1');
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

				function book1hourRaptor(group) {
				
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
					
					setpromotionalcode(document.getElementById('promotionalcode_g1017').value); 
					
					var adultGuests = document.getElementById('guests_g1017_t274').value,
						childGuests = document.getElementById('guests_g1017_t1554').value,
						totalGuests = Number(adultGuests) + Number(childGuests);

					if( totalGuests < 2 ){
						
						alert('At least 2 passengers are required for this activity.');
						return null;

					} else if ( childGuests >= 6 && childGuests <= 10 ){

						if ( adultGuests < 2 ){

							alert('At least 2 adults are required to accompany the child.');
							return null;

						}


					} else if ( childGuests >= 11 && childGuests <= 15 ){

						if ( adultGuests < 3 ){

							alert('At least 3 adults are required to accompany the child.');
							return null;

						}

					};
										
					setgoogleanalytics('UA-12595817-1');
					
					//availability_popup();
					availability_iframe_popup();

					return true;

				}

			</script>

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">
						
						<h3>1-Hour ATV Raptor Tour</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adults</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1017_t274" onchange="showPriceAndAvailability(group1017);">

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

								</select>

							</div>

						</div>
						
						<div class="form-row">

							<label>Children (5-12 years old)</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1017_t1554" onchange="showPriceAndAvailability(group1017);">

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
									
								</select>

							</div>

						</div>

						<div class="form-row">

							<label>Select a Date:</label>

							<div class="input-wrapper date-selector">
				
								<input id="date_g1017" class="form-control browser-default" onclick="showCalendar(group1017);" onchange="showPriceAndAvailability(group1017);" readOnly>
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1017);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
								
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="1hr-raptor-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1017);" onclick="showPriceAndAvailability(group1017);">

									<option value="0" onclick="selectActivity(group1017, this);">Select time</option>

									<option id="activity_10496" onclick="selectActivity(group1017, this);">8:45 AM </option>
									<option id="activity_8452" onclick="selectActivity(group1017, this);">9:15 AM </option>
									<option id="activity_9636" onclick="selectActivity(group1017, this);">10:30 AM </option>
									<option id="activity_12417" onclick="selectActivity(group1017, this);">10:45 AM </option>
									<option id="activity_9634" onclick="selectActivity(group1017, this);">11:45 AM </option>
									<option id="activity_12418" onclick="selectActivity(group1017, this);">12:00 PM </option>
									<option id="activity_9635" onclick="selectActivity(group1017, this);">1:00 PM </option>
									<option id="activity_12419" onclick="selectActivity(group1017, this);">1:15 PM </option>
									<option id="activity_10197" onclick="selectActivity(group1017, this);">2:15 PM </option>
									<option id="activity_12415" onclick="selectActivity(group1017, this);">2:30 PM </option>
									<option id="activity_12416" onclick="selectActivity(group1017, this);">3:00 PM </option>
									<option id="activity_12629" onclick="selectActivity(group1017, this);">3:45 PM </option>
									<option id="activity_12635" onclick="selectActivity(group1017, this);">4:15 PM </option>
									
								</select>
								
								<script>
									
									$("#1hr-raptor-times").bind("click", function() {
									
										if ( $('body select#1hr-raptor-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#1hr-raptor-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
																						
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>

						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1017" size="8">

							</div>

						</div>
						
						<div class="form-row total-price">
							<label>Total Price with taxes: <span id="price_g1017"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="book1hourRaptor(group1017);">Book Now</a>
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