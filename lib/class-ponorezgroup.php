<?php
/**
 * Handle activity groups.
 *
 * This class tries hard to make as few SOAP calls as possible. 
 */

final class PonoRezGroup {
    public $groupName;
    public $supplierId;
    public $activities; // This will be objects. Doesn't fit?
    public $activityIds;
    public $guestTypes; // This will be objects.
    public $guestTypeIds;
    public $activityPrices;

    // protected elements
    protected $psc;
    protected $_transportationMap = null;

    /**
     * Create an activity group and prepare it for use on the frontend.
     *
     * @param string $name The name of the group.
     * @param array $activities A list of ActivityInfo objects.
     */
    public function __construct ($name, $activities) {
        $this->groupName = $name;
        $this->supplierId = $activities[0]->supplierId;
        $this->activities = $activities;
        $this->psc = PR()->providerService();

        $this->_buildPricing();
    }

    /**
     * Return JSON for use with frontend JavaScript
     *
     * @param bool $asVar If TRUE, return full JavaScript with variable declaration.
     */
    public function toJson ($asVar = false) {
        $rawStruct = array(
            'supplierid' => $this->supplierId,
            'activityids' => $this->activityIds,
            'guesttypeids' => $this->guestTypeIds,
            'activityprices' => $this->activityPrices,
            'datecontrolid' => $this->dateControlId(),
            'pricecontrolid' => $this->priceControlId(),
            'activitycheckboxcontrolids' => $this->activityCheckboxControlIds(),
            'activitydescriptioncontrolids' => $this->activityDescriptionControlIds(),
            'activitynotavailablemessagecontrolids' => $this->activityNotAvailableMessageControlIds(),
            'guesttypecontrolids' => $this->guestTypeControlIds(),
            'hotelcontrolid' => $this->hotelControlId(),
            'cancellationpolicycontrolid' => $this->cancellationPolicyControlId(),
            'transportation' => $this->transportationMap()
        );

        // Now we build transportation information.
        

        // Full JS encoding includes setting it to a variable.
        if (true == $asVar) {
            return sprintf('var g_%s = %s;', $this->groupName, json_encode($rawStruct));
        }

        return json_encode($rawStruct);
    }
    
    // Collect pricing information from SOAP.
    protected function _buildPricing () {
        // We need SOAP for this.
        $this->psc = PR()->providerService();
        $serviceCreds = PR()->serviceLogin();
        
        // Collect guest information.
        $pricing = array();
        $gtids = array();
        foreach ($this->activities as $a) {
            $this->activityIds[] = $a->id;

            $result = $this->psc->getActivityGuestTypes(array('serviceLogin' => $serviceCreds,
                                                        'activityId' => $a->id,
                                                        'supplierId' => $a->supplierId,
                                                        'date' => new SoapVar(date('Y-m-d'), XSD_DATE)));

            //            print_r($result);
            
            // Build guest pricing info.
            foreach ($result->return as $guest) {
                $gtids[] = $guest->id;
                $pricing[$a->id][$guest->id] = sprintf("%.02f", $guest->price);
            }
        }

        $this->guestTypeIds = array_unique($gtids);
        $this->activityPrices = $pricing;
    }

    public function transportationMap () {
        if (null == $this->_transportationMap) {
            $this->_transportationMap = $this->_buildTransportationMap();
        }

        return $this->_transportationMap;
    }
    
    // Collect transportation information from SOAP.
    protected function _buildTransportationMap () {
        $serviceCreds = PR()->serviceLogin();
        $service = PR()->providerService();

        // Note that transportation routes aren't available in the Agency service for some reason.
        $result = $service->getActivityTransportationOptions(array(
            'serviceLogin' => $serviceCreds,
            'supplierId' => $this->supplierId,
            'activityId' => $this->activities[0]->id,
            // @TODO I can't get transportation options for the current day for some reason.
            'date' => new SoapVar(date('Y-m-28'), XSD_DATE)
        ));

        $map = array();

        // This part is tricky. 'out_transportationOptions' will
        // contain a number of TransportationOption objects. Each of
        // those has a member, 'idCode', which will have a code that
        // is not entirely a transportation ID. My samples showed
        // 'A:801', so the assumption is that it will be a letter,
        // colon, and number. The number is used to build JavaScript
        // code for the PR functions to use.
        foreach ($result->out_transportationOptions as $option) {
            $key = substr($option->idCode, strpos($option->idCode, ':') + 1);
            
            $map[$key] = sprintf('#transportationRouteContainer_a%d_%d',
                                 $this->activities[0]->id, $key);
        }

        // The map needs contain the following elements.
        //  routesContainerSelector: "#transportationRoutesContainer_a7648",
        //  routeSelectorMap: 
        $rval['routesContainerSelector'] = sprintf('#transportationRoutesContainer_a%d',
                                                   $this->activities[0]->id);
        $rval['routeSelectorMap'] = $map;
        
        return $rval;
    }

    public function dateControlId () {
        return sprintf('date_%s', $this->groupName);
    }

    public function priceControlId () {
        return sprintf('price_%s', $this->groupName);
    }

    // This actually will try to match the non-group shortcode.
    public function hotelControlId () {
        return sprintf('hotel_a%d', $this->activities[0]->id);
    }

    public function activityCheckboxControlIds () {
        $ret = array();

        foreach ($this->activityIds as $id) {
            $ret[$id] = sprintf('activity_%d', $id);
        }

        return $ret;
    }

    public function activityDescriptionControlIds () {
        $ret = array();

        foreach ($this->activityIds as $id) {
            $ret[$id] = sprintf('activity_%d_description', $id);
        }

        return $ret;
    }

    public function activityNotAvailableMessageControlIds () {
        $ret = array();

        foreach ($this->activityIds as $id) {
            $ret[$id] = sprintf('activity_%d_notavailablemessage', $id);
        }

        return $ret;
    }

    public function guestTypeControlIds () {
        $ret = array();

        foreach ($this->guestTypeIds as $id) {
            $ret[$id] = sprintf('guests_%s_t%d', $this->groupName, $id);
        }

        return $ret;
    }

    public function cancellationPolicyControlId () {
        return sprintf('cancellationpolicy_%s', $this->groupName);
    }

    // Building transportation information
    public function transportationRoutesContainerId () {
        return sprintf('#transportationRoutesContainer_a%d_%s',
                       $this->supplierId,
                       $this->groupName);
    }

    
    // In this one, we get the transportation route IDs with SOAP,
    // then build selector names for them.
    public function routeSelectorMap () {
    }
                       
}
