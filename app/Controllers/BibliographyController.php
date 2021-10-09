<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 09/10/2021 0:59
 * @File name           : BibliographyController.php
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


use Laminas\Diactoros\Response;
use Plugin\App\InlisliteModel\Catalog;
use Plugin\App\Models\Biblio;
use Plugin\Lib\Request;

class BibliographyController
{
    function count() {
        header('Content-Type: application/json');
        echo json_encode(['total' => Catalog::count()]);
    }

    function doMigrate(Request $request, Response $response, $start, $end) {
        $start = (int) $start;
        $end = (int) $end;
        $catalogs = Catalog::where('Title', '!=', '')->limit($end - $start)->offset($start)->get();
        foreach ($catalogs as $catalog) {
            // map biblio
            $biblio = new Biblio;

            // map biblio author
            // map biblio topic
            // map biblio attachment
            // map item
        }
        sleep(3);
    }
}