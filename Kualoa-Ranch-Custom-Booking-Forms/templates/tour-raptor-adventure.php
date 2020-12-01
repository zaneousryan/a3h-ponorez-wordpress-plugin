<!-- The Modal -->
<div id="modal-raptor-adventure" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">

				// Activity group settings
				var group1022 = {

					supplierid: 225,
					activityids: [ 12441, 12429, 12442, 12458, 12443, 12459, 12445, 12460, 12449, 12461, 12453, 12454 ],
					guesttypeids: [ 274, 1554 ],
					
					activityprices: { 
						
						12441: { 274: 177.96, 1554: 119.32 },
						12429: { 274: 177.96, 1554: 119.32 },
						12442: { 274: 177.96, 1554: 119.32 },
						12458: { 274: 177.96, 1554: 119.32 },
						12443: { 274: 177.96, 1554: 119.32 },
						12459: { 274: 177.96, 1554: 119.32 },
						12445: { 274: 177.96, 1554: 119.32 },
						12460: { 274: 177.96, 1554: 119.32 },
						12449: { 274: 177.96, 1554: 119.32 },
						12461: { 274: 177.96, 1554: 119.32 },
						12453: { 274: 177.96, 1554: 119.32 },
						12454: { 274: 177.96, 1554: 119.32 }
					},
					
					datecontrolid: "date_g1022",
					pricecontrolid: "price_g1022",
					
					activitycheckboxcontrolids: {
						
						12441: "activity_12441",
						12429: "activity_12429",
						12442: "activity_12442",
						12458: "activity_12458",
						12443: "activity_12443",
						12459: "activity_12459",
						12445: "activity_12445",
						12460: "activity_12460",
						12449: "activity_12449",
						12461: "activity_12461",
						12453: "activity_12453",
						12454: "activity_12454"
						
					},
					
					activitydescriptioncontrolids: {
						
						12441: "activity_12441_description",
						12429: "activity_12429_description",
						12442: "activity_12442_description",
						12458: "activity_12458_description",
						12443: "activity_12443_description",
						12459: "activity_12459_description",
						12445: "activity_12445_description",
						12460: "activity_12460_description",
						12449: "activity_12449_description",
						12461: "activity_12461_description",
						12453: "activity_12453_description",
						12454: "activity_12454_description"
						
					},
					
					activitynotavailablemessagecontrolids: {
						
						12441: "activity_12441_notavailablemessage",
						12429: "activity_12429_notavailablemessage",
						12442: "activity_12442_notavailablemessage",
						12458: "activity_12458_notavailablemessage",
						12443: "activity_12443_notavailablemessage",
						12459: "activity_12459_notavailablemessage",
						12445: "activity_12445_notavailablemessage",
						12460: "activity_12460_notavailablemessage",
						12449: "activity_12449_notavailablemessage",
						12461: "activity_12461_notavailablemessage",
						12453: "activity_12453_notavailablemessage",
						12454: "activity_12454_notavailablemessage"
					},
					
					guesttypecontrolids: {
						
						274: "guests_g1022_t274",
						1554: "guests_g1022_t1554"
					
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
					 console.log('rp ad');
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

				function bookRaptorPackage(group) {

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
					
					setpromotionalcode(document.getElementById('promotionalcode_g1022').value); 
					
					var adultGuests = document.getElementById('guests_g1022_t274').value,
						childGuests = document.getElementById('guests_g1022_t1554').value,
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
						
						<h3>ATV Raptor Adventure Package</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adults</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1022_t274" onchange="showPriceAndAvailability(group1022);">

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

								<select class="form-control browser-default" id="guests_g1022_t1554" onchange="showPriceAndAvailability(group1022);">

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
								<input id="date_g1022" class="form-control browser-default" onclick="showCalendar(group1022);" onchange="showPriceAndAvailability(group1022);" readOnly />
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1022);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="raptor-package-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1022);" onclick="showPriceAndAvailability(group1022);">

									<option value="0" onclick="selectActivity(group1022, this);">Select time</option>

									<option id="activity_12441" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12429" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12442" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12458" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12443" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12459" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12445" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12460" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12449" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12461" onclick="selectActivity(group1022, this);"> 8:45 AM </option>
									<option id="activity_12453" onclick="selectActivity(group1022, this);"> 12:30 PM </option>
									<option id="activity_12454" onclick="selectActivity(group1022, this);"> 12:30 PM </option>
									
								</select>
								
								<script>
									
									$("#raptor-package-times").bind("click", function() {
									
										if ( $('body select#raptor-package-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#raptor-package-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
																						
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>

						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1022" size="8">

							</div>

						</div>
						
						<div class="form-row total-price">
							<label>Total Price with taxes: <span id="price_g1022"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="bookRaptorPackage(group1022);">Book Now</a>
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