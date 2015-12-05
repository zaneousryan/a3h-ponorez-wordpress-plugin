document.writeln('<link href="'+ reservationcalendar_getBaseUrlWithReservation() + 'common/jquery/css/ui-lightness-1.10.3.css'+'" rel="stylesheet" />'
               + '<link href="'+ reservationcalendar_getBaseUrlWithReservation() + 'common/datepicker_availability.css'+'" rel="stylesheet" />');
  // Note: this method of attaching stylesheets will cause them to appear *after*
  // the existing stylesheets and thus override them in certain circumstances.
  // If we ever need our CSS to override jQuery UI styles we need to change
  // the way CSS is injected here: add <link> nodes in DOM, then delete-clone-reinsert
  // existing <link rel="stylesheet"> nodes so that they appear after jQuery UI
  // link nodes. (Just inserting the new nodes before existing ones won't work
  // in IE, even in IE9.)

function reservationcalendar_getBaseUrlWithReservation()
{
  var url = 'https://www.hawaiifun.org/reservation/';
  if (/reservation\/$/.test(url) || /reservation_test\/$/.test(url) || /reservation-alt\/$/.test(url))
  {
    // Leave as is.
  }
  else if (/perfecthawaiivacationguide.com$/.test(window.location.hostname) || /^(\w+\.)*hawaiifun\.org$/.test(window.location.hostname) || /^(\w+\.)*hawaiifunfusion\.com/.test(window.location.hostname))
  {
    url = 'https://www.hawaiifun.org/reservation/';
  }
  else
  {
    url += 'reservation/';
  }

  return url;
}

(function($) {

  var reservationcalendar_availability = [];
  var reservationcalendar_datepickerPanel = null;

  window.calendar = function(activityId, field, local, minavailability, numberOfMonths) {
    showAvailabilityCalendar2(activityId, field, { local: local, webBooking: true, minavailability: minavailability, numberOfMonths: numberOfMonths });
  };

  window.showSimpleCalendar = function(fieldId, anchorId, options) {
    var $field = $('#' + fieldId);
    var $anchor = (anchorId ? $('#' + anchorId) : $field);

    if ($field.length == 0) return;
    if ($anchor.length == 0) $anchor = $field;

    var $panel = reservationcalendar_createDatepickerPanel($anchor);

    var calendarOptions = {
      showOn: 'none',
      showAnim: ''
    };
    if (typeof options != 'undefined')
    {
      $.extend(calendarOptions, options)
    }
    $panel.datepicker(calendarOptions);

    // Add class for compatibility with the old (modified) availability datepicker.
    $panel.find(".ui-datepicker").addClass('ui-datepicker_availability');

    var initialDateSeconds = Date.parse($field.val());
    $panel.datepicker('setDate', initialDateSeconds ? new Date(initialDateSeconds) : null);

    reservationcalendar_placePanelNearAnchor($panel, $anchor);
    reservationcalendar_connectDatepickerToField($panel, $field);
    $panel.css({ visibility: 'inherit' });

    reservationcalendar_datepickerPanel = $panel.get(0);
  };

  // Replaced by showAvailabilityCalendar2 but is used in old external/agencyexternal code.
  window.showAvailabilityCalendar = function(activityId, agencyId, fieldId, anchorId, local) {
    if (local == null) local = true;
    if (!/^\d+$/.test(activityId) || !activityId)
    {
      alert('Please select activity');
      return;
    }

    showAvailabilityCalendar2(activityId, fieldId, { agencyId: agencyId, anchorId: anchorId, local: local });
  };

  window.showAvailabilityCalendar2 = function(activityId, fieldId, options) {
    var agencyId = (options['agencyId'] != null ? options['agencyId'] : 0);
    var blocksOnly = (options['blocksOnly'] != null ? options['blocksOnly'] : false);
    var anchorId = (options['anchorId'] != null ? options['anchorId'] : null);
    var local = (options['local'] != null ? options['local'] : false);
    var webBooking = (options['webBooking'] != null ? options['webBooking'] : true);
    var hawaiifunBooking = (options['hawaiifunBooking'] != null ? options['hawaiifunBooking'] : false);
    var agencyBooking = (options['agencyBooking'] != null ? options['agencyBooking'] : false);
    var minAvailability = (options['minavailability'] != null ? options['minavailability'] : undefined);
    var numberOfMonths = (options['numberOfMonths'] != null ? options['numberOfMonths'] : undefined);

    var activityIdArray = $.makeArray(activityId);
    var haveBadActivityId = $.grep(activityIdArray, function(i) { return !/^\d+$/.test(i) || !i }).length;
    if (activityIdArray.length == 0 || haveBadActivityId)
    {
      alert('Please select activity');
      return;
    }

    var baseurl = (local ? "" : reservationcalendar_getBaseUrlWithReservation());
    var $field = $('#' + fieldId);
    var $anchor = (anchorId ? $('#' + anchorId) : $field);
    var minAvailabilityStr = typeof(minAvailability) == 'undefined' ? '' : JSON.stringify(minAvailability);
    var activityIdStr = $.makeArray(activityId).join('|');

    if ($field.length == 0) return;

    if ($anchor.length == 0) $anchor = $field;
    if (typeof(numberOfMonths) == 'undefined') numberOfMonths = 1;

    var $panel = reservationcalendar_createDatepickerPanel($anchor);
    $panel.datepicker_async({
      numberOfMonths: typeof(numberOfMonths) == 'undefined' ? 1 : numberOfMonths,
      onPrepareMonthBegin: function (year, month, inst) {
        var yms = [];
        for (var i = 0, y = year, m = month; i < numberOfMonths; ++i, ++m)
        {
          if (m > 12)
          {
            m -= 12;
            y++;
          }

          if (!(activityIdStr + '_' + agencyId + '_' + y + '_' + m + '_' + minAvailabilityStr in reservationcalendar_availability))
          {
            yms.push(y + '_' + m);
          }
        }

        if (yms.length == 0)
        {
          return null; // All months are already loaded, no need for asynchronous handling.
        }

        var deferred = $.Deferred();

        $.ajax({
          type: 'GET',
          url: baseurl + 'companyservlet',
          dataType: 'jsonp',
          data: {
            action: 'COMMON_AVAILABILITYCHECKJSON',
            activityid: activityIdStr,
            agencyid: agencyId,
            blocksonly: blocksOnly,
            year_months: yms.join('|'),
            webbooking: webBooking,
            hawaiifunbooking: hawaiifunBooking,
            agencybooking: agencyBooking,
            minavailability: minAvailabilityStr
          }
        })
          .done(function(data) {
            for (i = 0; i < yms.length; i++)
            {
              reservationcalendar_availability[activityIdStr + '_' + agencyId + '_' + yms[i] + '_' + minAvailabilityStr] = data['yearmonth_' + yms[i]];
            }
            deferred.resolve();
          })
          .fail(function(xhr, textStatus, errorThrown) {
            alert(baseurl + ' ' + textStatus + ' ' + errorThrown);
            deferred.reject();
          });

        return deferred.promise();
      },
      beforeShowDay: function(date) {
        var m = date.getMonth() + 1;
        var d = date.getDate();
        var y = date.getFullYear();

        var idx = activityIdStr + '_' + agencyId + '_' + y + '_' + m + '_' + minAvailabilityStr;

        if (!(idx in reservationcalendar_availability) || !('d' + d in reservationcalendar_availability[idx]))
        {
          return [false];
        }
        else if (reservationcalendar_availability[idx]['d' + d] <= 0)
        {
          return [false, 'un', 'Not Available'];
        }
        else
        {
          return [true];
        }
      }
    });

    // Add class for compatibility with the old (modified) availability datepicker.
    $panel.find(".ui-datepicker").addClass('ui-datepicker_availability');

    var initialDateSeconds = Date.parse($field.val());
    $panel.datepicker('setDate', initialDateSeconds ? new Date(initialDateSeconds) : null);

    reservationcalendar_placePanelNearAnchor($panel, $anchor);
    reservationcalendar_connectDatepickerToField($panel, $field);
    $panel.css({ visibility: 'inherit' });

    reservationcalendar_datepickerPanel = $panel.get(0);
  };

  window.reservationcalendar_createDatepickerPanel = function($anchor) {
    if (reservationcalendar_datepickerPanel)
    {
      var $oldPanel = $(reservationcalendar_datepickerPanel);
      if ($oldPanel.data('datepicker'))
      {
        $oldPanel.datepicker('destroy');
        $oldPanel.remove();
      }
      reservationcalendar_datepickerPanel = null;
    }

    var isFixed = false;
    $anchor.parents().each(function() {
      isFixed |= $(this).css("position") === "fixed";
      return !isFixed;
    });

    return $("<div></div>")
      .css({
        paddingTop: '1px', paddingBottom: '1px',
        position: isFixed ? 'fixed' : 'absolute', visibility: 'hidden',
        zIndex: $anchor.zIndex() // zIndex() is from jquery-ui core
      })
      .appendTo($anchor.closest("body"));
  };

  window.reservationcalendar_placePanelNearAnchor = function($panel, $anchor) {
    $panel.css({ left: 0, top: 0 });

    var originalPanelPosition = $panel.offset();
    var panelSize = { width: $panel.outerWidth(), height: $panel.outerHeight() };
    var anchorPosition = $anchor.offset();
    var anchorSize = { width: $anchor.outerWidth(false), height: $anchor.outerHeight(false) };

    var $document = $($panel.get(0).ownerDocument);
    var $window = $(reservationcalendar_getElementWindow($panel));
    var viewDimensions = {
      left: $document.scrollLeft(), top: $document.scrollTop(),
      width: $window.width(), height: $window.height()
    };

    // Fit position vertically.
    var primaryPanelPosition = { left: anchorPosition.left, top: anchorPosition.top + anchorSize.height };
    var altPanelPosition = { left: anchorPosition.left, top: anchorPosition.top - panelSize.height };

    var primaryVerticallyVisible = reservationcalendar_checkVerticalVisibility(primaryPanelPosition, panelSize, viewDimensions);
    var altVerticallyVisible = reservationcalendar_checkVerticalVisibility(altPanelPosition, panelSize, viewDimensions);
    var selectedPanelPosition = (!primaryVerticallyVisible && altVerticallyVisible ? altPanelPosition : primaryPanelPosition);

    // Adjust position horizontally.
    if (selectedPanelPosition.left + panelSize.width > viewDimensions.left + viewDimensions.width)
    {
      selectedPanelPosition.left = Math.max(
        viewDimensions.left,
        viewDimensions.left + viewDimensions.width - panelSize.width);
    }

    $panel.css({
      left: (selectedPanelPosition.left - originalPanelPosition.left) + 'px',
      top: (selectedPanelPosition.top - originalPanelPosition.top) + 'px'
    });
  };

  window.reservationcalendar_connectDatepickerToField = function($panel, $field) {
    var setupTimeout = null;
    var lastInputValue = null;

    var destroyDatepicker = function() {
      if (setupTimeout) clearTimeout(setupTimeout);

      $field.off('input', onFieldChange);
      $field.off('onpropertychange', onFieldChange);
      $field.off('keyup', onFieldChange);

      $panel.off('click', onPanelClick);
      $panel.closest("html").off('click', onDocumentClick);

      $panel.datepicker('destroy');
      $panel.remove();
    };

    var onFieldChange = function(ev) {
      var inputValue = $field.val();
      if (inputValue === lastInputValue) return;

      var dateSeconds = Date.parse(inputValue);
      $panel.datepicker('setDate', dateSeconds ? new Date(dateSeconds) : null);
      lastInputValue = inputValue;
    };
    var onDocumentClick = function(ev) {
      destroyDatepicker();
    };
    var onPanelClick = function(ev) {
      ev.stopPropagation();
    };

    $panel.datepicker('option', 'onSelect', function(dateText, inst) {
      $field.val(dateText);
      $field.change();
      destroyDatepicker();
    });

    // Bind events that are fired when input is changed in various browsers:
    $field.on('input', onFieldChange);
    $field.on('onpropertychange', onFieldChange);
    $field.on('keyup', onFieldChange);

    setupTimeout = setTimeout(function() {
      // We set up click handlers asynchronously to prevent onDocumentClick from
      // being called immediately when bubbling click event, *if* we are creating
      // a datepicker in response to this very event.
      $panel.on('click', onPanelClick);
      $panel.closest("html").on('click', onDocumentClick);
    }, 0);
  };

  window.reservationcalendar_getElementWindow = function($element) {
    var doc = $element.get(0).ownerDocument;
    return doc.defaultView || doc.parentWindow;
  };

  window.reservationcalendar_checkVerticalVisibility = function(panelPosition, panelSize, viewDimensions) {
    return (panelPosition.top >= viewDimensions.top
            && panelPosition.top + panelSize.height <= viewDimensions.top + viewDimensions.height);
  };

})(jQuery);
