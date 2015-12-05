<?php
/**
 * Shortcodes for PonoRez templates
 */

final class PonoRezTemplate {
    public $defaultTemplate = 
    
    public function loadScripts () {
        // Note that the "calendar_js.jsp" file includes jQuery with
        // the UI core and datepicker extensions. WordPress provides
        // both of those, so we'll use the built-in. That means we
        // need our own version of calendar_js.jsp that only includes
        // the custom functions. It is included with this plugin.
        wp_enqueue_script('pr_accommodation', 'https://www.hawaiifun.org/reservation/external/accommodation-1.js?jsversion=20151110',
                          array('jquery'), null);
        wp_enqueue_script('pr_calendar', plugins_url('assets/pr_calendar.js', dirname(__FILE__)),
                          array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'pr_accommodation'), null);
        wp_enqueue_script('pr_functions', 'https://www.hawaiifun.org/reservation/external/functions.js?jsversion=20151110',
                          array('jquery', 'pr_calendar'), null);
                          

        // Add calendar-specific stylesheets.
        wp_enqueue_style('pr_lightness_css', 'https://www.hawaiifun.org/reservation/common/jquery/css/ui-lightness-1.10.3.css',
                         false, null);
        wp_enqueue_style('pr_datepicker_css', 'https://www.hawaiifun.org/reservation/common/datepicker_availability.css');
    }

    public function init () {
        $this->loadScripts();
    }
}