<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 08/10/2021 20:00
 * @File name           : Connection.php
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
 *
 */

namespace Plugin\App\InlisliteModel;


use PDO;
use Plugin\App\Models\Setting;

class Connection
{
    private static $instance = null;
    private static $instance_mysqli = null;

    private function __construct($driver = 'pdo')
    {
        try {

            // get database connection from slims db
            $setting = Setting::where('setting_name', '=', 'inlislite_db')->first();
            $db = json_decode($setting->setting_value);

            if ($driver === 'mysqli') {
                self::$instance_mysqli = new \mysqli($db->host, $db->user, $db->pass, $db->name, $db->port);
            } else {
                self::$instance = new PDO("mysql:host=".$db->host.';port='.$db->port.';dbname='.$db->name, $db->user, $db->pass);
                self::$instance->query('SET NAMES utf8');
                self::$instance->query('SET CHARACTER SET utf8');
            }

        } catch(PDOException $error) {
            echo $error->getMessage();
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }

    public static function getInstance($driver = 'pdo')
    {
        if ($driver === 'mysqli') {
            if (is_null(self::$instance_mysqli)) new Connection('mysqli');
            return self::$instance_mysqli;
        } else {
            if (is_null(self::$instance)) new Connection();
            return self::$instance;
        }
    }
}