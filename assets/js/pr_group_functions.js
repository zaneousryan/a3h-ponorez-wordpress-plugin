/** Booking functions for accordian booking pages

    - Some of these functions originated in https://www.hawaiifun.org/reservation/external/functions2.js?jsversion=20121209&ver=20121209
      They are marked in comments as "F2".
    - Others are from the booking code handed out by Pono Rez on group setup. They are not marked in comments.
*/

// F2
var baseurl = 'https://www.hawaiifun.org/reservation/';
if (getBaseUrl().match(/^https?:\/\/[a-z]+[:\/]/) || getBaseUrl().match(/reservation_test/)) // single-word hostname
{
  baseurl = getBaseUrl();
}

// F2
function getBaseUrl()
{
  var myName = /^(.*[\/\\])external\/functions2\.js(?:\?|$)/;
  var scripts = document.getElementsByTagName("script");
  for (var i = 0; i < scripts.length; i++) {
    var src = scripts[i].src;
    if (src && src.match(myName)) {
      return RegExp.$1;
    }
  }

  return '';
}

// F2
function checkAvailability(callback, activityid, activitydate, minavailability) {
  jQuery.ajax({
    type: 'GET',
    url: baseurl + 'externalservlet',
    dataType: 'jsonp',
    success: callback,
    error: function(XMLHttpRequest, textStatus, errorThrown) { alert(baseurl + ' ' + textStatus + ' ' + errorThrown); },
    data: {
      action: 'AVAILABILITYCHECKJSONP',
      activityid: jQuery.makeArray(activityid).join('|'),
      activitydate: activitydate,
      minavailability: JSON.stringify(minavailability)
    }
  });
}

// F2
function purchase(data) {
  var deferred = $.Deferred();

  jQuery.ajax({
    type: 'GET',
    url: baseurl + 'externalservlet',
    dataType: 'jsonp',
    data: {
      action: 'PURCHASEJSONP',
      activityid: data.activityid,
      activitydate: data.activitydate,
      guestsandupgrades: JSON.stringify(data.guestsandupgrades),
      price: data.price,
      firstname: data.firstname,
      lastname: data.lastname,
      phone: data.phone,
      email: data.email,
      ccfirstname: data.ccfirstname,
      cclastname: data.cclastname,
      ccnumber: data.ccnumber,
      csc: data.csc,
      ccmonth: data.ccmonth,
      ccyear: data.ccyear,
      address: data.address,
      city: data.city,
      state: data.state,
      zip: data.zip,
      hotelid: data.hotelid,
      room: data.room,
      transportationrouteid: data.transportationrouteid,
      checklist: JSON.stringify(data.checklist)
    },
    statusCode: {
      200: function (data, textStatus, jqXHR) {
        if (data.errorMessage)
        {
          deferred.reject(data.errorMessage);
        }
        else
        {
          deferred.resolve(data);
        }
      },
      500: function (jqXHR, textStatus, errorThrown) {
        deferred.reject(jqXHR.responseText);
      }
    }
  });

  return deferred.promise();
}

// End F2 functions

function showCalendar(group) {
  var minavailability = { guests: {} };
  var failure = false;
  var totalGuestCount = 0;
  
  jQuery.each(group.guesttypeids, function(key, value) {
    if (failure) return;
    var guesttypeid = value;
    var guestscount = getGuestsCount(group, guesttypeid, false);

    if (null != guestscount) {
      totalGuestCount += guestscount;
      minavailability.guests[guesttypeid] = guestscount;
    }
  });
  
  if (0 == totalGuestCount) {
    alert('Please select guest count for all guest types');
    //return null;
  }
  else {
    // Show calendar (only if all guest type counts are correct)
    calendar(group.activityids, group.datecontrolid, false, minavailability);
  }
}

function formatMoney(n) {
  var c = 2,
      d = ".",
      t = ",",
      s = n < 0 ? "-" : "",
      i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
      j = (j = i.length) > 3 ? j % 3 : 0;
  
  return s + (j ? i.substr(0, j) + t : "")
    + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
    + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function showPriceAndAvailability(group) {
  var activityid = getSelectedActivityId(group, false);
  var activitydate = getActivityDate(group, false);
  var minavailability = { guests: {} };
  var transportationrouteid = getTransportationRouteId(group);
  var price = 0.0;
  var failure = false;
  var totalGuestCount = 0;
  
  jQuery.each(group.guesttypeids, function(key, value) {
    if (failure) return;
    var guesttypeid = value;
    var guestscount = getGuestsCount(group, guesttypeid, false);
    
    if (guestscount == null) {
      //failure = true;
      guestscount = 0;
    } else {
      if (activityid != null) {
        var guesttypeprice = group.activityprices[activityid][guesttypeid];
        price += guestscount * guesttypeprice;
        if (transportationrouteid == 355)
        {
          price += guestscount * 15.71;
        }
      }
      minavailability.guests[guesttypeid] = guestscount;
      totalGuestCount += guestscount;
    }
  });

  // At this point, if guest count is 0, it's a failure. -- @ELA
  if (0 == totalGuestCount){
    failure = true;
  }
  
  //Add upgrades to price
  jQuery.each(group.upgradetypeids, function(key, value) {
    if (failure) return;
    var upgradetypeid = value;
    var upgradescount = getUpgradesCount(group, upgradetypeid, false);
    
    if (upgradescount == null) {
      //failure = true;
      upgradescount = 0;
    } else {
      if (activityid != null) {
        var upgradesprice = group.upgradeprices[activityid][upgradetypeid];
        price += upgradescount * upgradesprice;
      }
    }
  });

  // Show total price (only if activity is selected and all guest type counts are correct)
  if (activityid != null && !failure) {
    jQuery('#' + group.pricecontrolid).html('$' + formatMoney(price));
  } else {
    jQuery('#' + group.pricecontrolid).html('');
  }

  if (activitydate != null && !failure) {
    checkAvailability(function(data) {
      jQuery.each(group.activityids, function(key, value) {
        // Enable or disable activities based on availability (only if activity date is selected and all guest types are correct)
        var activityid = value;
        if (!data[activityid]) jQuery('#' + group.activitycheckboxcontrolids[activityid]).attr('checked', false);
        jQuery('#' + group.activitycheckboxcontrolids[activityid]).prop('disabled', !data[activityid]);
        jQuery('#' + group.activitydescriptioncontrolids[activityid]).css('color', data[activityid] ? 'black' : 'gray');
        jQuery('#' + group.activitynotavailablemessagecontrolids[activityid]).toggle(!data[activityid]);
      });
    }, group.activityids, activitydate, minavailability);
  }
}

function getSelectedActivityId(group, showWarningIfNoActivitySelected) {
    var activityid = null;
    jQuery.each(group.activityids, function(key, value) {
        if (jQuery('#' + group.activitycheckboxcontrolids[value]).is(':checked')) activityid = value;
    });
    if (activityid == null && showWarningIfNoActivitySelected) {
        alert('Please select seating package');
    }
    return activityid;
}

function getGuestsCount(group, guestTypeId, showWarningIfWrongFormat) {
  var guestscountstr = jQuery('#' + group.guesttypecontrolids[guestTypeId]).val();

  if (guestscountstr == '')
    return 0;
  
  if (!/^\d+$/.test(guestscountstr)) {
    if (showWarningIfWrongFormat) {
      alert('Please select guest count');
    }
    return null;
  }
  
  return parseInt(guestscountstr);
}

function getUpgradesCount(group, upgradeTypeId, showWarningIfWrongFormat) {
  var upgradescountstr = jQuery('#' + group.upgradecontrolids[upgradeTypeId]).val();

  if (upgradescountstr == '')
    return 0;
  
  if (!/^\d+$/.test(upgradescountstr)) {
    if (showWarningIfWrongFormat) {
      alert('Please select upgrades count');
    }
    return null;
  }
  
  return parseInt(upgradescountstr);
}

function getActivityDate(group, showWarningIfWrongFormat) {
    var activitydatestr = jQuery('#' + group.datecontrolid).val();
    if (!/^\d\d?\/\d\d?\/\d\d\d\d$/.test(activitydatestr)) {
        if (showWarningIfWrongFormat) {
            alert('Please select activity date');
        }
        return null;
    }
    return activitydatestr;
}

function getTransportationRouteId(group) {
    return jQuery('[name=\'' + group.transportationroutecontrolname + '\']:visible:checked').val();
}

function getPromotionalCode(group) {
    return jQuery('#' + group.promotionalcodecontrolid).val();
}

function getHotelId(group) {
    return jQuery('#' + group.hotelcontrolid).val();
}

function getRoom(group) {
    return jQuery('#' + group.roomcontrolid).val();
}

function selectActivity(group, selectedcheckbox) {
    if (!selectedcheckbox.checked) return;
    jQuery.each(group.activityids, function(key, value) {
        if (selectedcheckbox.id == group.activitycheckboxcontrolids[value]) return;
        jQuery('#' + group.activitycheckboxcontrolids[value]).attr('checked', false);
    });
}

/**
  This function has been modified from the Pono Rez standard in order
  to handle multiple control policy checkboxes.
 */
function booknow(group, google) {
  // Collect checkboxes. They must all be checked!
  var unchecked = jQuery('.' + group.cancellationpolicycontrolid + ':not(:checked)');
  if (0 < unchecked.length) {
    alert('Please check cancellation policy');
    return false;
  }
  
  var activityid = getSelectedActivityId(group, true);
  if (activityid == null)
    return false;

  var activitydate = getActivityDate(group, true);
  if (activitydate == null)
    return false;

  reservation(group.supplierid, activityid, activitydate, '', 0.0);

  jQuery.each(group.guesttypeids, function(key, value) {
    var guesttypeid = value;
    var guestscount = jQuery('#' + group.guesttypecontrolids[guesttypeid]).val();

    // Only add guests if it's available. Some guest types may not be present.
    if (guestscount) {
      addGuests(guesttypeid, guestscount);
    }
  });

  if (group.upgradetypeids){
    jQuery.each(group.upgradetypeids, function(key, value) {
      var upgradetypeid = value;
      var upgradescount = jQuery('#' + group.upgradecontrolids[upgradetypeid]).val();

      // Only add upgrades if it's available. Some upgrade types may not be present.
      if (upgradescount) {
        addUpgrades(upgradetypeid, upgradescount);
      }
    });
    
    setUpgradesFixed();
  
  };

  if(jQuery('#accommodation').length || jQuery('#accommodation1').length || jQuery('#accommodation2').length || jQuery('#accommodation3').length || jQuery('#accommodation4').length || jQuery('#accommodation5').length || jQuery('#accommodation6').length || jQuery('#accommodation7').length || jQuery('#accommodation8').length || jQuery('#accommodation9').length || jQuery('#accommodation10').length || jQuery('#accommodation11').length || jQuery('#accommodation12').length || jQuery('#accommodation13').length || jQuery('#accommodation14').length){

    setHotel(getHotelId(group)); setRoom(getRoom(group)); setTransportationRoute(getTransportationRouteId(group)); setAccommodationFixed();

  };
  
  setpromotionalcode(getPromotionalCode(group));

  setgoogleanalytics(google);

  // This pops up that "C h e c k i n g" window that doesn't do anything.
  availability_popup();
  
  return true;
}
//////// Snake's Code

  
	jQuery('.ponorezActivity-utv .modal-body .form-row #guests_utv_t3664').parent().addClass('passengers');
jQuery('.ponorezActivity-utv .modal-body .form-row #guests_utv_t3660').parent().addClass('passengers');
jQuery('.ponorezActivity-utv .modal-body .form-row #guests_utv_t3661').parent().addClass('passengers');
jQuery('.ponorezActivity-utv .modal-body .form-row #guests_utv_t3659').parent().addClass('passengers');
jQuery(`<div class="form-row">
          <label>Total Passengers</label>
          <select class="form-control" id="total-passenger" >
            <option value="0">0</option>
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
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
            <option value="32">32</option>
            <option value="33">33</option>
            <option value="34">34</option>
            <option value="35">35</option>
            <option value="36">36</option>
            <option value="37">37</option>
            <option value="38">38</option>
            <option value="39">39</option>
            <option value="40">40</option>
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
            <option value="47">47</option>
            <option value="48">48</option>
            <option value="49">49</option>
            <option value="50">50</option>
            <option value="51">51</option>
            <option value="52">52</option>
            <option value="53">53</option>
            <option value="54">54</option>
            <option value="55">55</option>
            <option value="56">56</option>
            <option value="57">57</option>
            <option value="58">58</option>
            <option value="59">59</option>
            <option value="60">60</option>
          </select></div>
        <div class="form-row">
          <label id="utv">0 UTVs</label></div>`).insertBefore('.ponorezActivity-utv .modal-body .form-row:nth-child(1)');

  

jQuery("#total-passenger").change(function(e){

  e.preventDefault();
  jQuery('#modal_questions .new_message').hide();
  jQuery('.blocker').css('position','unset');
  jQuery('#modal_questions').modal('show');
  jQuery('#modal_questions').css('z-index','100000');
  var temp = solo = 0;
  var driver, third, fourth;
  var num = jQuery('#total-passenger').val();
  if(jQuery.inArray( num, [ '5', '9', '10', '13', '14', '15' ] ) != -1){
   	alert('If you want to seat five people per UTV instead of the default four, please call our office and book directly.');
  }
  if(num % 4 == 1){
    if(num == 1){
      solo = 1;
      driver = third = fourth = 0;
    }
    else{
      temp = Math.floor(num / 4);
      driver = temp + 1;
      if(num == 5){
        third = 1;
        fourth = 0;
      }
      else{
        third = temp + 1;
        fourth = temp - 2;
      }
    }
  }
  else if(num % 4 == 2){
      temp = Math.floor(num / 4);
      driver = temp + 1;
      if(num == 2){
          third = fourth = 0;
      }else{
          third = temp;
          fourth = temp;
      }
  }
  else if(num % 4 == 3){
      temp = Math.floor(num / 4) + 1;

      driver = third = temp;
      fourth = temp - 1;
  }
  else if(num % 4 == 0){
      driver = third = fourth = num / 4;
  }

  jQuery("#guests_utv_t3659 option").filter(function() {
      return this.textContent == solo;
  }).prop('selected', true);

  jQuery("#guests_utv_t3664 option").filter(function() {
      return this.textContent == driver;
  }).prop('selected', true);
  
  jQuery("#guests_utv_t3660 option").filter(function() {
      return this.textContent == third;
  }).prop('selected', true);

  jQuery("#guests_utv_t3661 option").filter(function() {
      return this.textContent == fourth;
  }).prop('selected', true);
  
  if(num == 1){
    jQuery('#utv').text(jQuery('#guests_utv_t3659').val()+' UTVs');
  }
  else{
    jQuery('#utv').text(jQuery('#guests_utv_t3664').val()+' UTVs');
  }
  jQuery('#guests_utv_t3664').change();
});
jQuery('#modal_questions #yes').click(function(){
  jQuery('#modal_questions').modal('hide');
  		jQuery('.blocker').css('position','fixed');
		jQuery('#modal_questions').css('z-index','1');
});
  jQuery('#modal_questions #no').click(function(){
  		jQuery('#modal_questions .questions').hide();
		jQuery('#modal_questions .new_message').show();
});
    jQuery('#modal_questions #okay').click(function(){
  jQuery('#modal_questions').modal('hide');
  		jQuery('#modal_questions').modal('hide');
		jQuery('#modal-utv .close').trigger('click');
      	jQuery('#modal_questions .questions').show();
		jQuery('#modal_questions .new_message').hide();
      jQuery('.booking-form').trigger('reset');
      jQuery('#price_utv').text('');
});  
jQuery(`<label>Pricing:</label>
            <ul>
                <li> First Two Guests (Driver + Passenger) – $299 +tx</li>
                <li> Third Guest – $140 +tx</li>
                <li> Fourth Guest – $120 +tx</li>
            </ul>
            <p>*To request a different number of vehicles, please call our guest service 
                representatives toll free at 1-844-933-4294, daily 8 am-5pm HST. </p>`)
  .insertAfter('#modal-utv .modal-body .form-row:first-child');

jQuery(`<label>Minimum 2 guests required to reserve a vehicle</label>
            <ul>
                <li> Number of vehicles assigned is based on maximum 4 guests per vehicle</li>
                <li> Driver must be at least 21 years old</li>
            </ul>`)
  .insertBefore('#modal-utv .modal-body .form-row:first-child');
//////////////////////