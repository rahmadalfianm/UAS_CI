<table class="container" style=margin-top:20px;>
    <div class="col-md-12">
        <h1 style="text-align: center; margin-bottom: 30px;">Data Mahasiswa</h1>
    </div>

    <table id="list_mhs" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nim</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>
        </thead>
        <tbody id="show_data">
        <!--<?php 
            $no = 1;
            foreach ($mahasiswa as $mhs) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $mhs->nim ?></td>
                <td><?= $mhs->nama ?></td>
                <td><?= $mhs->email ?></td>
                <td><?= $mhs->jurusan ?></td>
            </tr>
            <?php 
        } ?>-->
        </tbody>
    </table>
</table>