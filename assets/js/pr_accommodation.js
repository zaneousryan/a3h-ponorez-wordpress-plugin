var Accommodation = (function () {
  var dataOfActivityById = {};
  var routeDataBySupplierId = {};

  var activityDeferredById = {};
  // Once this is resolved, the corresponding dataOfActivityById and routeDataBySupplierId
  // values are assumed to be set.

  var m;

  var initHotels = function (supplierId, activityId, agencyId, $hotelSelect, routeSelectionContextData) {
    $hotelSelect.empty();

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
    jQuery('#transportationRoutesContainer_a'+activityId).find('div').each(function(){
        jQuery(this).find('label').attr('name',jQuery(this).find('label').text());
    });
    ///////////////////////////////
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
        initHotels(params.supplierId, params.activityId, params.agencyId, $hotelSelect, params.routeSelectionContextData);
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
        console.log('routeElementSelector ', routeElementSelector);

        selectedArray.push(routeElementSelector);
        
        console.log('selectedArray ', selectedArray);
        if (routeElementSelector) {
          jQuery(routeElementSelector).show();
          haveRouteSelection = true;
        }

      });
      

      

      // if (haveRouteSelection) {
        jQuery(contextData.routesContainerSelector).show();
      // }
      var selectedDate = new Date(jQuery('#date_a' + params.activityId).val());
      var selectedMonth = selectedDate.getMonth() + 1;
      selectedMonth = String(selectedMonth);

      var finalSelectedArray = [];
      console.log('before selectedArray ', selectedArray);
      var count=0;
      jQuery.each(selectedArray, function (index, selectedItem) {
        count++;
        // if(jQuery(this).hasClass('no-transport')){
        //   console.log('found no transp');
        // }
        var labelText = jQuery("div[id='" + selectedItem + "']").find('label').attr('name');
        console.log('labelText ', labelText);
        var labelDate, labelMonth, labelMth, labelM;
        if(labelText){
          labelDate = labelText.split('(');
        }
        if(labelDate && labelDate[1]){
          labelMonth = labelDate[1].split(':');
        }
        if(labelMonth && labelMonth[1]){
          labelMth = labelMonth[1].split(')');
        }
        if(labelMth && labelMth[0]){
          labelM = labelMth[0].split(',');
        }
        console.log('labelDate ', labelDate);
        
        console.log('labelMonth ', labelMonth);
        
        console.log('labelMth ', labelMth);
        
        console.log('labelM ', labelM);
        if (jQuery.inArray(selectedMonth, labelM) == -1) {
        } else {
          finalSelectedArray.push(selectedArray[index]);
        }
      });
      var temp = jQuery(contextData.routesContainerSelector).find('div')[0];
      if(count == 0){
        console.log('i am zero');
        
        jQuery(temp).find('input').prop('checked',true);
      }else{

        jQuery(temp).find('input').prop('checked',false);
      }
      // console.log('selected array', selectedArray);
      console.log('final selected array', finalSelectedArray);
      jQuery.each(finalSelectedArray, function (index, finalSelectedItem) {
        var labelText = jQuery("div[id='" + finalSelectedItem + "']").find('label').html();
        labelText = labelText.replace(/\(([^)]+)\)/g, '');
        jQuery("div[id='" + finalSelectedItem + "']").find('label').html(labelText);
      });
      
      finalSelectedArray.push(jQuery(contextData.routesContainerSelector).find('div:first-child').attr('id'));
      
      jQuery(contextData.routesContainerSelector).find('div').each(function () {
        var childId = jQuery(this).attr('id');
        if (jQuery.inArray(childId, finalSelectedArray) == -1) {
          jQuery(this).hide();
        } else {
          jQuery(this).show();
        }
      });
      selectedArray = [];
      finalSelectedArray = [];
    }
  };
  // console.log('m ', m);
  return m;
})();

var accommodation_loadHotels = Accommodation.loadHotels;
var accommodation_setupTransportationRoutes = Accommodation.setupTransportationRoutes;
