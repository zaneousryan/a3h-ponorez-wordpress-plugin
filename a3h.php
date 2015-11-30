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

    public function __construct () {
        // Load private configuration.
        $this->_config = json_decode(file_get_contents("private.json"));
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

