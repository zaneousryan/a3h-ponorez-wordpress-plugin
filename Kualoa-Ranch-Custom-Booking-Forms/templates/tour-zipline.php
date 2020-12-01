<!-- The Modal -->
<div id="modal-zipline" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">
				// alert('abcefg ');
				// Activity group settings
				var group1012 = {
					
					supplierid: 225,
					activityids: [ 12271, 8040, 7612, 7697, 7689, 8449, 8041, 7690, 7691, 7698, 7692, 8450, 7693, 7694, 8254, 12270 ],
					guesttypeids: [ 274, 1554 ],
					
					activityprices: {
						
						12271: { 274: 177.96, 1554: 146.54 },
						8040: { 274: 177.96, 1554: 146.54 },
						7612: { 274: 177.96, 1554: 146.54 },
						7697: { 274: 177.96, 1554: 146.54 },
						7689: { 274: 177.96, 1554: 146.54 },
						8449: { 274: 177.96, 1554: 146.54 },
						8041: { 274: 177.96, 1554: 146.54 },
						7690: { 274: 177.96, 1554: 146.54 },
						7691: { 274: 177.96, 1554: 146.54 },
						7698: { 274: 177.96, 1554: 146.54 },
						7692: { 274: 177.96, 1554: 146.54 },
						8450: { 274: 177.96, 1554: 146.54 },
						7693: { 274: 177.96, 1554: 146.54 },
						7694: { 274: 177.96, 1554: 146.54 }, 
						8254: { 274: 177.96, 1554: 146.54 },
						12270: { 274: 177.96, 1554: 146.54 }
						
					},
					
					datecontrolid: "date_g1012",
					pricecontrolid: "price_g1012",
					
					activitycheckboxcontrolids: {

						12271: "activity_12271",
						8040: "activity_8040",
						7612: "activity_7612",
						7697: "activity_7697",
						7689: "activity_7689",
						8449: "activity_8449",
						8041: "activity_8041",
						7690: "activity_7690",
						7691: "activity_7691",
						7698: "activity_7698",
						7692: "activity_7692",
						8450: "activity_8450",
						7693: "activity_7693",
						7694: "activity_7694",
						8254: "activity_8254",
						12270: "activity_12270"
						
					},
					
					activitydescriptioncontrolids: {
						
						12271: "activity_12271_description",
						8040: "activity_8040_description",
						7612: "activity_7612_description",
						7697: "activity_7697_description",
						7689: "activity_7689_description",
						8449: "activity_8449_description",
						8041: "activity_8041_description",
						7690: "activity_7690_description",
						7691: "activity_7691_description",
						7698: "activity_7698_description",
						7692: "activity_7692_description",
						8450: "activity_8450_description",
						7693: "activity_7693_description",
						7694: "activity_7694_description",
						8254: "activity_8254_description",
						12270: "activity_12270_description"
						
					},
					
					activitynotavailablemessagecontrolids: {
						
						12271: "activity_12271_notavailablemessage",
						8040: "activity_8040_notavailablemessage",
						7612: "activity_7612_notavailablemessage",
						7697: "activity_7697_notavailablemessage",
						7689: "activity_7689_notavailablemessage",
						8449: "activity_8449_notavailablemessage",
						8041: "activity_8041_notavailablemessage",
						7690: "activity_7690_notavailablemessage",
						7691: "activity_7691_notavailablemessage",
						7698: "activity_7698_notavailablemessage",
						7692: "activity_7692_notavailablemessage",
						8450: "activity_8450_notavailablemessage",
						7693: "activity_7693_notavailablemessage",
						7694: "activity_7694_notavailablemessage",
						8254: "activity_8254_notavailablemessage",
						12270: "activity_12270_notavailablemessage"
						
					},
					
					guesttypecontrolids: {
						
						274: "guests_g1012_t274",
						1554: "guests_g1012_t1554"
					
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
					 console.log('zip');
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

				function bookZipline(group) {

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

					setpromotionalcode(document.getElementById('promotionalcode_g1012').value); 

					setgoogleanalytics('UA-12595817-1');
					
					//availability_popup();
					availability_iframe_popup();

					return true;

				}

			</script>

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">
						
						<h3>Jurassic Valley Zipline</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adults</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1012_t274" onchange="showPriceAndAvailability(group1012);">

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

							<label>Child (10-12 years old)</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1012_t1554" onchange="showPriceAndAvailability(group1012);">

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
								<input id="date_g1012" class="form-control browser-default" onclick="showCalendar(group1012);" onchange="showPriceAndAvailability(group1012);" readOnly />
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1012);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="zipline-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1012);" onclick="showPriceAndAvailability(group1012);">

									<option value="0" onclick="selectActivity(group1012, this);">Select time</option>

									<option id="activity_12271" onclick="selectActivity(group1012, this);">8:00 AM - Drive out Only</option>
									<option id="activity_8040" onclick="selectActivity(group1012, this);">8:30 AM - Drive out Only</option>
									<option id="activity_7612" onclick="selectActivity(group1012, this);">9:00 AM</option>
									<option id="activity_7697" onclick="selectActivity(group1012, this);">9:30 AM</option>
									<option id="activity_7689" onclick="selectActivity(group1012, this);">10:00 AM</option>
									<option id="activity_8449" onclick="selectActivity(group1012, this);">10:30 AM</option>
									<option id="activity_7690" onclick="selectActivity(group1012, this);">11:00 AM</option>
									<option id="activity_8041" onclick="selectActivity(group1012, this);">11:30 AM</option>
									<option id="activity_7691" onclick="selectActivity(group1012, this);">12:00 PM</option>
									<option id="activity_7698" onclick="selectActivity(group1012, this);">12:30 PM</option>
									<option id="activity_7692" onclick="selectActivity(group1012, this);">1:00 PM</option>
									<option id="activity_8450" onclick="selectActivity(group1012, this);">1:30 PM</option>
									<option id="activity_7693" onclick="selectActivity(group1012, this);">2:00 PM</option>
									<option id="activity_7694" onclick="selectActivity(group1012, this);">2:30 PM</option>
									<option id="activity_8254" onclick="selectActivity(group1012, this);">3:00 PM</option>
									<option id="activity_12270" onclick="selectActivity(group1012, this);">3:30 PM</option>

								</select>
								
								<script>
									
									$("#zipline-times").bind("click", function() {
									
										if ( $('body select#zipline-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#zipline-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
																						
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>
						
						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1012" size="8">

							</div>

						</div>

						<div class="form-row total-price">
							<label>Total Price with taxes hello: <span id="price_g1012"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="bookZipline(group1012);">Book Now</a>
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