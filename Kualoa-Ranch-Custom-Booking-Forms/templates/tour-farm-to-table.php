<!-- The Modal -->
<div id="modal-farm-to-table" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">
				// alert('modal-farm-to-table');
				// Activity group settings
				var group1020 = {

					supplierid: 225,
					activityids: [ 8888, 9508, 8748 ],
					guesttypeids: [ 274, 1554 ],

					activityprices: {
						
						8888: { 274: 157.02, 1554: 130.84, },
						9508: { 274: 125.60, 1554: 83.72, },
						8748: { 274: 157.02, 1554: 130.84, }
						
					},

					datecontrolid: 'date_g1020',
					pricecontrolid: 'price_g1020',

					activitycheckboxcontrolids: {
						
						8888: "activity_8888",
						9508: "activity_9508",
						8748: "activity_8748"
						
					},
					
					activitydescriptioncontrolids: {
					
						8888: "activity_8888_description",
						9508: "activity_9508_description",
						8748: "activity_8748_description"
						
					},
					
					activitynotavailablemessagecontrolids: {
					
						8888: "activity_8888_notavailablemessage",
						9508: "activity_9508_notavailablemessage",
						8748: "activity_8748_notavailablemessage"
						
					},

					guesttypecontrolids: {
						
						274: "guests_g1020_t274",
						1554: "guests_g1020_t1554"
					
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
					console.log('farm');
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

				function bookFarmToTable(group) {

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

					setpromotionalcode(document.getElementById('promotionalcode_g1020').value); 

					setgoogleanalytics('UA-12595817-1');
					
					//availability_popup();
					availability_iframe_popup();

					return true;

				}

			</script>

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">
						
						<h3>Farm To Table Tour</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adult</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1020_t274" onchange="showPriceAndAvailability(group1020);">

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

								<select class="form-control browser-default" id="guests_g1020_t1554" onchange="showPriceAndAvailability(group1020);">

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
								<input id="date_g1020" class="form-control browser-default" onclick="showCalendar(group1020);" onchange="showPriceAndAvailability(group1020);" readOnly />
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1020);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="kualoa-tour-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1020);" onclick="showPriceAndAvailability(group1020);">

								  <option value="0" onclick="selectActivity(group1020, this);">Select time</option>

								  <!--<option id="activity_8888" onclick="selectActivity(group1020, this);"> 9:00 AM </option>-->
 								  <option id="activity_9508" onclick="selectActivity(group1020, this);"> 9:30 AM </option>
								  <!--<option id="activity_8748" onclick="selectActivity(group1020, this);"> 1:00 PM </option>-->
									
								</select>
								
								<script>
									
									$("#kualoa-tour-times").bind("click", function() {
									
										if ( $('body select#kualoa-tour-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#kualoa-tour-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
																						
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>
						
						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1020" size="8">

							</div>

						</div>

						<div class="form-row total-price">
							<label>Total Price with taxes: <span id="price_g1020"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="bookFarmToTable(group1020);">Book Now</a>
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