<!-- The Modal -->
<div id="modal-secret-island" class="ponorezmodal">

	<!-- Modal content -->
	<div class="modal-form-content">

		<form class="booking-form">

			<script type="text/javascript">

				// Activity group settings
				var group1014 = {

					supplierid: 225,
					// activityids: [ 7559, 10211, 7753 ],
					activityids: [ 13096, 13097 ],
					guesttypeids: [ 274, 1554, 1190 ],
					
					activityprices: {
						13096: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						13097: { 274: 51.26, 1554: 38.69, 1190: 0.00 }
						// 7559: { 274: 51.26, 1554: 38.69, 1190: 0.00 },
						// 10211: { 274: 118.27, 1554: 73.25, 1190: 0.00 },
						// 7753: { 274: 51.26, 1554: 38.69, 1190: 0.00 }
						
					},

					datecontrolid: 'date_g1014',
					pricecontrolid: 'price_g1014',

					activitycheckboxcontrolids: {
						13096: "activity_13096",
						7559: "activity_7559",
						10211: "activity_10211",
						13097: "activity_13097",
						7753: "activity_7753"
						
					},
					
					activitydescriptioncontrolids: {
						13096: "activity_13096_description",
						7559: "activity_7559_description",
						10211: "activity_10211_description",
						13097: "activity_13097_description",
						7753: "activity_7753_description"
						
					},
					
					activitynotavailablemessagecontrolids: {
						13096: "activity_13096_notavailablemessage",
						7559: "activity_7559_notavailablemessage",
						10211: "activity_10211_notavailablemessage",
						13097: "activity_13097_notavailablemessage",
						7753: "activity_7753_notavailablemessage"
						
					},
					
					guesttypecontrolids: {
						
						"274": "guests_g1014_t274",
						"1554": "guests_g1014_t1554",
						"1190": "guests_g1014_t1190"
					
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
					 console.log('secret');
					var activityid = getSelectedActivityId(group, false);
					var activitydate = getActivityDate(group, false);
					var minavailability = { guests: {} };
					var price = 0.0;
					var failure = false;
					////////////////////////////////////////////////
					console.log(group);
					var res = group.pricecontrolid.split("_");
					var promoCode = jQuery('#promotionalcode_'+res[1]).val();
					if(promoCode == 'BOGO')
					{
						
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
					    } 
						else {
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
					else if (promoCode == 'BOGOHalf'){
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

				function bookSecretIsland(group) {
				    console.log("bookSecretIsland");
					var activityid = getSelectedActivityId(group, true);
					if (activityid == null) return false;

					var activitydate = getActivityDate(group, true);
					if (activitydate == null) return false;

					reservation(group.supplierid, activityid, activitydate, '', 0.0);

					 ////////////////////////////////////////////////
                    var freeAdultCount, freeChildCount, adultCount, childCount, halfAdultCount, halfChildCount = 0;
                    console.log(group);
                    var res = group.pricecontrolid.split("_");
                    var promoCode = jQuery('#promotionalcode_'+res[1]).val();
                    var adult = jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val();
                    var child = jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val();
					console.log('#promotionalcode_'+res[1]);
					console.log(promoCode);
                    if(promoCode == 'BOGO'){
                        if(child == 0){
                            if(adult%2 == 0){
                                    console.log('adults=' ,adult - (diff/2));
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(adult/2);
                                freeAdultCount = adult/2;
                            }
                            else{
                                    console.log('adults=' ,adult - (diff/2));
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(Math.ceil(adult/2));
                                freeAdultCount = (adult-1)/2;
                            }
                        } else {
                            if(adult == child){
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(0);
                                freeChildCount = child;
                            } 
                            else if(adult > child){
                                var diff = adult - child;
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(0);
                                freeChildCount = child;
                                console.log('freeChildCount=' ,freeChildCount);

                                if(diff%2==0){
                                    console.log('adults=' ,adult - (diff/2));
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(adult - (diff/2));
                                    freeAdultCount = diff/2;
                                }
                                else{
                                    console.log('freeAdultCount=' ,(diff-1)/2);
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(adult - (diff-1)/2);
                                    freeAdultCount = (diff-1)/2;
                                }
                            } 
                            else if(adult < child){
                                var diff = child - adult;
                                if(diff%2==0){
                                    console.log('freeChildCount=',child- (diff/2));
                                    freeChildCount = child - (diff/2);
                                    var temp = child - adult - (diff/2);
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(temp);
                                }
                                else{
                                    console.log('freeChildCount=',child - Math.ceil(diff/2));
                                    freeChildCount = child - Math.ceil(diff/2);
                                    var temp = child - adult - ((diff-1)/2);
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(temp);
                                }
                            } 
                        }
                    }
                    else if (promoCode == 'BOGOHalf'){
                        if(child == 0){
                            if(adult%2 == 0){
                                
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(adult/2);
                                halfAdultCount = adult/2;
                                console.log('halfAdultCount=' ,halfAdultCount);
                            }
                            else{
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(Math.ceil(adult/2));
                                halfAdultCount = (adult-1)/2;
                                console.log('halfAdultCount=' ,halfAdultCount);
                            }
                        } else {
                            if(adult == child){
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(0);
                                halfChildCount = child;
                                console.log('halfChildCount=' ,halfChildCount);
                            } 
                            else if(adult > child){
                                var diff = adult - child;
                                jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(0);
                                halfChildCount = child;
                                console.log('halfChildCount=' ,halfChildCount);
                                if(diff%2==0){
                                    
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(adult - (diff/2));
                                    halfAdultCount = diff/2;
                                    console.log('halfAdultCount=' , halfAdultCount);
                                }
                                else{
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[0]).val(adult - (diff-1)/2);
                                    halfAdultCount = (diff-1)/2;
                                    console.log('halfAdultCount=' ,halfAdultCount);
                                }
                            } 
                            else if(adult < child){
                                var diff = child - adult;
                                if(diff%2==0){
                                    
                                    var temp = child - adult - (diff/2);
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(temp);
                                    halfChildCount = child - (diff/2);
                                    console.log('halfChildCount=',halfChildCount);
                                }
                                else{
                                    
                                    var temp = child - adult - ((diff-1)/2);
                                    jQuery('#guests_'+res[1]+'_t'+group.guesttypeids[1]).val(temp);
                                    halfChildCount = child - Math.ceil(diff/2);
                                    console.log('halfChildCount=',halfChildCount);
                                }
                            } 
                        }
                    }
                    if (freeAdultCount) {
                        addGuests(3702, freeAdultCount);
                    }
                    if (freeChildCount) {
                        addGuests(3703, freeChildCount);
                    }
                    if (halfAdultCount) {
                        addGuests(3673, halfAdultCount);
                    }
                    if (halfChildCount) {
                        addGuests(3675, halfChildCount);
                    }
                    
                    //////////////////////////////////////////////////////////////////////////

					$.each(group.guesttypeids, function(key, value) {

						var guesttypeid = value;
						var guestscount = $('#' + group.guesttypecontrolids[guesttypeid]).val();
						addGuests(guesttypeid, guestscount);

					});
					
					if(promoCode != 'BOGOHalf' && promoCode != 'BOGO')
					{
						setpromotionalcode(document.getElementById('promotionalcode_g1014').value); 
					}


					setgoogleanalytics('UA-12595817-1');
					
					//availability_popup();
					availability_iframe_popup();

					return true;

				}

			</script>

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">
						
						<h3>Secret Island Beach Activities</h3> <a class="close" href="#" rel="modal:close"><i class="fa fa-times" aria-hidden="true"></i></a>

					</div>

					<div class="modal-body" data-step="1">

						<div class="form-row">

							<label>Adult</label>

							<div class="input-wrapper">

								<select class="form-control browser-default" id="guests_g1014_t274" onchange="showPriceAndAvailability(group1014);">

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

								<select class="form-control browser-default" id="guests_g1014_t1554" onchange="showPriceAndAvailability(group1014);">

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

								<select class="form-control browser-default" id="guests_g1014_t1190" onchange="showPriceAndAvailability(group1014);">

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
								<input id="date_g1014" class="form-control browser-default" onclick="showCalendar(group1014);" onchange="showPriceAndAvailability(group1014);" readOnly />
								<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1014);" style="vertical-align: middle;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
							</div>

						</div>

						<div class="form-row">

							<label>Select from available times:</label>

							<div class="input-wrapper">
								
								<select id="secret-island-times" class="groupSelect form-control activity-time browser-default" onchange="showPriceAndAvailability(group1014);" onclick="showPriceAndAvailability(group1014);">

									<option value="0" onclick="selectActivity(group1014, this); showPriceAndAvailability(group1014);">Select time</option>

									<option id="activity_13096" onclick="selectActivity(group1014, this); showPriceAndAvailability(group1014);"> 8:30 AM </option>
									<!-- <option id="activity_7559" onclick="selectActivity(group1014, this); showPriceAndAvailability(group1014);"> 9:00 AM </option>
									<option id="activity_10211" onclick="selectActivity(group1014, this); showPriceAndAvailability(group1014);"> 9:00 AM (Full Day with Bento Lunch) </option>
									<option id="activity_7753" onclick="selectActivity(group1014, this); showPriceAndAvailability(group1014);"> 11:30 AM </option> -->
									<option id="activity_13097" onclick="selectActivity(group1014, this); showPriceAndAvailability(group1014);"> 11:45 AM </option>
									
								</select>
								
								<script>
									
									$("#secret-island-times").bind("click", function() {
									
										if ( $('body select#secret-island-times:not(:disabled) option:not(:disabled)').length == 1 && $('body select#secret-island-times:not(:disabled) option:not(:disabled)').val() == '0' ) {
											
											alert('No time slots available for this date. Please select another.');
											
										} 
										
									});
									
								</script>
								
							</div>

						</div>
						
						<div class="form-row">

							<div class="input-wrapper">

								<label>Promotional Code (optional):</label>
								<input type="text" class="form-control" id="promotionalcode_g1014" size="8" onchange="showPriceAndAvailability(group1014);">

							</div>

						</div>

						<div class="form-row total-price">
							<label>Total Price with taxes: <span id="price_g1014"></span></label>
						</div>

					</div>

					<div class="modal-footer">

						<a href="#" class="btn btn-default btn-book-now" onclick="bookSecretIsland(group1014);">Book Now</a>
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