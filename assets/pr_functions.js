jQuery(document).ready(function () {
  jQuery(document).on('click', '.checkAvailability', function (event) {
    var activityId = jQuery(this).attr('activity-id');
    var activityDate = jQuery('date_a' + activityId).val();
    
    reservation2(activityId, activityId, activityDate, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

    // Collect guest data from the form.
    jQuery('.guestCount' + activityId).each(function (idx, item) {
      var guestTypeId = item.getAttribute('guest-type-id');
      var guestCount = item.value;

      addGuests(guestTypeId, guestCount);
    });
    
    setUpgradesFixed();
    setHotel(jQuery('#hotel_a' + activityId).val());
    setRoom(jQuery('#room_a' + activityId).val());
    setAccommodationFixed();
    availability_popup();
    
    return false;
  });
});
