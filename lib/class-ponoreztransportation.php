<?php
/**
 * Helper class for Transportation mapping and layout
 *
 * This class is used by both the single-tour template class and the
 * group class to build and layout transportation information.
 * It is adapted from changes originally added to the PonoRezGroup class.
 *
 * @author Erik L. Arneson <earneson@arnesonium.com>
 */

final class PonoRezTransportation {
    protected $_transportationMap = null;
    protected $_transportationOptions = null;
    protected $_supplierId;
    protected $_activityId;

    /**
     * Create a transportation object
     *
     * @param int $supplierId
     * @param int $activityId
     */
    public function __construct ($supplierId, $activityId) {
        $this->_supplierId = $supplierId;
        $this->_activityId = $activityId;
    }

    /**
     * Accessor for the transportation map
     *
     * This function builds the transportation map if needed.
     *
     * @return array Transportation map
     */
    public function getTransportationMap () {
        if (null == $this->_transportationMap) {
            $this->_transportationMap = $this->_buildTransportationMap();
        }

        return $this->_transportationMap;
    }
    
    /**
     * Collect transportation information from PR SOAP service
     *
     * This function builds the internal transportation map using the
     * PR SOAP service. This map will eventually then be turned into
     * JavaScript code for the frontend.
     *
     * At the moment it doesn't catch SOAP exceptions, leaving that to
     * be done by a caller function. I do not know if that is the
     * best behavior.
     *
     * @TODO Catch SOAP exceptions?
     */
    protected function _buildTransportationMap () {
        $serviceCreds = PR()->serviceLogin();
        $service = PR()->providerService();

        // Note that transportation routes aren't available in the Agency service for some reason.
        $result = $service->getActivityTransportationOptions(array(
            'serviceLogin' => $serviceCreds,
            'supplierId' => $this->_supplierId,
            'activityId' => $this->_activityId,
            // @TODO I can't get transportation options for the current day for some reason.
            'date' => new SoapVar(date('Y-m-d', strtotime('+2 days')), XSD_DATE)
        ));

        $map = array();

        // This part is tricky. 'out_transportationOptions' will
        // contain a number of TransportationOption objects. Each of
        // those has a member, 'idCode', which will have a code that
        // is not entirely a transportation ID. My samples showed
        // 'A:801', so the assumption is that it will be a letter,
        // colon, and number. The number is used to build JavaScript
        // code for the PR functions to use.
        if (isset($result->out_transportationOptions)) {
            foreach ($result->out_transportationOptions as $option) {
                $key = substr($option->idCode, strpos($option->idCode, ':') + 1);
            
                $map[$key] = sprintf('#transportationRouteContainer_a%d_%d',
                                     $this->_activityId, $key);
            }
        }

        // The map needs contain the following elements.
        //  routesContainerSelector: "#transportationRoutesContainer_a7648",
        //  routeSelectorMap: 
        $rval['routesContainerSelector'] = sprintf('#transportationRoutesContainer_a%d',
                                                   $this->_activityId);
        $rval['routeSelectorMap'] = $map;
        
        return $rval;
    }


}