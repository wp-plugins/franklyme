<?php

/**
* Plugin Name: Frankly.me
* Description: Embed Frankly.me social widgets and grow your audience on frankly.me. Official Frankly.me wordpress plugin.
* Author: Frankly.me
* Version: 1.1
* Author URI: http://frankly.me
* Plugin URI: https://wordpress.org/plugins/franklyme/
* Text Domain: frankly-me
* License: GPLv2
**/


/*  Copyright 2015  ABHISHEK GUPTA  (email : abhishekgupta@frankly.me)

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


include_once('sidepane-widget.php');
include_once('embed.php');
include_once('profile-frankly.php');
include_once('filters.php');

function franklyPluginPage($links) {
     $settings_link = '<a href="options-general.php?page=frankly">'. __( "Settings", "frankly-me" ) .'</a>';
     array_unshift($links, $settings_link);
     return $links;
}
$plugin = plugin_basename(__FILE__);

add_filter("plugin_action_links_$plugin", 'franklyPluginPage' );

?>