<?php
/**
 * Shortcodes for PonoRez templates
 */

final class PonoRezTemplate {
    public $defaultTemplate;

    protected $_currentActivity;

    protected $_soapDebug = null;
    
    public function setCurrentActivity ($activityId) {
        $psc = PR()->providerService();
        $serviceCreds = PR()->serviceLogin();

        $result = $psc->getActivity(array('serviceLogin' => $serviceCreds,
                                          'activityId' => $activityId));

        $this->_soapDebug = print_r($result, true);
        
        $this->_currentActivity = $result->return;
    }

    public function prActivityShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);
        $rval = '';

        try {
            if (0 < (int)$a['id']) {
                $this->setCurrentActivity((int)$a['id']);
            }
        }
        catch (SoapFault $e) {
            $rval .= sprintf("<br>\n<pre>\n%s\n</pre>",
                             $this->_soapDebug);

        }

        $template_string = file_get_contents($this->defaultTemplate);
        
        return $rval . do_shortcode($template_string);
    }

    public function prActivityNameShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        return $this->_currentActivity->name;
    }

    public function prActivityDescriptionShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        return $this->_currentActivity->description;
    }
    
    public function prDatepickerShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        $rval_template = <<<EOT
<input id="date_aXXXX" onclick="calendar(XXXX, 'date_aXXXX', false);" readOnly size="15"> <a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:calendar(XXXX, 'date_aXXXX', false);"><img class="activityDatePicker" height="22" src="https://www.hawaiifun.org/reservation/company/show-calendar.gif" width="24" border="0"></a>
EOT;

        $rval = str_replace('XXXX', $this->_currentActivity->id, $rval_template);

        return $rval;
    }

    public function prGuestTypeListShortcode($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        try {
            $psc = PR()->providerService();
            $serviceCreds = PR()->serviceLogin();

            $result = $psc->getActivityGuestTypes(array('serviceLogin' => $serviceCreds,
                                                        'activityId' => $this->_currentActivity->id,
                                                        'supplierId' => $this->_currentActivity->supplierId,
                                                        'date' => new SoapVar(date('YYYY-MM-DD'), XSD_DATE)));
        }
        catch (SoapFault $e) {
            $rval = sprintf("<h3>[SOAP FAULT] Could not load guest types</h3>\n<pre>\n%s\n---\n%s\n</pre>\n",
                            $e->faultcode,
                            $e->faultstring);

            return $rval;
        }
        
        $rval = '';
        foreach ($result->return as $guestType) {
            $html = sprintf("%s <select id='guests_a%d_t%d'>",
                            $guestType->name,
                            $this->_currentActivity->id,
                            $guestType->id);

            $html .= "</select>";
            $rval .= "\n\n$html";
        }

        $this->_soapDebug = print_r($result, true);

        return $rval;
    }

    // @TODO For this to be done automatically, we might need to configure it in the DB.
    public function prGuestTypeShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null,
            'guest-type-id' => null,
            'max' => 20
        ), $atts);

        $rval = sprintf('<select class="guestCount%d" guest-type-id="%d" id="guests_a%d_t%d">',
                        $this->_currentActivity->id,
                        $a['guest-type-id'],
                        $this->_currentActivity->id,
                        $a['guest-type-id']);

        for ($i = 0; $i <= $a['max']; $i++) {
            $rval .= sprintf("<option value='%d'>%d</option>", $i, $i);
        }

        $rval .= "</select>\n";

        return $rval;
    }
    
    public function prHotelSelectShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        $rval_template = <<<EOT
<select id="hotel_aAAAA" ></select>
<script type="text/javascript">accommodation_loadHotels({ supplierId: SSSS, activityId:  AAAA, agencyId: 0, hotelSelectSelector: "#hotel_aAAAA" });</script>
EOT;

        $rval = str_replace(array('AAAA', 'SSSS'),
                            array($this->_currentActivity->id,
                                  $this->_currentActivity->supplierId),
                            $rval_template);

        return $rval;
    }

    public function prHotelRoomShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        $rval = sprintf('<input type="text" id="room_a%d" size="3" />',
                        $this->_currentActivity->id);
        
        return $rval;
    }
    
    // @TODO How do we get the guest types for this?
    public function prCheckAvailabilityShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        $rval = sprintf('<input type="button" class="checkAvailability" activity-id="%d" value="Check availability" />',
                        $this->_currentActivity->id);
        
        return $rval;
    }

    public function registerShortcodes() {
        add_shortcode('pr_activity', array($this, 'prActivityShortcode'));
        add_shortcode('pr_activity_name', array($this, 'prActivityNameShortcode'));
        add_shortcode('pr_activity_description', array($this, 'prActivityDescriptionShortcode'));
        add_shortcode('pr_datepicker', array($this, 'prDatepickerShortcode'));
        add_shortcode('pr_guest_type_list', array($this, 'prGuestTypeListShortcode'));
        add_shortcode('pr_guest_type', array($this, 'prGuestTypeShortcode'));
        add_shortcode('pr_hotel_select', array($this, 'prHotelSelectShortcode'));
        add_shortcode('pr_hotel_room', array($this, 'prHotelRoomShortcode'));
        add_shortcode('pr_check_availability', array($this, 'prCheckAvailabilityShortcode'));
    }
    
    public function loadScripts () {
        // Note that the "calendar_js.jsp" file includes jQuery with
        // the UI core and datepicker extensions. WordPress provides
        // both of those, so we'll use the built-in. That means we
        // need our own version of calendar_js.jsp that only includes
        // the custom functions. It is included with this plugin.
        wp_enqueue_script('pr_accommodation', plugins_url('assets/pr_accommodation.js', dirname(__FILE__)),
                          array('jquery'));
        wp_enqueue_script('pr_calendar', plugins_url('assets/pr_calendar.js', dirname(__FILE__)),
                          array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'pr_accommodation'));
        wp_enqueue_script('pr_functions', 'https://www.hawaiifun.org/reservation/external/functions.js?jsversion=20151110',
                          array('jquery', 'pr_calendar'), null);
        wp_enqueue_script('pr_functions_extra', plugins_url('assets/pr_functions.js', dirname(__FILE__)),
                          array('jquery', 'pr_functions'));

        // Add calendar-specific stylesheets.
        wp_enqueue_style('pr_lightness_css', 'https://www.hawaiifun.org/reservation/common/jquery/css/ui-lightness-1.10.3.css',
                         false, null);
        wp_enqueue_style('pr_datepicker_css', 'https://www.hawaiifun.org/reservation/common/datepicker_availability.css');
    }

    public function init () {
        $this->loadScripts();
        $this->registerShortcodes();

        $this->defaultTemplate = realpath(dirname(__FILE__) . '/../') . '/templates/activity-default.html';
    }
}