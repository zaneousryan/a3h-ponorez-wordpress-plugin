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
     * Grab the transportation ID from its "idCode"
     *
     * See documentation on 'type TransportationOption' for more
     * information. The idCode usually looks like A:301, where the "A"
     * is for some internal function and the "301" is the
     * transportation route ID.
     *
     * @param string $idCode
     * @return int Transportation route ID
     */
    public function idFromIdCode ($idCode) {
        return substr($idCode, strpos($idCode, ':') + 1);
    }

    public function cmpIdCode ($id, $idCode) {
        return (substr($idCode, strpos($idCode, ':') + 1) == $id);
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
     * List transportation options.
     *
     * This might trigger a SOAP call.
     *
     * @return TransportationRouteInfo array Undocumented SOAP class array
     */
    public function getTransportationOptions () {
        if (null == $this->_transportationOptions) {
            $this->_transportationOptions = $this->_getTransportationOptionsSoap();
        }

        return $this->_transportationOptions;
    }

    /**
     * Return the name of a route by id
     *
     * Pass in a route ID, and get the name. For some reason, the
     * transportation options don't contain the simple name of the
     * option. That requires a separate SOAP call. Painful, isn't it?
     */
    public function routeNameById ($id) {
        $serviceCreds = PR()->serviceLogin();
        $service = PR()->providerService();
        $name = '';

        // I don't know if this is correct behavior, but if the SOAP
        // call fails, then we grab info from the option map, which
        // has a "description" field.
        try {
            $result = $service->getTransportationRoute(array(
                'serviceLogin' => $serviceCreds,
                'supplierId' => $this->_supplierId,
                'transportationRouteId' => $id
            ));

            $name = $result->return->name;
        }
        catch (Exception $e) {
            // Don't report the error. Look for another way.
            foreach ($this->getTransportationOptions() as $option) {
                if ($this->cmpIdCode($id, $option->idCode)) {
                    $name = $option->description;
                    break;
                }
            }
        }

        return $name;
    }
    
    /**
     * Collect transportation information from PR SOAP service
     *
     * At the moment it doesn't catch SOAP exceptions, leaving that to
     * be done by a caller function. I do not know if that is the
     * best behavior.
     *
     * @TODO I can't get transportation options for the current day for some reason.
     * @TODO Catch SOAP exceptions?
     */
    protected function _getTransportationOptionsSoap() {
        $serviceCreds = PR()->serviceLogin();
        $service = PR()->providerService();

        // Note that transportation routes aren't available in the Agency service for some reason.
        $result = $service->getActivityTransportationOptions(array(
            'serviceLogin' => $serviceCreds,
            'supplierId' => $this->_supplierId,
            'activityId' => $this->_activityId,
            'date' => new SoapVar(date('Y-m-d', strtotime('+2 days')), XSD_DATE)
        ));

        return $result->out_transportationOptions;
    }
    
    /**
     * Build transportation map from SOAP data
     *
     * This function builds the internal transportation map using the
     * PR SOAP service. This map will eventually then be turned into
     * JavaScript code for the frontend.
     */
    protected function _buildTransportationMap () {
        $transportationOptions = $this->getTransportationOptions();
        
        // This part is tricky. 'out_transportationOptions' will
        // contain a number of TransportationOption objects. Each of
        // those has a member, 'idCode', which will have a code that
        // is not entirely a transportation ID. My samples showed
        // 'A:801', so the assumption is that it will be a letter,
        // colon, and number. The number is used to build JavaScript
        // code for the PR functions to use.
        if (isset($transportationOptions)) {
            foreach ($transportationOptions as $option) {
                $key = $this->idFromIdCode($option->idCode);
            
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