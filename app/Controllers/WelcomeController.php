<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 26/06/2021 1:07
 * @File name           : WelcomeController.php
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

namespace Plugin\App\Controllers;

use Plugin\App\InlisliteModel\Connection;
use Plugin\App\Models\Setting;
use Plugin\App\Views\View;
use Plugin\Lib\Request;
use Plugin\Lib\Utils;

class WelcomeController
{

    function index() {
        $setting = Setting::where('setting_name', '=', 'inlislite_db')->first();
        $config = json_decode($setting->setting_value ?? '{}');
        View::load('welcome', ['config' => $config]);
    }

    function checkConnection(Request $request) {
        try {

            // get data from input form
            $config = [
                'host' => $request->input('host')->string()->required(),
                'port' => $request->input('port')->int()->required(),
                'user' => $request->input('user')->string()->required(),
                'pass' => $request->input('pass')->string()->required(),
                'name' => $request->input('name')->string()->required()
            ];

            // save to setting slims
            $setting = Setting::where('setting_name', '=', 'inlislite_db')->first();
            if (!$setting) {
                $setting = new Setting;
                $setting->setting_name = 'inlislite_db';
            }
            $setting->setting_value = json_encode($config);
            $setting->save();

            // test connection
            if (Connection::getInstance()) {
                Utils::log('success', 'Koneksi database berhasil...');
                \utility::jsToastr('Database Connection', 'Success connect to "'.$config['name'].'" Database', 'success');
            }

        } catch (\Exception $exception) {
            Utils::log('danger', $exception->getMessage());
            \utility::jsToastr('Error Connection', $exception->getMessage(), 'error');
        }
    }
}