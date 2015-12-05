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

        if (0 < (int)$a['id']) {
            $this->setCurrentActivity((int)$a['id']);
        }
        
        $rval = sprintf('Working with activity %d - %s and default template "%s"',
                        $a['id'],
                        $this->_currentActivity->name,
                        $this->defaultTemplate);

        $rval .= sprintf("<br>\n<pre>\n%s\n</pre>",
                         $this->_soapDebug);


        $template_string = file_get_contents($this->defaultTemplate);
        
        return $rval . do_shortcode($template_string);
    }

    public function prDatepickerShortcode ($atts = array(), $content = null, $tag) {
        $a = shortcode_atts(array(
            'id' => null
        ), $atts);

        $rval_template = <<<EOT
<input id="date_aXXXX" onclick="calendar(XXXX, 'date_aXXXX', false);" readOnly size="15"> <a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:calendar(XXXX, 'date_aXXXX', false);"> <img height="22" src="https://www.hawaiifun.org/reservation/company/show-calendar.gif" width="24" border="0"></a>
EOT;

        $rval = str_replace('XXXX', $this->_currentActivity->id, $rval_template);

        return $rval;
    }
    
    public function registerShortcodes() {
        add_shortcode('pr_activity', array($this, 'prActivityShortcode'));
        add_shortcode('pr_datepicker', array($this, 'prDatepickerShortcode'));
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