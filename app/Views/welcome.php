<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 26/06/2021 2:26
 * @File name           : welcome.php
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

use Plugin\Lib\Url;

?>

<div class="container-fluid py-3">
    <h2>Inlislite to SLiMS</h2>
    <div class="pt-3">
        <strong>PERHATIAN!</strong>
        <ul class="list-style pl-3 py-0 mt-0">
            <li>Pastikan SLiMS yang anda pakai ini adalah SLiMS yang baru saja diinstall (<i>Fresh install</i> /databasenya masih kosong)</li>
            <li>Isikan informasi database Inlislite anda pada form dibawah ini. Dan lakukan cek koneksi.</li>
            <li>Jika koneksi berhasil, tinggal klik jalankan migrasi</li>
        </ul>
    </div>

    <div class="card card-body mb-3">
        <form class="row" action="<?= Url::adminSection('/check-connection') ?>" method="post" target="blindSubmit">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="host">Host</label>
                    <input name="host" value="<?= $config->host ?? 'localhost' ?>" type="text" class="form-control" id="host" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="port">Port</label>
                    <input name="port" value="<?= $config->port ?? 3309 ?>" type="number" class="form-control" id="port" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="nama_db">Nama Database</label>
                    <input name="name" value="<?= $config->name ?? 'inlislite_v3' ?>" type="text" class="form-control" id="nama_db" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="user_db">User Database</label>
                    <input name="user" value="<?= $config->user ?? 'root' ?>" type="text" class="form-control" id="user_db" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="pass_db">Password Database</label>
                    <input name="pass" type="password" class="form-control" id="pass_db" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">&nbsp;</label>
                    <button type="submit" class="form-control btn btn-outline-primary">Cek Koneksi</button>
                </div>
            </div>
        </form>
        <hr>
        <button id="runMigration" class="btn btn-block btn-success">JALANKAN MIGRASI SEKARANG</button>
    </div>

    <div class="card card-body text-white bg-dark">
        <div class="index-log-cat infoBox" style="background-color: transparent; color: white; font-size: 10pt"></div>
    </div>
</div>
<script>
    (function ($) {
        'use strict'
        const container = $('.index-log-cat')
        $('#runMigration').on('click', async function (e) {
            log(container, 'info', 'Initialize migrator')
            let total = 0, iterator = 0, interval = 100

            // disable this button
            $(this).prop('disabled', true)

            /**
             * ===================================
             * START MIGRATE BIBLIOGRAPHY DATA
             * ===================================
             */
            log(container, 'info', 'Try to migrate bibliography data')
            // - get total of biblio
            log(container, 'info', 'Get total of Inlislite bibliography')
            let res = await fetch(`<?= Url::adminSection('/total/biblio') ?>`)
            res = await res.json()
            total = res.total
            log(container, 'success', 'Total bibliography is ' + total)
            // - run migration per batch
            iterator = Math.ceil(total / interval)
            let i = 0
            let action = async () => {
                let start = i * interval
                let end = () => {
                    let endTmp = (i + 1) * interval
                    if (endTmp > total) return total
                    return endTmp
                }
                log(container, 'info',  `Migrating bibliography from ${start} to ${end()}.`)
                res = await fetch(`<?= Url::adminSection('/migrate/biblio/') ?>${start}/${end()}`)
                i++
                if (i < iterator) await action()
            }
            await action()
            log(container, 'success',  `Migrating bibliography done!`)

            /**
             * ===================================
             * START MIGRATE MEMBER DATA
             * ===================================
             */
            // - get total of member
            // - run migration per batch

            /**
             * ===================================
             * START MIGRATE LOAN DATA
             * ===================================
             */
            // - get total of loans
            // - run migration per batch

            /**
             * ===================================
             * START MIGRATE VISITOR DATA
             * ===================================
             */
            // - get total of visitor
            // - run migration per batch

            // enable after finish
            $(this).prop('disabled', false)
        })

    })(jQuery);
</script>