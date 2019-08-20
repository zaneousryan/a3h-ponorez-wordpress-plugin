<?php
/**
 * This class handle activity groups.
 *
 */

final class PonoRezGroup {
	public $groupName;
	public $supplierId;
	public $activities; // Object
	public $activityIds;
	public $guestTypes; // Object
	public $guestTypeIds;
	public $upgradeTypes; // Object
	public $upgradeTypeIds;
	public $activityPrices;

	protected $psc;
	protected $_transportationMap = null;

	/**
	 * Create activities group and prepare it for front-end use.
	 *
	 * @param string $name Group name.
	 * @param array $activities a list of ActivityInfo objects.
	 */
	public
	function __construct( $name, $activities ) {
		$this->groupName = $name;
		$this->supplierId = $activities[ 0 ]->supplierId;
		$this->activities = $activities;
		$this->psc = PR()->providerService();

		$this->_buildPricing();
	}

	/**
	 * Return JSON for use with front-end JavaScript
	 *
	 * @param bool $asVar If TRUE, return full JavaScript with variable declaration.
	 */
	public function toJson( $asVar = false ) {
		$rawStruct = array(
			'supplierid' => $this->supplierId,
			'activityids' => $this->activityIds,
			'guesttypeids' => $this->guestTypeIds,
			'upgradetypeids' => $this->upgradeTypeIds,
			'activityprices' => $this->activityPrices,
			'upgradeprices' => $this->upgradePrices,
			'datecontrolid' => $this->dateControlId(),
			'pricecontrolid' => $this->priceControlId(),
			'promotionalcodecontrolid' => $this->promotionalCodeID(),
			'activitycheckboxcontrolids' => $this->activityCheckboxControlIds(),
			'activitydescriptioncontrolids' => $this->activityDescriptionControlIds(),
			'activitynotavailablemessagecontrolids' => $this->activityNotAvailableMessageControlIds(),
			'guesttypecontrolids' => $this->guestTypeControlIds(),
			'upgradecontrolids' => $this->upgradeControlIds(),
			'hotelcontrolid' => $this->hotelControlId(),
			'cancellationpolicycontrolid' => $this->cancellationPolicyControlId(),
			'transportation' => $this->transportationMap()
		);
		
		// Full JS encoding includes setting it to a variable.
		if ( true == $asVar ) {
			return sprintf( 'var g_%s = %s;', $this->groupName, json_encode( $rawStruct ) );
		}

		return json_encode( $rawStruct );
	}

	// Collect pricing information.
	protected function _buildPricing() {

		$this->psc = PR()->providerService();
		$serviceCreds = PR()->serviceLogin();

		// Collect guest types information
		$pricing = array();
		$gtids = array();
		foreach ( $this->activities as $a ) {
			$this->activityIds[] = $a->id;

			$result = $this->psc->getActivityGuestTypes( array( 'serviceLogin' => $serviceCreds,
				'activityId' => $a->id,
				'supplierId' => $a->supplierId,
				'date' => new SoapVar( date( 'Y-m-d' ), XSD_DATE ) ) );

			$guestTypeList = $result->
				return;
			if ( !is_array( $result->
					return ) ) {
				$guestTypeList = array( $result->
					return );
			}

			// Build guest pricing info.
			foreach ( $guestTypeList as $guest ) {
				$gtids[] = $guest->id;
				$pricing[ $a->id ][ $guest->id ] = sprintf( "%.02f", $guest->price );
			}
		}

		$this->guestTypeIds = array_unique( $gtids );
		$this->activityPrices = $pricing;

		// Collect upgrades information
		$upprices = array();
		$ugids = array();
		foreach ( $this->activities as $a ) {
			$this->activityIds[] = $a->id;

			$upResult = $this->psc->getActivityUpgrades( array( 'serviceLogin' => $serviceCreds,
				'activityId' => $a->id,
				'supplierId' => $a->supplierId,
				'date' => new SoapVar( date( 'Y-m-d' ), XSD_DATE ) ) );

			if(isset($upResult -> return)){
				$upgradeList = $upResult->
					return;

				if ( !is_array( $upResult->
						return ) ) {
					$upgradeList = array( $upResult->
						return );
				}

				// Build upgrade pricing info.
				foreach ( $upgradeList as $upgrades ) {
					$ugids[] = $upgrades->id;
					$upprices[ $a->id ][ $upgrades->id ] = sprintf( '%.02f', $upgrades->price );
				}
			}
		}

		$this->upgradeTypeIds = array_unique( $ugids );
		$this->upgradePrices = $upprices;
	}

	public function transportationMap() {
		if ( null == $this->_transportationMap ) {
			$trans = new PonoRezTransportation( $this->supplierId, $this->activities[ 0 ]->id );
			$this->_transportationMap = $trans->getTransportationMap();
		}

		return $this->_transportationMap;
	}

	public function dateControlId() {
		return sprintf( 'date_%s', $this->groupName );
	}

	public function priceControlId() {
		return sprintf( 'price_%s', $this->groupName );
	}

	// This will try to match the non-group shortcode.
	public function hotelControlId() {
		return sprintf( 'hotel_a%d', $this->activities[ 0 ]->id );
	}

	public function activityCheckboxControlIds() {
		$ret = array();

		foreach ( $this->activityIds as $id ) {
			$ret[ $id ] = sprintf( 'activity_%d', $id );
		}

		return $ret;
	}

	public function activityDescriptionControlIds() {
		$ret = array();

		foreach ( $this->activityIds as $id ) {
			$ret[ $id ] = sprintf( 'activity_%d_description', $id );
		}

		return $ret;
	}

	public function activityNotAvailableMessageControlIds() {
		$ret = array();

		foreach ( $this->activityIds as $id ) {
			$ret[ $id ] = sprintf( 'activity_%d_notavailablemessage', $id );
		}

		return $ret;
	}

	public function guestTypeControlIds() {
		$ret = array();

		foreach ( $this->guestTypeIds as $id ) {
			$ret[ $id ] = sprintf( 'guests_%s_t%d', $this->groupName, $id );
		}

		return $ret;
	}

	public function upgradeControlIds() {
		$ret = array();

		foreach ( $this->upgradeTypeIds as $id ) {
			$ret[ $id ] = sprintf( 'upgrades_%s_u%d', $this->groupName, $id );
		}

		return $ret;
	}
	
	public function promotionalCodeID() {
		return sprintf( 'promotionalcode_%s', $this->groupName );
	}
	
	public function cancellationPolicyControlId() {
		return sprintf( 'cancellationpolicy_%s', $this->groupName );
	}

	// Building transportation information
	public function transportationRoutesContainerId() {
		return sprintf( '#transportationRoutesContainer_a%d_%s',
			$this->supplierId,
			$this->groupName );
	}

	// In this one, we get the transportation route IDs with SOAP, then build selector names for them.
	public function routeSelectorMap() {}

}