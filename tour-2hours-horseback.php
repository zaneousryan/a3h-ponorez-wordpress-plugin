<!-- The Modal -->
<div id="modal-2hour-horseback-tour" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">

				// Activity group settings
				var group1003 = {
					
					supplierid: 225,
					activityids: [ 7748, 7597, 7598, 7600, 7656, 10603, 10604, 9155, 9156, 7658, 9157, 13099,13100,13101,13102 ],
					guesttypeids: [ 274, 1554 ],
					
					activityprices: {
						
						7748: { 274: 144.45, 1554: 94.19 },
						7597: { 274: 144.45, 1554: 94.19 },
						7598: { 274: 144.45, 1554: 94.19 },
						7600: { 274: 144.45, 1554: 94.19 },
						7656: { 274: 144.45, 1554: 94.19 },
						10603: { 274: 144.45, 1554: 94.19 },
						10604: { 274: 144.45, 1554: 94.19 },
						9155: { 274: 144.45, 1554: 94.19 },
						9156: { 274: 144.45, 1554: 94.19 },
						7658: { 274: 144.45, 1554: 94.19 },
						9157: { 274: 144.45, 1554: 94.19 },
						13099: { 274: 144.45, 1554: 94.19 },
						13100: { 274: 144.45, 1554: 94.19 },
						13101: { 274: 144.45, 1554: 94.19 },
						13102: { 274: 144.45, 1554: 94.19 }
						
					},
					
					datecontrolid: "date_g1003",
					pricecontrolid: "price_g1003",
					
					activitycheckboxcontrolids: {
						
						7748: "activity_7748",
						7597: "activity_7597",
						7598: "activity_7598",
						7600: "activity_7600",
						7656: "activity_7656",
						10603: "activity_10603",
						10604: "activity_10604",
						9155: "activity_9155",
						9156: "activity_9156",
						7658: "activity_7658",
						9157: "activity_9157",
						13099: "activity_13099",
						13100: "activity_13100",
						13101: "activity_13101",
						13102: "activity_13102"
					
					},
					
					activitydescriptioncontrolids: {
						
						7748: "activity_7748_description",
						7597: "activity_7597_description",
						7598: "activity_7598_description",
						7600: "activity_7600_description",
						7656: "activity_7656_description",
						10603: "activity_10603_description",
						10604: "activity_10604_description",
						9155: "activity_9155_description",
						9156: "activity_9156_description",
						7658: "activity_7658_description",
						9157: "activity_9157_description",
						13099: "activity_13099_description",
						13100: "activity_13100_description",
						13101: "activity_13101_description",
						13102: "activity_13102_description"
					
					},
					
					activitynotavailablemessagecontrolids: {
						
						7748: "activity_7748_notavailablemessage",
						7597: "activity_7597_notavailablemessage",
						7598: "activity_7598_notavailablemessage",
						7600: "activity_7600_notavailablemessage",
						7656: "activity_7656_notavailablemessage",
						10603: "activity_10603_notavailablemessage",
						10604: "activity_10604_notavailablemessage",
						9155: "activity_9155_notavailablemessage",
						9156: "activity_9156_notavailablemessage",
						7658: "activity_7658_notavailablemessage",
						9157: "activity_9157_notavailablemessage",
						13099: "activity_13099_notavailablemessage",
						13100: "activity_13100_notavailablemessage",
						13101: "activity_13101_notavailablemessage",
						13102: "activity_13102_notavailablemessage"
					},
				
					guesttypecontrolids: {
						
						274: "guests_g1003_t274",
						1554: "guests_g1003_t1554"
					
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

					if(jQuery('#promotionalcode_g1003').val() == 1){
					    if(jQuery('#guests_g1003_t1554').val() == 0){
					          
					          price = price/2;
					          alert(price);
					    } else {
					          alert('abc');
					    }
					    
					}
					var activityid = getSelectedActivityId(group, false);
					var activitydate = getActivityDate(group, false);
					var minavailability = { guests: {} };
					var price = 0.0;
					var failure = false;

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

				function book2hrsHorseback(group) {

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

					setpromotionalcode(document.getElementById('promotionalcode_g1003').value); 

					setgoogleanalytics('UA-12595817-1');
					
					//availability_popup();
					availability_iframe_popup();

					return true;

				}

			</script>

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">
						
						<h3>2-Hour Horseback Tour</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adults</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1003_t274" onchange="showPriceAndAvailability(group1003);">

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

								<select class="form-control browser-default" id="guests_g1003_t1554" onchange="showPriceAndAvailability(group1003);">

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
								<input id="date_g1003" class="form-control browser-default" onclick="showCalendar(group1003);" onchange="showPriceAndAvailability(group1003);" readOnly />
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1003);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="2hr-horseback-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1003);" onclick="showPriceAndAvailability(group1003);">

									<option value="0" onclick="selectActivity(group1003, this);">Select time</option>

									<option id="activity_7748" onclick="selectActivity(group1003, this);">8:30 AM</option>
									<option id="activity_7597" onclick="selectActivity(group1003, this);">9:30 AM</option>
									<option id="activity_13099" onclick="selectActivity(group1003, this);">9:45 AM</option>
									<option id="activity_7598" onclick="selectActivity(group1003, this);">11:15 AM</option>
									<option id="activity_13100" onclick="selectActivity(group1003, this);">11:30 AM</option>
									<option id="activity_13101" onclick="selectActivity(group1003, this);">12:00 PM</option>
									<option id="activity_7600" onclick="selectActivity(group1003, this);">12:15 PM</option>
									<option id="activity_7656" onclick="selectActivity(group1003, this);">1:30 PM</option>
									<option id="activity_13102" onclick="selectActivity(group1003, this);">2:00 PM</option>
									<option id="activity_10603" onclick="selectActivity(group1003, this);">2:30 PM</option>
									<option id="activity_10604" onclick="selectActivity(group1003, this);">2:45 PM</option>
									<option id="activity_9155" onclick="selectActivity(group1003, this);">3:00 PM</option>
									<option id="activity_9156" onclick="selectActivity(group1003, this);">3:15 PM</option>
									<option id="activity_7658" onclick="selectActivity(group1003, this);">3:30 PM</option>
									<option id="activity_9157" onclick="selectActivity(group1003, this);">3:45 PM</option>

								</select>
								
								<script>
									
									$("#2hr-horseback-times").bind("click", function() {
									
										if ( $('body select#2hr-horseback-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#2hr-horseback-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
																						
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>

						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1003" onchange="showPriceAndAvailability(group1003);" size="8">

							</div>

						</div>
						
						<div class="form-row total-price">
							<label>Total Price with taxes: <span id="price_g1003"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="book2hrsHorseback(group1003);">Book Now</a>
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