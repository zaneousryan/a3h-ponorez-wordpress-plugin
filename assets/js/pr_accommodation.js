var Accommodation = (function () {
  var dataOfActivityById = {};
  var routeDataBySupplierId = {};

  var activityDeferredById = {};
  // Once this is resolved, the corresponding dataOfActivityById and routeDataBySupplierId
  // values are assumed to be set.

  var m;

  var initHotels = function (supplierId, activityId, agencyId, $hotelSelect, routeSelectionContextData, modalId) {
      $hotelSelect.empty();
      if (null == modalId || modalId == '') {
          modalId = activityId;
      }
    var hotelInfosOfActivity = dataOfActivityById[activityId].hotelInfos;
    var localResidenceHotelInfo = null;
    var localResidenceHotelId = null;
    jQuery.each(hotelInfosOfActivity, function () {
      if (this.special == 'localResidence') {
        localResidenceHotelInfo = this;
        localResidenceHotelId = this.id;
        return false;
      }
    });

    if (localResidenceHotelInfo != null) {
      $hotelSelect.append(jQuery("<option />").attr('value', localResidenceHotelInfo.id).text(''));
    }
    for (var i = 0; i < hotelInfosOfActivity.length; ++i) {
      var hotelInfo = hotelInfosOfActivity[i];
      if (hotelInfo.id == localResidenceHotelId) continue;

      $hotelSelect.append(jQuery("<option />").attr('value', hotelInfo.id).text(hotelInfo.name));
    }

    if (routeSelectionContextData) {
      m.setupTransportationRoutes({ supplierId: supplierId, activityId: activityId, agencyId: agencyId, hotelId: $hotelSelect.val(), routeSelectionContextData: routeSelectionContextData });
    }
      ///////////////////////////////
      jQuery('#transportationRoutesContainer_a' + modalId).find('div').each(function () {
        jQuery(this).find('label').attr('name',jQuery(this).find('label').text());
    });
    ///////////////////////////////
     /////////////////////////////Options order change///////////////////////////////
      var temp = jQuery('#transportationRoutesContainer_a' + modalId).find('div')[0];
      var c = jQuery(temp).clone();
      jQuery('#transportationRoutesContainer_a'+modalId).append(c);
      jQuery(temp).remove();
      /////////////////////////////////////////////////////////////////////////////////
  };



  var getPromiseResult = function (promise) {
    var savedResult;
    promise.done(function (result) { savedResult = result; });

    return savedResult;
  };

  m = {
      loadHotels: function (params) {
      // params: { supplierId, activityId, agencyId, hotelSelectSelector, (optional) routeSelectionContextData }

      // supplierId is assumed to match activityId; that is, we won't be called with the same activityId
      // but different supplierId.

      var $hotelSelect = jQuery(params.hotelSelectSelector);

      // 1.
      // Ensure that activityDeferredById[activityId] exists and is either resolved or pending;
      // this means initiating the JSON request for the data we want, if we don't have this data
      // ready or in process of retrieval.

      if (!activityDeferredById[params.activityId] || activityDeferredById[params.activityId].state() == 'rejected') {
        var activityDeferred = jQuery.Deferred();

        var lackRouteData = !routeDataBySupplierId[params.supplierId];
        var postData = { supplierid: params.supplierId, activityid: params.activityId, wantroutedata: lackRouteData };

        var assumedTimeout = false;
        // Wait for completion no more than 30 seconds:
        setTimeout(function () { assumedTimeout = true; activityDeferred.reject(); }, 30 * 1000);

        jQuery.post(baseurl + 'externalservlet?action=GETTRANSPORTATIONDATA_JSONP', postData, null, 'jsonp')
          .done(function (response) {
            if (assumedTimeout) {
              // Too late, we already assumed timeout.
              return;
            }

            if (response.errorMessage) {
              alert('Failed to retrieve hotel list: ' + response.errorMessage);
              activityDeferred.reject();
              return;
            }

            var responseDataOfActivity = response.dataOfActivityById && response.dataOfActivityById[params.activityId];
            var responseRouteData = response.routeData;
            // console.log('Response ' , responseRouteData);
            if (!responseDataOfActivity || (lackRouteData && !responseRouteData)) {
              // We didn't get what we wanted, for some reason.
              activityDeferred.reject();
              return;
            }

            dataOfActivityById[params.activityId] = {
              hotelInfos: responseDataOfActivity.hotelInfos,
              routeInfos: responseDataOfActivity.routeInfos
            };
            // console.log( 'dataOfActivityById ' , dataOfActivityById );
            if (lackRouteData) {
              routeData = {};
              jQuery.each(responseRouteData, function (routeId) {
                var dataOfRoute = this;
                routeData[routeId] = { hotelLinkMap: dataOfRoute.hotelLinkMap, hotelInfoMap: dataOfRoute.hotelInfoMap };
              });

              routeDataBySupplierId[params.supplierId] = routeData;
              // This may actually overwrite earlier data (since we can have concurrent
              // requests with different activityId's but the same supplierId), but it's ok.
            }

            activityDeferred.resolve(true);
          });

        activityDeferredById[params.activityId] = activityDeferred;
      }

      // 2.
      // Tell the user that we are waiting (if we actually are).

      if (activityDeferredById[params.activityId].state() == 'pending') {
        $hotelSelect.empty();
        $hotelSelect.append(jQuery("<option />").text('-- Loading --'));
        $hotelSelect.prop('disabled', true);
      }

      // 3.
      // Wait for loading to complete (or don't wait, if we already had data)
      // and then populate the hotels select.

      activityDeferredById[params.activityId].done(function () {
        initHotels(params.supplierId, params.activityId, params.agencyId, $hotelSelect, params.routeSelectionContextData, params.modalId);
        $hotelSelect.prop('disabled', false);
      });
    },

      setupTransportationRoutes: function (params) {


      // params: { supplierId, activityId, agencyId, hotelId, routeSelectionContextData }    
      var contextData = params.routeSelectionContextData;
      // console.log(contextData);
      // jQuery(contextData.routesContainerSelector).hide();
      jQuery.each(contextData.routeSelectorMap, function (transportationRouteId, routeSelector) {
        if (!routeSelector)
          return;
        jQuery(routeSelector).hide();
      });

      if (!params.hotelId)
        return;

      var dataOfActivity = dataOfActivityById[params.activityId];
      var routeData = routeDataBySupplierId[params.supplierId];

      // @DEBUG
      //console.log('dataOfActivity: ' + JSON.stringify(dataOfActivity));
      //console.log('routeData: ' + JSON.stringify(routeData));

      var haveRouteSelection = false;
      // jQuery(contextData.routesContainerSelector).find('div').hide();
      var selectedArray = [];
      // console.log('params ', params);
      jQuery.each(dataOfActivity.routeInfos, function (index, routeInfo) {
        if (params.agencyId != 0 && !routeInfo.agencyEnabled)
          return;

        if (routeData[routeInfo.id]) {
          // If this supplier ever has any custom information on this route...
          var pickupHotelId = routeData[routeInfo.id].hotelLinkMap[params.hotelId] || params.hotelId;
          var routeInfoForHotel = routeData[routeInfo.id].hotelInfoMap[pickupHotelId];
          if (routeInfoForHotel) {
            if (routeInfoForHotel.notServicing)
              return;
            routeInfo = jQuery.extend({}, routeInfo, routeInfoForHotel);
          }
        }

        var routeElementSelector = contextData.routeSelectorMap[routeInfo.id];
        
        selectedArray.push(routeElementSelector);
        
        if (routeElementSelector) {
          jQuery(routeElementSelector).show();
          haveRouteSelection = true;
        }

      });
      
      // if (haveRouteSelection) {
        jQuery(contextData.routesContainerSelector).show();
      // }
      if (null == params.modalId || params.modalId == '') {
          params.modalId = params.activityId;
      }
      var selectedDate = new Date(jQuery('#date_a' + params.modalId).val());
      var selectedMonth = selectedDate.getMonth() + 1;
      selectedMonth = String(selectedMonth);

      var finalSelectedArray = [];
      var count=0;
      jQuery.each(selectedArray, function (index, selectedItem) {
          count++;

        // if(jQuery(this).hasClass('no-transport')){
        //   console.log('found no transp');
        // }
          var labelText = jQuery("div[id='" + selectedItem + "']").find('label').attr('name');
          if (!labelText.includes("(MONTHS:")) {
              finalSelectedArray.push(selectedArray[index]);
          }
          else {
              var labelDate, labelMonth, labelMth, labelM;
              if (labelText) {
                  labelDate = labelText.split('(');
              }
              if (labelDate && labelDate[1]) {
                  labelMonth = labelDate[1].split(':');
              }
              if (labelMonth && labelMonth[1]) {
                  labelMth = labelMonth[1].split(')');
              }
              if (labelMth && labelMth[0]) {
                  labelM = labelMth[0].split(',');
              }
              
              if (jQuery.inArray(selectedMonth, labelM) == -1) {
              } else {
                  finalSelectedArray.push(selectedArray[index]);
              }
          }
      });
      
      //////////////////////////No transport text change//////////////////////////////
      var temp = jQuery(contextData.routesContainerSelector).find('div:last-child');
      var f_label = jQuery(temp).find('label').html();
      var tag = f_label.split('>');
          console.log("count: " + count);
          console.log("activityId: " + params.activityId);
          if (params.activityId == 13263 || params.activityId == 13264) {
              if (count == 0) {

                  tag[1] = ' No pick available at this accommodation. Please select the drive out no pickup tour on the previous screen. ';
                  f_label = tag[0] + '>' + tag[1];
                  jQuery(temp).find('label').html(f_label);
                  jQuery(temp).find('input').prop('checked', true);

              }
          }
          else if (params.activityId == 13237){
              if (count == 0) {

                  tag[1] = 'This tour does not pick up from this location; please call our office (808) 575-9575 (Local) or (888) 922-2453';
                  f_label = tag[0] + '>' + tag[1];
                  jQuery(temp).find('label').html(f_label);
                  jQuery(temp).find('input').prop('checked', true);

              }
          }
          else {
              if (count == 0) {

                  tag[1] = ' No pick available at this accommodation. We look forward to seeing you at the designated meeting location.  Directions to follow in your email confirmation.';
                  f_label = tag[0] + '>' + tag[1];
                  jQuery(temp).find('label').html(f_label);
                  jQuery(temp).find('input').prop('checked', true);

              } else {

                  tag[1] = " Drive to our meeting location, directions to follow in your email confirmation.";
                  f_label = tag[0] + '>' + tag[1];
                  jQuery(temp).find('label').html(f_label);
                  jQuery(temp).find('input').prop('checked', false);

              }
          }
      
      ///////////////////////////////////////////////////////
       console.log('selected array', selectedArray);
      jQuery.each(finalSelectedArray, function (index, finalSelectedItem) {
        var labelText = jQuery("div[id='" + finalSelectedItem + "']").find('label').html();
        labelText = labelText.replace(/\(([^)]+)\)/g, '');
        jQuery("div[id='" + finalSelectedItem + "']").find('label').html(labelText);
      });
      
      finalSelectedArray.push(jQuery(contextData.routesContainerSelector).find('div:first-child').attr('id'));
          var routeFound = false;
      jQuery(contextData.routesContainerSelector).find('div').each(function () {
        var childId = jQuery(this).attr('id');
          if (jQuery.inArray(childId, finalSelectedArray) == -1) {
              if (this.id != "#NoTransportationOption") {
                  jQuery(this).hide();
                  console.log(this.id);
              }
              else if (routeFound == true && (params.activityId == 13263 || params.activityId == 13264 || params.activityId == 13237)) {
                  jQuery(this).hide();
                  console.log("Hidding " + this.id);
              }
              else {
                  jQuery(this).show();
                  console.log("showing " + this.id);
              }
        } else {
            jQuery(this).show();
              routeFound = true;
              console.log("Found");
            console.log(this.id);
        }
      });
        
      selectedArray = [];
      finalSelectedArray = [];


    }
  };
  // console.log('m ', m);
  return m;
})();

function updateHETVehicle(id) {
    var e = document.getElementById(id);    
    var paxCount = e.options[e.selectedIndex].text;    
    var strings = id.split('_t');
    var idTagBase = strings[0];    
    if (paxCount < 6) {//vehicle 11
        document.getElementById(idTagBase + '_t3700').checked = true;        
        //document.getElementById(idTagBase + '_t3701').checked = false;
        //document.getElementById(idTagBase + '_t3699').checked = false;
        document.getElementById(idTagBase + '_t3277').checked = false;
        document.getElementById(idTagBase + '_t3700').click();
        document.getElementById(idTagBase + '_t3700').value = 1;
        //document.getElementById(idTagBase + '_t3701').value = 0;
        //document.getElementById(idTagBase + '_t3699').value = 0;
        document.getElementById(idTagBase + '_t3277').value = 0;
    //} else if (paxCount < 13) {//vehicle 12
    //    document.getElementById(idTagBase + '_t3700').checked = false;
    //    document.getElementById(idTagBase + '_t3701').checked = true;
    //    document.getElementById(idTagBase + '_t3699').checked = false;
    //    document.getElementById(idTagBase + '_t3277').checked = false;
    //    document.getElementById(idTagBase + '_t3701').click();
    //    document.getElementById(idTagBase + '_t3700').value = 0;
    //    document.getElementById(idTagBase + '_t3701').value = 1;
    //    document.getElementById(idTagBase + '_t3699').value = 0;
    //    document.getElementById(idTagBase + '_t3277').value = 0;

    //} else if (paxCount < 15) {//vehicle 14
    //    document.getElementById(idTagBase + '_t3700').checked = false;
    //    document.getElementById(idTagBase + '_t3701').checked = false;
    //    document.getElementById(idTagBase + '_t3699').checked = true;
    //    document.getElementById(idTagBase + '_t3277').checked = false;
    //    document.getElementById(idTagBase + '_t3699').click();
    //    document.getElementById(idTagBase + '_t3700').value = 0;
    //    document.getElementById(idTagBase + '_t3699').value = 0;
    //    document.getElementById(idTagBase + '_t3699').value = 1;
    //    document.getElementById(idTagBase + '_t3277').value = 0;

    } else {//vehicle 24
        document.getElementById(idTagBase + '_t3700').checked = false;
        //document.getElementById(idTagBase + '_t3701').checked = false;
        //document.getElementById(idTagBase + '_t3699').checked = false;
        document.getElementById(idTagBase + '_t3277').checked = true;
        document.getElementById(idTagBase + '_t3277').click();
        document.getElementById(idTagBase + '_t3700').value = 0;
        //document.getElementById(idTagBase + '_t3701').value = 0;
        //document.getElementById(idTagBase + '_t3699').value = 0;
        document.getElementById(idTagBase + '_t3277').value = 1;

    }
}
var accommodation_loadHotels = Accommodation.loadHotels;
var accommodation_setupTransportationRoutes = Accommodation.setupTransportationRoutes;
