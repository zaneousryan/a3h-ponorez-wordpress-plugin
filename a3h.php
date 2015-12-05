<?php
/**
 * @package A3H
 */
/*
Plugin Name: A3H PonoRez Reservation Interface for WordPress
Description: 
Version: 0.1
Author: Erik L. Arneson
Author URI: http://www.arnesonium.com/
License: GPLv2 or later

    Copyright 2015 Activities & Attractions Association of Hawaii, Inc.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("No script kiddies please!");

/**
 * For full WSDL/SOAP service documentation, see http://www.ponorez.com/Agency%20Service%20Specifications.pdf
 */

define('PR_PUBLIC_SERVICE_WSDL', 'https://www.hawaiifun.org/reservation_test/services/2012-05-10/PublicService?wsdl');
define('PR_PROVIDER_SERVICE_WSDL', 'https://www.hawaiifun.org/reservation_test/services/2012-05-10/SupplierService?wsdl');
define('PR_WHOLESALER_SERVICE_WSDL', 'https://www.hawaiifun.org/reservation_test/services/2012-05-10/AgencyService?wsdl');

/**
 * Main PonoRez interface class
 *
 * @class PonoRez
 */
final class PonoRez {
    /**
     * @var PonoRez The single instance of the class
     * @since 2.1
     */
    protected static $_instance = null;

    /**
     * @var array Configuration values
     */
    protected $_config = null;


    /**
     * @var SoapClient An instance of the Public Service WSDL
     */
    protected $_publicService = null;

    /**
     * @var SoapClient An instance of the Agency Provider Service WSDL
     */
    protected $_providerService = null;

    /**
     * @var SoapClient An instance of the Activity Wholesaler Service WSDL
     */
    protected $_wholesalerService = null;
    
    public function __construct () {
        // Load private configuration.
        $this->_config = json_decode(file_get_contents(realpath(dirname(__FILE__) . "/private.json")));
    }

    /**
     * @return SoapClient A public service soap client
     * @TODO Check for exceptions.
     */
    public function publicService () {
        if (is_null($this->_publicService)) {
            $this->_publicService = new SoapClient(PR_PUBLIC_SERVICE_WSDL);
        }
        return $this->_publicService;
    }

    /**
     * @return SoapClient An agency provider service soap client
     * @TODO Check for exceptions.
     */
    public function providerService () {
        if (is_null($this->_providerService)) {
            $this->_providerService = new SoapClient(PR_PROVIDER_SERVICE_WSDL);
        }
        return $this->_providerService;
    }

    /**
     * @return SoapClient An activity wholesaler service soap client
     * @TODO Check for exceptions.
     */
    public function wholesalerService () {
        if (is_null($this->_wholesalerService)) {
            $this->_wholesalerService = new SoapClient(PR_WHOLESALER_SERVICE_WSDL);
        }
        return $this->_wholesalerService;
    }

    /**
     * @return SoapVar A ServiceLogin object
     */
    public function serviceLogin () {
        return array("username" => get_option('pr_username'),
                     "password" => get_option('pr_password'));
    }

    public function config () {
        return $this->_config;
    }
    
    /**
     * @return PonoRez - Singleton instance
     * @see PR()
     */
    public static function instance () {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

/**
 * Returns the main instance of the PonoRez object.
 *
 * @return PonoRez
 */
function PR() {
        return PonoRez::instance();
}

/**
 * Bootstrap function for admin pages.
 */
function pr_bootstrap_admin () {
    require_once('lib/class-ponorezadminconfig.php');

    $prc = new PonoRezAdminConfig ();
    $prc->init();
}
add_action('init', 'pr_bootstrap_admin');

/**
 * Bootstrap function for public pages.
 */
function pr_bootstrap_public () {
    require_once('lib/class-ponoreztemplate.php');

    $prt = new PonoRezTemplate ();
    $prt->init();
}
add_action('init', 'pr_bootstrap_public');

/**
 * Shortcode to test login information.
 */
function pr_test_login_sc ($atts = array(), $content = null, $tag)
{
    $pr = PR();
    $psc = $pr->providerService();

    $sl = $pr->serviceLogin();
    $result = $psc->testLogin(array('serviceLogin' => $pr->serviceLogin()));
    
    if (true == $result->return) {
        $rval = "<strong>Login succeeded.</strong>\n";
    }
    else {
        $rval= "<strong>Login failed.</strong>\n";

        $rval .= sprintf("<pre>\n%s</pre>\n",
                         $result->out_status);
    }

    return $rval;
}
add_shortcode('pr_test_login', 'pr_test_login_sc');

// Scratch functions/shortcodes for testing.
function pr_get_categories_sc ($atts = array(), $content = null, $tag)
{
    $pr = PR();
    $psc = $pr->providerService();

    $sl = $pr->serviceLogin();
    
    // Get list of available suppliers.
    $result = $psc->getCategories(array('serviceLogin' => $sl));
    $categories = $result->return;

    $rval = "<ul>\n";

    // Also islandInfos has links and description
    foreach ($categories as $cat) {
        $rval .= sprintf("<li><img src=\"%s\" /> %d - %s</li>\n",
                         $cat->imageUrl,
                         $cat->id,
                         $cat->name);
    }

    $rval .= "</ul>\n";

    return $rval;
}
add_shortcode('pr_get_categories', 'pr_get_categories_sc');

function pr_get_suppliers_sc ($atts = array(), $content = null, $tag)
{
    $pr = PR();
    $psc = $pr->providerService();

    $sl = $pr->serviceLogin();
    
    // Get list of available suppliers.
    $result = $psc->getActivities(array('serviceLogin' => $sl));
    $activities = $result->return;

    $rval = "<ul>\n";

    // Also islandInfos has links and description
    foreach ($activities as $act) {
        $rval .= sprintf("<li>%d - %s on %s</li>\n",
                         $act->id,
                         $act->name,
                         $act->island);
    }

    $rval .= "</ul>\n";

    return $rval;
}
add_shortcode('pr_get_suppliers', 'pr_get_suppliers_sc');

