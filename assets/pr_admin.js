/*
* Functions for the Admin panel interface.
*/

// Collect checkboxes and group info.
function prAddGroup () {
  // Selecting just the checked boxes and collecting their IDs.
  var idList = jQuery('.pr_activity_id:checked').map(function (i, e) {
    return jQuery(e).attr('pr-activity-id');
  });
  var groupName = jQuery('#pr_group_name').val();

  // Check our inputs.
  if (0 == idList.length) {
    alert('Please select activities first.');
    return;
  }

  if (!groupName) {
    alert('Please enter a group name first.');
    return;
  }

  // Call the AJAX function that adds stuff.
  jQuery.get(ajaxurl,
             { action : 'pr_store_group',
               idlist : idList.toArray(),
               groupname : groupName }, function (event) {
    prUpdateActivityList();
  });
}

// Update the list of activities and groups.
function prUpdateActivityList () {
  var formData = { action : 'pr_activity_list' };

  jQuery.get(ajaxurl, formData, function (result) {
    jQuery('#prActivityTable').html(result);
  });        
}

jQuery(document).ready(function () {
  // Update the activity list right when the document is ready.
  prUpdateActivityList();

    // Bind our group button.
    jQuery(document).on('click', '#pr_add_group', function (event) {
      prAddGroup();
    });

    // Bind our refresh button.
    jQuery(document).on('click', '#pr_refresh', function (event) {
      prUpdateActivityList();
    });
    
});
