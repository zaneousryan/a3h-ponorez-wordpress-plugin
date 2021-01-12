<?php
/**
 * @package A3H
 */
/*
Plugin Name: PonoRez Booking System
Description: Add PonoRez booking forms to your website through shortcodes.
Version: 3.6.3
Author: PonoRez
Author URI: http://www.ponorez.com
License: GPLv2 or later

    Copyright 2015-19 Activities & Attractions Association of Hawaii, Inc.

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

defined( 'ABSPATH' )or die( "No script kiddies please!" );

//For full WSDL/SOAP service documentation, see http://www.ponorez.com/Agency%20Service%20Specifications.pdf
define( 'PR_PUBLIC_SERVICE_WSDL', 'https://www.hawaiifun.org/reservation/services/2012-05-10/PublicService?wsdl' );
define( 'PR_PROVIDER_SERVICE_WSDL', 'https://www.hawaiifun.org/reservation/services/2012-05-10/SupplierService?wsdl' );
define( 'PR_WHOLESALER_SERVICE_WSDL', 'https://www.hawaiifun.org/reservation/services/2012-05-10/AgencyService?wsdl' );

/**
 * Main Pono Rez interface class
 *
 * @class PonoRez
 */
final class PonoRez {
	
	/**
	 * @var PonoRez single instance of this class
	 */
	protected static $_instance = null;

	/**
	 * @var SoapClient instance of the Public Service WSDL
	 */
	protected $_publicService = null;

	/**
	 * @var SoapClient instance of the Supplier Provider Service WSDL
	 */
	protected $_providerService = null;

	/**
	 * @var SoapClient instance of the Agency Service WSDL
	 */
	protected $_wholesalerService = null;

	/**
	 * @return SoapClient 
	 */
	public function publicService() {
		
		if ( is_null( $this->_publicService ) ) {
			
			$this->_publicService = new SoapClient( PR_PUBLIC_SERVICE_WSDL );
		}
		
		return $this->_publicService;
		
	}

	/**
	 * @return SoapClient Supplier provider service soap client
	 */
	public function providerService() {
		
		if ( is_null( $this->_providerService ) ) {
			
			$this->_providerService = new SoapClient( PR_PROVIDER_SERVICE_WSDL );
			
		}
		
		return $this->_providerService;
		
	}

	/**
	 * @return SoapClient Agency service soap client
	 */
	public function wholesalerService() {
		
		if ( is_null( $this->_wholesalerService ) ) {
			
			$this->_wholesalerService = new SoapClient( PR_WHOLESALER_SERVICE_WSDL );
			
		}
		
		return $this->_wholesalerService;
		
	}

	/**
	 * @return SoapVar ServiceLogin object
	 */
	public function serviceLogin() {
		
		return array( "username" => get_option( 'pr_username' ), "password" => get_option( 'pr_password' ) );
		
	}

	/**
	 * @return PonoRez Singleton instance
	 * @see PR()
	 */
	public static function instance() {
		
		if ( is_null( self::$_instance ) ) {
			
			self::$_instance = new self();
			
		}
		
		return self::$_instance;
		
	}

	protected function _transientTag( $scName, $id ) {
		
		$nonAlnum = array( '.', '/', '-', '_', ' ' );

		return join( '_', array( 'pr', str_replace( $nonAlnum, '', $scName ), str_replace( $nonAlnum, '', $id ) ) );
		
	}

	/**
	 * Cache the output of a function as a transient.
	 *
	 * @param string $scName The name of the shortcode calling the function.
	 * @param string $tag A variable tag used to store the transient.
	 * @param function $f The anonymous function whose output will be cached.
	 */
	public function withTransient( $scName, $tag, $f ) {
		
		$transientTag = $this->_transientTag( $scName, $tag );
		$timeout = get_option( 'pr_cache_timeout' );
		$rval = false;

		if ( !$timeout && 0 != $timeout ) {
			
			$timeout = 3600;
			set_option( 'pr_cache_timeout', $timeout );
			
		}

		// Disable cache when $timeout is set to 0.
		if ( 0 > $timeout ) {
			
			$rval = get_transient( $transientTag );
			
		}

		if ( false === $rval ) {
			
			// Catch exceptions
			try {
				
				$rval = $f();
				
			} catch ( SoapFault $e ) {
				
				printf( "<br>\n<pre>\n%s\n</pre>", $e->getMessage() );
				
			}

			if ( 0 != $timeout ) {
				
				set_transient( $transientTag, $rval, $timeout );
				
			}
			
		}

		return $rval;
		
	}

}

/**
 * Returns main instance of PonoRez object.
 *
 * @return PonoRez
 */
function PR() {
	
	return PonoRez::instance();
	
}

/**
 * Look at an array of arrays for a value.
 */
function pr_key_in_array( $value, $array ) {
	
	if ( !$array ) return false;

	foreach ( $array as $k => $v ) {
		
		if ( in_array( $value, $v ) ) {
			
			return $k;
			
		}
		
	}
	
	return false;
	
}

/**
 * Bootstrap function for admin pages.
 */
function pr_bootstrap_admin() {
	
	require_once( 'includes/class-ponorez-admin-config.php' );
	require_once( 'includes/class-ponorez-activities-list.php' );

	$prc = new PonoRezAdminConfig();
	$prc->init();
	
}
add_action( 'init', 'pr_bootstrap_admin' );

/**
 * Bootstrap function for public pages.
 */
function pr_bootstrap_public() {
	
	// require_once('includes/class-ponorez-rest.php');
	require_once( 'includes/class-ponorez-transportation.php' );
	require_once( 'includes/class-ponorez-group.php' );
	require_once( 'includes/class-ponorez-template.php' );

	$prt = new PonoRezTemplate();
	$prt->init();
	
}
add_action( 'init', 'pr_bootstrap_public' );

/**
 * Shortcode to test login information.
 */
function pr_test_login_sc( $atts = array(), $content = null, $tag ) {
		
	$pr = PR();
	$psc = $pr->providerService();
	$sl = $pr->serviceLogin();
	$result = $psc->testLogin( array( 'serviceLogin' => $pr->serviceLogin() ) );

	if ( true == $result->return ) {
		
		$rval = "<strong>Login succeeded.</strong>\n";
		
	} else {
		
		$rval = "<strong>Login failed.</strong>\n";
		$rval .= sprintf( "<pre>\n%s</pre>\n", $result->out_status );
		
	}

	return $rval;
}

add_shortcode( 'pr_test_login', 'pr_test_login_sc' );

function ponorezLoginTest( $atts = array(), $content = null, $tag ) {
	
	$pr = PR();
	$psc = $pr->providerService();
	$sl = $pr->serviceLogin();
	$result = $psc->testLogin( array( 'serviceLogin' => $pr->serviceLogin() ) );

	if ( true == $result->return ) {
		
		$rval = '<div style="margin: 0 20px 20px 0;" class="notice notice-success is-dismissible"><p><strong>You have successfully connected to your PonoRez account.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		
	} else {
		
		$rval = '<div style="margin: 0 20px 20px 0;" class="notice notice-error is-dismissible"><p><strong>Login failed. Please check your PonoRez account credetials!</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		
	}

	return $rval;
}

add_shortcode( 'PonorezLoginTest', 'ponorezLoginTest' );

function ponorezActivitiesLoader( $atts = array(), $content = null, $tag ) {
	
	$pr = PR();
	$psc = $pr->providerService();
	$sl = $pr->serviceLogin();
	$result = $psc->testLogin( array( 'serviceLogin' => $pr->serviceLogin() ) );

	if ( true == $result->return ) {
		
		$rval = '<div id="prActivityTable"><h3 style="color: #0085ba;">Retrieving activities list from PonoRez. Please wait...</h3></div>';
		
	} else {
		
		$rval = '<div id="prActivityTable"><h3 style="color: #ff0000;">Login failed. Please check your PonoRez account credetials!</h3></div>';
		
	}

	return $rval;
}

add_shortcode( 'PonorezActivitiesLoader', 'ponorezActivitiesLoader' );

// Enable Plugin Auto-Update Functionality
require 'vendors/plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'http://ponorez.com/plugin-updater/?action=get_metadata&slug=ponorez-booking-system-for-wordpress-plugin',
	__FILE__, 
	'ponorez-booking-system-for-wordpress-plugin'
);

// End a3h.php

function fixed_date_booking($attr) {
		
		global $content;
	    ob_start();
	    // echo `abc`;
		// print_r( '<form>
		// 	    &nbsp;
		// 	    Passenger <input type="text" id="guests_a13234_t3684" value="0" size="2">
  // 				<p></p><input type="checkbox" id="cancellationpolicy_a13234"><label for="cancellationpolicy_a13234">Cancellation Policy: If you find it necessary to cancel your reservation for whatever reason, call our office ASAP so we can get to work filling your spot.  All cancellations must be in writing, signed, and dated and can be faxed.  Emails will not be accepted.  All refunds are subject to a 10% administration fee.

		// 		Trips 1 1/2 days to 5 days: Payment is non-refundable unless cancellation is received 90 days before the departure date.  Cancellation received within 90 days to the departure date is subject to payment forfeiture unless the vacated spot is rebooked.

		// 		â€‹Trips 6 days and longer: Payment is non-refundable unless cancellation is received 180 days before the departure date.  Cancellation received within 180 days before the departure date is subject to payment forfeiture unless the vacated spot is rebooked.</label><p></p>');


  		// echo '<input type="button" value="Check availability" onclick="if (!checkcancellation(';
  		// echo "document.getElementById('cancellationpolicy_a13234'))) return false;";
  		// echo " reservation2('13234', 13234, '01/17 
  		// echo " addGuests(3684, document.getElementById('guests_a13234_t3684').value); ";
  		// echo 'setUpgradesFixed(); setAccommodationFixed();  availability_popup(); return false;">';
	    // echo "<pre>";
	    // print_r($attr);
	    // echo "</pre>";
	    // die();
	    
  		?>
  		<form>
			Passenger 
			<input id="guests_a13234_t3684" size="2" type="text" value="0" /><br>
			<input id="cancellationpolicy_a13234" type="checkbox" />
			<label for="cancellationpolicy_a13234">Cancellation Policy: If you find it necessary to cancel your reservation for whatever reason, call our office ASAP so we can get to work filling your spot. All cancellations must be in writing, signed, and dated and can be faxed. Emails will not be accepted. All refunds are subject to a 10% administration fee. 
			</label>

			Trips 1 1/2 days to 5 days: Payment is non-refundable unless cancellation is received 90 days before the departure date. Cancellation received within 90 days to the departure date is subject to payment forfeiture unless the vacated spot is rebooked.

			â€‹Trips 6 days and longer: Payment is non-refundable unless cancellation is received 180 days before the departure date. Cancellation received within 180 days before the departure date is subject to payment forfeiture unless the vacated spot is rebooked.
  			<br>
  			<input type="button" value="Check availability" onclick="if (!checkcancellation(document.getElementById('cancellationpolicy_a13234'))) return false;reservation2('<?php echo $attr['id'];?>', <?php echo $attr['id'];?>, '<?php echo $attr['date'];?>', '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);addGuests(<?php echo $attr['guests'];?>, document.getElementById('guests_a13234_t3684').value);setUpgradesFixed(); 
  				<?php if ($attr['accommodation'] == 'fixed'){echo 'setAccommodationFixed();';}?>
  				availability_popup(); return false;">
		</form>
  		<?php

		// echo	'</form>';
		
		$output = ob_get_clean();
    	return $output;
	}

add_shortcode( 'Fixed_Date_Booking', 'fixed_date_booking' );
// add_action( 'init', 'process_post' );
 
// function process_post() {
//     die();
// }