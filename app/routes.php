<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 26/06/2021 0:57
 * @File name           : routes.php
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

use Plugin\App\Controllers\BibliographyController;
use Plugin\App\Controllers\WelcomeController;

// create new router instance
$router = new \Plugin\Lib\Router();

// register routes
$router->get('/', [WelcomeController::class, 'index']);
$router->post('/check-connection', [WelcomeController::class, 'checkConnection']);
$router->get('/total/biblio', [BibliographyController::class, 'count']);
$router->get('/migrate/biblio/[*:start]/[*:end]', [BibliographyController::class, 'doMigrate']);

// run router
$router->run();
