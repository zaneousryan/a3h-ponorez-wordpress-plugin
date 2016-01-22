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
            'guesttypeids' => $this->guesttypeids,
            'activityprices' => $this->activityPrices,
            'datecontrolid' => $this->dateControlId(),
            'activitycheckboxcontrolids' => $this->activityCheckboxControlIds(),
            'activitydescriptioncontrolids' => $this->activityDescriptionControlIds(),
            'activitynotavailablemessagecontrolids' => $this->activityNotAvailableMessageControlIds(),
            'guesttypecontrolids' => $this->guestTypeControlIds(),
            'cancellationpolicycontrolid' => $this->cancellationPolicyControlId()
        );

        // Full JS encoding includes setting it to a variable.
        if (true == $asVar) {
            return sprintf('var %s = %s;', $this->groupName, json_encode($rawStruct));
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
        foreach ($activities as $a) {
            $this->activityIds[] = $a->id;

            $tmpGTs = $psc->getActivityGuestTypes(array('serviceLogin' => $serviceCreds,
                                                        'activityId' => $a->id,
                                                        'supplierId' => $a->supplierId,
                                                        'date' => new SoapVar(date('Y-m-d'), XSD_DATE)));

            // Build guest pricing info.
            foreach ($tmpGTs as $guest) {
                $gtids[] = $guest->id;
                $pricing[$a->id][$guest->id] = $guest->price;
            }
        }

        $this->guestTypeIds = array_unique($gtids);
        $this->activityPrices = $pricing;
    }

    public function dateControlId () {
        return sprintf('date_%s', $this->groupName);
    }

    public function priceControlId () {
        return sprintf('price_%s', $this->groupName);
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
}
