<?php
/**
 * Shortcodes for PonoRez templates
 */

final class PonoRezTemplate {
	
	public $defaultTemplate;
	protected $_currentActivity = null;
	protected $_currentActivityGroup = null;
	protected $_soapDebug = null;
	protected $_cancellationPolicyCount = 0;

	// Set current activity by ID
	public function setCurrentActivity( $activityId ) {
		
		$psc = PR()->providerService();
		$serviceCreds = PR()->serviceLogin();

		$result = $psc->getActivity( array( 'serviceLogin' => $serviceCreds, 'activityId' => $activityId ) );

		$this->_soapDebug = print_r( $result, true );

		$this->_currentActivity = $result->return;
		
	}
	
	// Load current activity
	public function loadPonorezActivity ( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 'id' => null ), $atts );
		$rval = '';

		try { if ( 0 < ( int )$a[ 'id' ] ) {
			
				$this->setCurrentActivity( ( int )$a[ 'id' ] );
			
			}
			 
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		return $rval;
		
	}
	
	//Load booking form template
	public function ponorezActivityBooking( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "00";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}
		
		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/inline.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/overlay.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}
	
	public function ponorezActivityBooking01( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$activityModelId = $id . "_01";
		$overlayId = "01";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			// echo 'x1x';
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			// echo 'x0x';
			set_query_var('fix_guest', 0);
		}


		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-01.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-01.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}
	
	public function ponorezActivityBooking02( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "02";
		$activityModelId = $id . "_02"; 
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}


		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}


		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-02.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-02.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking03( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "03";
		$activityModelId = $id . "_03";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}


		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}


		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-03.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-03.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking04( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "04";
		$activityModelId = $id . "_04";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']); 
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-04.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-04.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking05( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "05";
		$activityModelId = $id . "_05";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-05.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-05.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking06( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "06";
		$activityModelId = $id . "_06";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-06.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-06.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}
	
	public function ponorezActivityBooking07( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "07";
		$activityModelId = $id . "_07";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-07.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-07.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}
	
	public function ponorezActivityBooking08( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "08";
		$activityModelId = $id . "_08";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-08.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-08.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking09( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "09";
		$activityModelId = $id . "_09";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-09.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-09.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking10( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "10";
		$activityModelId = $id . "_10";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-10.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-10.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking11( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "11";
		$activityModelId = $id . "_11";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-11.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-11.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking12( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "12";
		$activityModelId = $id . "_12";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-12.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-12.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking13( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "13";
		$activityModelId = $id . "_13";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-13.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-13.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}

	public function ponorezActivityBooking14( $atts = array(), $content = null, $tag ) { 
	
		extract(shortcode_atts(array(
			'id' => null,
			'guests' => null,
			'upgrades' => null,
			'privateid' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts));

		$myActivityID = $id;
		$overlayId = "14";
		$activityModelId = $id . "_14";
		$formTitle = $title;
		$bookNowText = get_option('bookNowText');
		$accommodationType = $accommodation;
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $promocode;
		$guestTypes = array($guests);
		$guestTypes = explode(',', $guests);
		$upgradeTypes = array($upgrades);
		$upgradeTypes = explode(',', $upgrades);
		$privateGuests = array($privateid);
		$privateGuests = explode(',', $privateid);
		$promotionalCodesStatus = $allowdiscounts;

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		if($atts['date']){
			set_query_var('date', $atts['date']);
		}

		if($atts['fixed_guest']){
			set_query_var('fix_guest', $atts['fixed_guest']);
		}
		else{
			set_query_var('fix_guest', 0);
		}

		$defaultActivityTemplate = get_option( 'pr_default_template' );
		
		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/inline-14.php' );

			$output = ob_get_clean();
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-single/sub/overlay-14.php' );

			$output = ob_get_clean();	

		} 
		
    	return $output;		
		
	}
	
	//Load Activity Name
    public function ponorezActivityName ($atts = array(), $content = null, $tag) {
		
        $a = shortcode_atts(array( 'id' => null ), $atts);

        if (isset($this->_currentActivity))
			
            return $this->_currentActivity->name;

        return '';
    }
	
	// Load datepicker field
	public function ponorezDatePicker ( $atts = array(), $content = null, $tag ) {
		
        $a = shortcode_atts(array( 'id' => null, 'group' => 'on', 'icon' => 'on' ), $atts);

		// No activity selected error message
		if (!$this->_currentActivity && !$this->_currentActivityGroup)
            return 'No activity selected';

		// Single activity datepicker template.
		if ( 'off' === $a[ 'group' ] || null === $this->_currentActivityGroup ) {

			//DO NOTHING
			//Date Picker is in single activity template files
			
		} else {
			
			// Activities group datepicker template.
			$rval_template = <<<EOT
				<div class="form-row date-selector"> <input class="form-control" id="XXXX" onclick="showCalendar(GGGG);" onchange="showPriceAndAvailability(GGGG,true);" readOnly size="18"> <a style="text-decoration: none;" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(GGGG);" style="vertical-align: middle;">
EOT;
			
			$rval = str_replace( 'XXXX', $this->_currentActivityGroup->dateControlId(), $rval_template );
			$rval = str_replace( 'GGGG', 'g_' . $this->_currentActivityGroup->groupName, $rval );
			
		}

		// Include calendar icon
		if ( 'on' === $a[ 'icon' ] ) {
			
			$rval .= sprintf( '<i class="fa fa-calendar" aria-hidden="true"></i>' );
			
		}

		return $rval . '</a></div>';
		
	}

	// Load guest type fields
	public function loadPonorezActivityGuestField ( $atts = array() ) {
		
		$a = shortcode_atts( array( 'id' => 0, 'modalid' => '', 'name' => '', 'min' => 0, 'max' => 20 ), $atts );
		$html = '';

		if($a[ 'modalid' ] == ''){
			$htmlIdTagPart = sprintf( 'a%d', $this->_currentActivity->id );
		}
		else {
			$htmlIdTagPart = sprintf( 'a%s', $a[ 'modalid' ]);
		}

		if ( null != $this->_currentActivityGroup ) {
			
			$htmlIdTagPart = $this->_currentActivityGroup->groupName;
			
		}
		if ( $a[ 'max' ] == 1 ) {

			if ( null != $this->_currentActivityGroup ) {
				$html = sprintf( '<div class="form-row"><label><input type="checkbox" name="guestCheckbox" id="guests_%s_t%d" value="0" onchange="showPriceAndAvailability(GGGG,true);"/> %s</label>',

					$htmlIdTagPart,
					$a[ 'id' ],
					$a[ 'name' ] );
			}else{
				$html = sprintf( '<div class="form-row"><label><input type="checkbox" name="guestCheckbox" id="guests_%s_t%d" value="0"/> %s</label>',

					$htmlIdTagPart,
					$a[ 'id' ],
					$a[ 'name' ] );
			};
					
			$html .= sprintf( '<script>jQuery(\'#guests_%s_t%d\').on(\'click\', function () { jQuery(this).val(this.checked ? 1 : 0); });</script>',
			
				$htmlIdTagPart,
				$a[ 'id' ] );
							
			$html .= "</div>\n";
		} else {

			if ( null != $this->_currentActivityGroup ) {
				$html .= sprintf( '<div class="form-row"><label>%s</label><select class="form-control" id="guests_%s_t%d" onchange="showPriceAndAvailability(GGGG,true);">',

					$a[ 'name' ],
					$htmlIdTagPart,
					$a[ 'id' ] );
			}else{
				$html .= sprintf( '<div class="form-row"><label>%s</label><select class="form-control" id="guests_%s_t%d">',

					$a[ 'name' ],
					$htmlIdTagPart,
					$a[ 'id' ] );
			};

				for ( $i = $a[ 'min' ]; $i <= $a[ 'max' ]; $i++ ) {

					$html .= sprintf( '<option value="%d">%d</option>', $i, $i );

				}

			$html .= "</select></div>\n";
		}

		if ( null != $this->_currentActivityGroup ) {
			$html = str_replace( 'GGGG', 'g_' . $this->_currentActivityGroup->groupName, $html );
		};
		
		return $html;
		
	}

	// Load upgrade fields
	public function loadPonorezUpgradeField ( $atts = array() ) {
		
		$a = shortcode_atts( array( 'id' => 0, 'modalid' => '', 'name' => '', 'min' => 0, 'max' => 20 ), $atts );
		
		$html = '';
		if($a[ 'modalid' ] == ''){
			$htmlIdTagPart = sprintf( 'a%d', $this->_currentActivity->id );
		}
		else {
			$htmlIdTagPart = sprintf( 'a%s', $a[ 'modalid' ]);
		}		
		
		if ( null != $this->_currentActivityGroup ) {
			
			$htmlIdTagPart = $this->_currentActivityGroup->groupName;
			
		}

		if ( null != $this->_currentActivityGroup ) {
			$html .= sprintf( '<div class="form-row"><label>%s</label><select class="form-control" id="upgrades_%s_u%d" onchange="showPriceAndAvailability(GGGG,false);">',

				$a[ 'name' ],
				$htmlIdTagPart,
				$a[ 'id' ] );

			$html = str_replace( 'GGGG', 'g_' . $this->_currentActivityGroup->groupName, $html );
		}else{
			$html .= sprintf( '<div class="form-row"><label>%s</label><select class="form-control" id="upgrades_%s_u%d">',

				$a[ 'name' ],
				$htmlIdTagPart,
				$a[ 'id' ] );
		};

		for ( $i = $a[ 'min' ]; $i <= $a[ 'max' ]; $i++ ) {

			$html .= sprintf( '<option value="%d">%d</option>', $i, $i );

		}

		$html .= "</select></div>\n";
		
		return $html;
		
	}

	// Load private guest type fields
	public function loadPonorezPrivateGuestField ( $atts = array() ) {
		
		$a = shortcode_atts( array( 'id' => 0, 'name' => '', 'min' => 0, 'max' => 20 ), $atts );
		
		$html = '';

		$htmlIdTagPart = sprintf( 'a%d', $this->_currentActivity->id );
		
		if ( null != $this->_currentActivityGroup ) {
			
			$htmlIdTagPart = $this->_currentActivityGroup->groupName;
			
		}

		if ( $a[ 'max' ] == 1 ) {
			
				$html = sprintf( '<div class="form-row"><label><input type="checkbox" name="guestCheckbox" id="guests_%s_t%d" value="0" /> %s</label>',

					$htmlIdTagPart,
					$a[ 'id' ],
					$a[ 'name' ] );
					
					$html .= sprintf( '<script>jQuery(\'#guests_%s_t%d\').on(\'click\', function () { jQuery(this).val(this.checked ? 1 : 0); console.log(jQuery(this).val()); });</script>',
					
						$htmlIdTagPart,
						$a[ 'id' ] );
								
				$html .= "</div>\n";

		} else {
	
			$html .= sprintf( '<div class="form-row private-tour"><label>%s</label><select class="form-control" id="guests_%s_t%d">',

				$a[ 'name' ],
				$this->_currentActivity->id,
				$a[ 'id' ],
				$htmlIdTagPart,
				$a[ 'id' ] );

				for ( $i = $a[ 'min' ]; $i <= $a[ 'max' ]; $i++ ) {

					$html .= sprintf( '<option value="%d">%d</option>', $i, $i );

				}

			$html .= "</select></div>\n";
	
		}

		return $html;
		
	}
	
	// Load hotels select field
	public function ponorezAccommodationSelect( $atts = array(), $content = null, $tag ) {
		
		$defaultTemplate = <<<EOT
		<select id="hotel_aMMMM" onchange="accommodation_setupTransportationRoutes({ supplierId: SSSS, activityId: AAAA, agencyId: 0, hotelId: this.value, routeSelectionContextData: routeSelection_aMMMM_contextData, modalId: 'MMMM'  })" class="pr_hotel_select form-control"></select>
		<script type="text/javascript">accommodation_loadHotels({ supplierId: SSSS, activityId:  AAAA, agencyId: 0, hotelSelectSelector: "#hotel_aMMMM", modalId: "MMMM" });</script>
EOT;

		$a = shortcode_atts( array( 'id' => null, 'modalid' => '', 'template' => $defaultTemplate, 'group' => false ), $atts );
		
		$rval_template = $a[ 'template' ];
		if($a[ 'modalid' ] == ''){
			$rval = str_replace( array( 'AAAA', 'MMMM', 'SSSS' ), array( $this->_currentActivity->id, $this->_currentActivity->id, $this->_currentActivity->supplierId ), $rval_template );
		}
		else {
			$rval = str_replace( array( 'AAAA', 'MMMM', 'SSSS' ), array($this->_currentActivity->id,  $a[ 'modalid' ], $this->_currentActivity->supplierId ), $rval_template );
		}


		if ( true == $a[ 'group' ] ) {
			
			$rval = str_replace( 'GGGG', $this->_currentActivityGroup->groupName, $rval );
			
		}

		return $rval;
		
	}
	
	// Set hotel room number
	public function ponorezHotelRoom ( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 'id' => null,'modalid' => '',  ), $atts );
		if($a[ 'modalid' ] == ''){
			$rval = sprintf( '<input class="form-control" id="room_a%d" size="3" />', $this->_currentActivity->id );
		}
		else {
			$rval = sprintf( '<input class="form-control" id="room_a%s" size="3" />', $a[ 'modalid' ]);			
		}
		

		return $rval;
		
	}

	// Load transportation routes for a single activity
	public function loadPonoreztransportation( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 'name' => null, 'modalid' => '', 'message' => 'No transportation.', 'template' => $this->defaultTemplate, 'hidden' => true ), $atts );
		if($a[ 'modalid' ] == ''){
			$a[ 'modalid' ] = $this->_currentActivity->id;
		}
		$trans = new PonoRezTransportation( $this->_currentActivity->supplierId, $this->_currentActivity->id, $a[ 'modalid' ] );
		$map = $trans->getTransportationMap();

		if($a[ 'modalid' ] == ''){
			$javaScript = sprintf( "var routeSelection_a%d_contextData = %s;",							  
				$this->_currentActivity->id,
				json_encode( $map ) );
		}
		else{
			$javaScript = sprintf( "var routeSelection_a%s_contextData = %s;",							  
				$a[ 'modalid' ],
				json_encode( $map ) );
		}

		$rval = sprintf( "<script type=\"text/javascript\">%s</script>\n", $javaScript );

		// Set style if hidden
		$displayStyle = '';
		
		if ( true == $a[ 'hidden' ] )
			
			$displayStyle = 'display:none;';

		$rval .= sprintf( "<div id=\"%s\" style=\"%s margin-top: 10px;\"><strong>Select a transportation route:</strong><br>\n", substr( $map[ 'routesContainerSelector' ], 1 ), $displayStyle );

		$rval .= sprintf( "<div id=\"#NoTransportationOption\"><label style=\"font-weight: normal; font-size: 12px; margin-top: 10px; \"><input type=\"radio\" name=\"transportationroute_a%s\" value=\"\" /> No Transportation</label></div>\n", $a[ 'modalid' ] );
		
		$routeNameTag = sprintf( 'transportationroute_a%s', $a[ 'modalid' ] );
		$transOptions = $trans->getTransportationOptions();
		
		foreach ( $transOptions as $id => $routeName ) {
			$tmp = sprintf( '<div id="%s"><label style="font-weight: normal; font-size: 12px;"><input name="%s" type="radio" value="%d" /> %s</label></div>', $map[ 'routeSelectorMap' ][ $id ], $routeNameTag, $id, $routeName );

			$rval .= "\n" . $tmp;
			
		}
		
		return $rval . "</div>";
		
	}
		
	// Load Book Now button
	public function loadPonorezCheckAvailability( $atts = array(), $content = null, $tag ) {
		
		$googleAnalyticsID = get_option('googleAnalyticsID');
		
		$a = shortcode_atts( array(
			'id' => null
		), $atts );

		$defaultStyle = get_option( 'pr_default_style' );

		// This might look lazy but Pono Rez is going to give me funny button names every time.
		$dsTrimmed = str_replace( '-', '', $defaultStyle );

		if ( !$defaultStyle ) {
			
			$rval = sprintf( '<input type="button" class="btn checkAvailability" activity-id="%d" value="Book Now" />', $this->_currentActivity->id );
						
		} else {
			
			$rval = sprintf( '<input type="button" style="margin-top: 15px;" class="btn checkAvailability" activity-id="%d" value="Book Now" onclick="setgoogleanalytics(\'' . $googleAnalyticsID . '\'); availability_popup(); return false;" />', $this->_currentActivity->id );
			

		}

		return $rval;
		
	}
	
	//Set current group by name
    public function setCurrentActivityGroup ($groupName) {
		
        $groups = get_option('pr_activity_groups');
        $psc = PR()->providerService();
        $serviceCreds = PR()->serviceLogin();

        if (!$groups[$groupName]) {
			
            return null;
        }
        
        $activityIds = $groups[$groupName];
        $activities = array();

        // Create our activity objects.
        foreach ($activityIds as $id) {
			
            $result = $psc->getActivity(array('serviceLogin' => $serviceCreds, 'activityId' => $id));
            $activities[] = $result->return;
			
        }

        $this->_currentActivityGroup = new PonoRezGroup($groupName, $activities);
        $this->_currentActivity = $activities[0];

	}
	
	// Set activities group shortcode
	public function prGroupShortcode( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/inline.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/overlay.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;	
		
	}
	
	public function prGroupShortcode01( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-01.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-01.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );	

		} 
		
    	return $output;	

	}

	public function prGroupShortcode02( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-02.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-02.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;
		
	}

	public function prGroupShortcode03( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-03.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-03.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;
		
	}

	public function prGroupShortcode04( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-04.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-04.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;	

	}
	
	public function prGroupShortcode05( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-05.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-05.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;
		
	}
	
	public function prGroupShortcode06( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-06.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-06.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;	

	}
	
	public function prGroupShortcode07( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-07.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-07.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );	

		} 
		
    	return $output;	

	}

	public function prGroupShortcode08( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-08.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-08.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;
		
	}

	public function prGroupShortcode09( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-09.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-09.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;
		
	}

	public function prGroupShortcode10( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-10.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-10.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;	

	}
	
	public function prGroupShortcode11( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-11.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-11.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;
		
	}
	
	public function prGroupShortcode12( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-12.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-12.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;	

	}
	
	public function prGroupShortcode13( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-13.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-13.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;
		
	}
	
	public function prGroupShortcode14( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 
			'name' => null, 
			'guests' => null,
			'upgrades' => null,
			'accommodation' => 'checkout',
			'allowdiscounts' => null,
			'promocode' => null,
			'title' => null
		), $atts );

		$bookNowText = get_option('bookNowText');
		$accommodationType = $a['accommodation'];
		$accommodationStatus = get_option('accommodationStatus');
		$promotionalCode = $a['promocode'];
		$guestTypes = array( $a['guests'] );
		$guestTypes = explode(',', $a['guests']);
		$upgradeTypes = array( $a['upgrades'] );
		$upgradeTypes = explode(',', $a['upgrades']);
		$promotionalCodesStatus = $a['allowdiscounts'];

		for( $i = 1; $i <= 20; $i++ ){

			$guestType = 'guestType' . $i;
			$guestTypeID = $guestType . 'ID';
			$guestTypeMin = $guestType . 'Min';
			$guestTypeMax = $guestType . 'Max';

			${'guestType' . $i . 'Label'} = get_option( $guestType );
			${'guestType' . $i . 'ID'} = get_option( $guestTypeID );
			${'guestType' . $i . 'MinGuest'} = get_option( $guestTypeMin );
			${'guestType' . $i . 'MaxGuest'} = get_option( $guestTypeMax );

			$upgradeType = 'upgradeType' . $i;
			$upgradeTypeID = $upgradeType . 'ID';
			$upgradeTypeMin = $upgradeType . 'Min';
			$upgradeTypeMax = $upgradeType . 'Max';

			${'upgradeType' . $i . 'Label'} = get_option( $upgradeType );
			${'upgradeType' . $i . 'ID'} = get_option( $upgradeTypeID );
			${'upgradeType' . $i . 'Min'} = get_option( $upgradeTypeMin );
			${'upgradeType' . $i . 'Max'} = get_option( $upgradeTypeMax );

		}
		
		$defaultActivityTemplate = get_option( 'pr_group_default_template' );
		
		$rval = '';

		try {
			
			if ( null != $a[ 'name' ] ) {
				
				$this->setCurrentActivityGroup( $a[ 'name' ] );
				
			}
			
		} catch ( SoapFault $e ) {
			
			$rval .= sprintf( "<br>\n<pre>\n%s\n</pre>", $this->_soapDebug );

		}

		// Load group functions.
		wp_enqueue_script( 'pr_group_functions' );
		
		// Assemble the JavaScript.
		$cag = $this->_currentActivityGroup;

		$javaScript = PR()->withTransient( 'pr_group', $cag->groupName, function ()use( $cag ) {
			
			return $cag->toJson( true );
			
		} );

		if ($defaultActivityTemplate == 'inline') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/inline-14.php' );	
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );
			
		} elseif ($defaultActivityTemplate == 'overlay') {
			
			ob_start();

			include_once( plugin_dir_path( __DIR__ ) . 'templates/activities-group/sub/overlay-14.php' );
			$output = ob_get_clean();
			$output .= sprintf( "<script>\n%s\n</script>", $javaScript );

		} 
		
    	return $output;	

	}

	// Load minAvailability Select
	public function loadPonorezMinAvailability( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 'notavailable' => '(Not Available)', 'smarttimes' => false, 'template' => $this->defaultTemplate ), $atts );

		$rval = '';

		$g = $this->_currentActivityGroup;

		$contain = sprintf('<div class="form-row"><select class="form-control availability" onclick="showPriceAndAvailability(g_%s,false);" onchange="showPriceAndAvailability(g_%s,false);">', $g->groupName, $g->groupName);

		if ( null == $content ) { 
			$template = <<<EOT
			
<option>
<times>

EOT;
		} else {
			
			$template = $content;
			
		}

		$checkboxTemplate = '<option id="%s" onclick="selectActivity(g_%s, this);">';
		$naTemplate = '<span class="pr_not_available_message" id="%s" style="display: none;">%s</span>';

		// Activity data.
		$cbIds = $g->activityCheckboxControlIds();
		$naIds = $g->activityNotAvailableMessageControlIds();

		foreach ( $g->activities as $activity ) {
			
			$tmp = str_replace( '<option>', sprintf( $checkboxTemplate, $cbIds[ $activity->id ], $g->groupName ), $template );
			$times = ( '' == $activity->times ) ? $activity->name : $activity->times;

			if ( $a[ 'smarttimes' ] && 1 == preg_match( '/\b([0-9]+:[0-9]+[ap]m)\b/', $times, $matches ) ) {
				
				$times = $matches[ 1 ];
				
			}

			$tmp = str_replace( '<times>', $times, $tmp );
			$tmp = str_replace( '<not available>', sprintf( $naTemplate, $naIds[ $activity->id ], $a[ 'notavailable' ] ), $tmp );
			$rval .= $tmp;
			
		}
		
		//$output ='<label>Select transportation option</label>'; I need to figure out logic for when to switch these. For now I am doing a build based on the client needs
		$output ='<labe>Select from available times</label>';
		$output .= $contain;
		$output .= $rval;
		$output .= '</select></div>';
		
		return $output;
		
	}
	
	// Load total price calculator
	public function loadPonorezTotalPrice( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 'name' => null ), $atts ); 
		$rval = '';

		if ( null != $this->_currentActivityGroup ) {
			
			$rval = sprintf( '<span id="%s"></span>', $this->_currentActivityGroup->priceControlId() );
			
		}

		$output = '<div class="form-row"><label>Total Price with taxes: ';
		$output .= $rval;
		$output .= '</div></label>';
		
		return $output;
		
	}
	
	// Set accomodation list for groups shortcode
	public function ponorezGroupAccommodationSelect( $atts = array(), $content = null, $tag ) {
		
		$atts[ 'template' ] = <<<EOT
<select class="pr_hotel_select form-control" id="hotel_aAAAA" onchange="accommodation_setupTransportationRoutes({supplierId: SSSS, activityId: AAAA, agencyId: 0, hotelId: this.value, routeSelectionContextData: g_GGGG.transportation }); showPriceAndAvailability(g_GGGG,false);"></select>
<script type="text/javascript">accommodation_loadHotels({ supplierId: SSSS, activityId:  AAAA, agencyId: 0, hotelSelectSelector: "#hotel_aAAAA" });</script>
EOT;
		
		$atts[ 'group' ] = true;

		//return $this->prHotelSelectShortcode( $atts, $content, $tag );
		return $this->ponorezAccommodationSelect( $atts, $content, $tag );		
		
	}
	
	// Load Group Transportation options select
	public function loadPonorezGroupTransportation( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 'name' => null, 'message' => 'No transportation.', 'template' => $this->defaultTemplate ), $atts );
		$rval = '';
	
		$map = $this->_currentActivityGroup->transportationMap();

		$rval = sprintf( '<div id="%s" style="display:none;"><strong>Select a transportation route:</strong><br>', substr( $map[ 'routesContainerSelector' ], 1 ) );
		$routeNameTag = sprintf( 'transportationroute_a%d', $this->_currentActivityGroup->activities[ 0 ]->id );
		$rval .= sprintf( '<div><label><input name="%s" type="radio" value="" /> %s</label></div>', $routeNameTag, $a[ 'message' ] );

		try {
			
			$serviceCreds = PR()->serviceLogin();
			$service = PR()->providerService();

			foreach ( $map[ 'routeSelectorMap' ] as $id => $route ) {
				
				$result = $service->getTransportationRoute( array( 'serviceLogin' => $serviceCreds, 'supplierId' => $this->_currentActivityGroup->supplierId, 'transportationRouteId' => $id ) );
				$tmp = sprintf( '<div id="%s"><label><input name="%s" type="radio" value="%d" /> %s</label></div>',
							   
					$route,
					$routeNameTag,
					$id,
					$result->return ->name );

				$rval .= "\n" . $tmp;
				
			}
			
		} catch ( Exception $e ) {
			
			$rval = sprintf( "<pre>%s\n</pre>\n", $e->getMessage() );
			
		}

		return $rval . "</div>";

	}
	
	// Load Group Book Now Submit
	public function loadPonorezCheckGroupAvailability( $atts = array(), $content = null, $tag ) {
		
		$a = shortcode_atts( array( 'name' => null, 'style' => get_option( 'pr_default_style' ), 'class' => '' ), $atts );
		$dsTrimmed = str_replace( '-', '', $a[ 'style' ] );
		$bookNowText = get_option('bookNowText');
		$googleAnalyticsID = get_option('googleAnalyticsID');
		

		if ( !$dsTrimmed ) { 
			
			$rval = sprintf( '<input type="button" class="pr-btn-book-now" value="' . $bookNowText . '" onclick="booknow(g_%s,\'' . $googleAnalyticsID . '\');" />', $this->_currentActivityGroup->groupName );
			
		} else {
			
			$rval = sprintf( '<input type="button" class="pr-btn-book-now" value="' . $bookNowText . '" onclick="booknow(g_%s,\'' . $googleAnalyticsID . '\');" />',
			$this->_currentActivityGroup->groupName );
			
		}

		return $rval;
		
	}
	
	// Register shortcodes
	public function registerShortcodes() {
		
		// Single activity shortcodes.
		add_shortcode( 'ponorezActivityBooking', array( $this, 'ponorezActivityBooking' ) );
		add_shortcode( 'ponorezActivityBooking-01', array( $this, 'ponorezActivityBooking01' ) );
		add_shortcode( 'ponorezActivityBooking-02', array( $this, 'ponorezActivityBooking02' ) );
		add_shortcode( 'ponorezActivityBooking-03', array( $this, 'ponorezActivityBooking03' ) );
		add_shortcode( 'ponorezActivityBooking-04', array( $this, 'ponorezActivityBooking04' ) );
		add_shortcode( 'ponorezActivityBooking-05', array( $this, 'ponorezActivityBooking05' ) );
		add_shortcode( 'ponorezActivityBooking-06', array( $this, 'ponorezActivityBooking06' ) );
		add_shortcode( 'ponorezActivityBooking-07', array( $this, 'ponorezActivityBooking07' ) );
		add_shortcode( 'ponorezActivityBooking-08', array( $this, 'ponorezActivityBooking08' ) );
		add_shortcode( 'ponorezActivityBooking-09', array( $this, 'ponorezActivityBooking09' ) );
		add_shortcode( 'ponorezActivityBooking-10', array( $this, 'ponorezActivityBooking10' ) );
		add_shortcode( 'ponorezActivityBooking-11', array( $this, 'ponorezActivityBooking11' ) );
		add_shortcode( 'ponorezActivityBooking-12', array( $this, 'ponorezActivityBooking12' ) );
		add_shortcode( 'ponorezActivityBooking-13', array( $this, 'ponorezActivityBooking13' ) );
		add_shortcode( 'ponorezActivityBooking-14', array( $this, 'ponorezActivityBooking14' ) );
		add_shortcode( 'loadPonorezActivity', array( $this, 'loadPonorezActivity' ) );
		add_shortcode( 'loadPonorezActivityName', array( $this, 'ponorezActivityName' ) );	
		add_shortcode( 'loadPonorezDatePicker', array( $this, 'ponorezDatePicker' ) );
		add_shortcode( 'loadPonorezActivityGuestField', array( $this, 'loadPonorezActivityGuestField' ) );
		add_shortcode( 'loadPonorezUpgradeField', array( $this, 'loadPonorezUpgradeField' ) );
		add_shortcode( 'loadPonorezPrivateGuestField', array( $this, 'loadPonorezPrivateGuestField' ) );
		add_shortcode( 'loadPonorezAccommodation', array( $this, 'ponorezAccommodationSelect' ) );	
		add_shortcode( 'loadPonorezHotelRoom', array( $this, 'ponorezHotelRoom' ) );
		add_shortcode( 'loadPonoreztransportation', array( $this, 'loadPonoreztransportation' ) );	
		add_shortcode( 'loadPonorezCheckAvailability', array( $this, 'loadPonorezCheckAvailability' ) );

		// Activities group shortcodes	
		add_shortcode( 'ponorezGroupBooking', array( $this, 'prGroupShortcode' ) );	
		add_shortcode( 'ponorezGroupBooking-01', array( $this, 'prGroupShortcode01' ) );
		add_shortcode( 'ponorezGroupBooking-02', array( $this, 'prGroupShortcode02' ) );
		add_shortcode( 'ponorezGroupBooking-03', array( $this, 'prGroupShortcode03' ) );
		add_shortcode( 'ponorezGroupBooking-04', array( $this, 'prGroupShortcode04' ) );
		add_shortcode( 'ponorezGroupBooking-05', array( $this, 'prGroupShortcode05' ) );
		add_shortcode( 'ponorezGroupBooking-06', array( $this, 'prGroupShortcode06' ) );
		add_shortcode( 'ponorezGroupBooking-07', array( $this, 'prGroupShortcode07' ) );
		add_shortcode( 'ponorezGroupBooking-08', array( $this, 'prGroupShortcode08' ) );
		add_shortcode( 'ponorezGroupBooking-09', array( $this, 'prGroupShortcode09' ) );
		add_shortcode( 'ponorezGroupBooking-10', array( $this, 'prGroupShortcode10' ) );
		add_shortcode( 'ponorezGroupBooking-11', array( $this, 'prGroupShortcode11' ) );
		add_shortcode( 'ponorezGroupBooking-12', array( $this, 'prGroupShortcode12' ) );
		add_shortcode( 'ponorezGroupBooking-13', array( $this, 'prGroupShortcode13' ) );
		add_shortcode( 'ponorezGroupBooking-14', array( $this, 'prGroupShortcode14' ) );
		add_shortcode( 'loadPonorezMinAvailability', array( $this, 'loadPonorezMinAvailability' ) );	
		add_shortcode( 'ponorezGroupAccommodationSelect', array( $this, 'ponorezGroupAccommodationSelect' ) );
		add_shortcode( 'loadPonorezGroupTransportation', array( $this, 'loadPonorezGroupTransportation' ) );
		add_shortcode( 'loadPonorezTotalPrice', array( $this, 'loadPonorezTotalPrice' ) );
		add_shortcode( 'loadPonorezCheckGroupAvailability', array( $this, 'loadPonorezCheckGroupAvailability' ) );
				
	}

	// Load required scripts
	public function loadScripts() {
		
		// Load HawaiiFun Hosted JS Files
		wp_enqueue_script( 'pr_calendar', 'https://www.hawaiifun.org/reservation/common/calendar_js.jsp', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'pr_accommodation' ) );
		wp_enqueue_script( 'pr_functions', 'https://www.hawaiifun.org/reservation/external/functions.js', array( 'jquery', 'pr_calendar' ), null );
		//wp_enqueue_script( 'pr_functions2', 'https://www.hawaiifun.org/reservation/external/functions2.js', array( 'jquery', 'pr_calendar' ), null );
		wp_enqueue_script( 'pr_activitySwitch', 'https://www.hawaiifun.org/reservation/external/activityswitch-1.js', array(), null, false );
		
		//Load self hosted JS files
		wp_enqueue_script( 'pr_accommodation', plugins_url( 'assets/js/pr_accommodation.js', dirname( __FILE__ ) ), array( 'jquery' ) );
		wp_enqueue_script( 'pr_modal', plugins_url( 'assets/js/jquery.modal.min.js', dirname( __FILE__ ) ), array( 'jquery' ) );
		wp_register_script( 'pr_group_functions', plugins_url( 'assets/js/pr_group_functions.js', dirname( __FILE__ ) ), array( 'jquery', 'pr_functions' ), null );

		//Load CSS files
		wp_enqueue_style( 'pr_fontAwesome_css', plugins_url( 'assets/css/font-awesome.min.css', dirname( __FILE__ ) ) );
		wp_enqueue_style( 'pr_modal_css', plugins_url( 'assets/css/jquery.modal.min.css', dirname( __FILE__ ) ) );
		wp_enqueue_style( 'pr_BookingForms_css', plugins_url( 'assets/css/booking-forms.css', dirname( __FILE__ ) ) );
		
	}

	public function init() {
		
		$this->loadScripts();
		$this->registerShortcodes();

		$defaultTemplate = get_option( 'pr_default_template' );

		if ( !$defaultTemplate ) {
			
			$defaultTemplate = 'inline';
			
		}

		$this->defaultTemplate = realpath( dirname( __FILE__ ) . '/../' ) . '/templates/activities-single/' . $defaultTemplate . '.php';
		
		$defaultGroupTemplate = get_option( 'pr_group_default_template' );
		
		if ( !$defaultGroupTemplate ) {
			
			$defaultGroupTemplate = 'inline';
			
		}

		$this->defaultGroupTemplate = realpath( dirname( __FILE__ ) . '/../' ) . '/templates/activities-group' . $defaultGroupTemplate . '.php';

	}
	
}