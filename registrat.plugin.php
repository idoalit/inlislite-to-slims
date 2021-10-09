<?php
/**
 * Plugin Name: Migrator Inlislite to SLiMS
 * Plugin URI: https://github.com/idoalit/inlislite-to-slims
 * Description: Alat untuk memigrasi database Inlislite v3.2 ke SLiMS 9.4.2
 * Version: 0.0.0
 * Author: Waris Agung Widodo
 * Author URI: https://github.com/idoalit
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

// require libraries
require_once __DIR__ . '/lib/vendor/autoload.php';

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// register new menu
$plugin->registerMenu('system', 'Inlislite To SLiMS', __DIR__ . '/app/routes.php');