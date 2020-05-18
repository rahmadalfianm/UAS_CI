<div class="container">
<?php if ($this->session->flashdata('flash-data')) : ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">Data Mahasiswa
                <strong>Berhasil</strong> <?= $this->session->flashdata('flash-data'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
</div>
</div>
</div>
<?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-6">
            <a href="<?= base_url(); ?>mahasiswa/tambah"class="btn btn-primary">Tambah Data</a>
</div>
</div>

<div class="row mt-3">
<div class="col-md-6">
<form action="" method="post">
<div class="input-group">
  <input type="text" class="form-control" placeholder="Cari Data Mahasiswa" name="keyword">
  <div class="input-group-append">
    <button class="btn btn-primary" type="submit" >Cari</button>
  </div>
</div>
</form>
</div>
</div>

    <div class="row mt-3">
        <div class="col-md-8">
            <h2>Daftar Mahasiswa</h2>

            <!-- Alert -->
            <?php if (empty($mahasiswa)) : ?>
                <div class="alert alert-danger" role="alert">
                    Data Mahasiswa Tidak Ditemukan
                </div>
            <?php endif; ?>

            <ul class="list-group">
                <li class="list-group-item">
                    <table class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col">No</th> -->
                                <th scope="col">NO</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Mata Kuliah</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($mahasiswa as $mhs) : ?>
                                <tr>
                                    <!-- <th scope="row"><?= $mhs['id_mengampu']; ?></th> -->
                                    <td><?= $no ?></td>
                                    <td><?= $mhs['nim']; ?></td>
                                    <td><?= $mhs['nama']; ?></td>
                                    <td><?= $mhs['nama_matkul']; ?></td>
                                    <td><?= $mhs['nama_kelas']; ?></td>
                                    <td>
                                        <a href="<?= base_url(); ?>mahasiswa/hapus/<?= $mhs['id_mengampu']; ?>/<?= $mhs['id']; ?>" class="badge badge-danger float-right" onclick="return confirm('Yakin Data ini akan dihapus?');">Hapus</a>
                                        <a href="<?= base_url(); ?>mahasiswa/edit/<?= $mhs['id']; ?>" class="badge badge-success float-right">Edit</a>
                                        <a href="<?= base_url(); ?>mahasiswa/detail/<?= $mhs['id_mengampu']; ?>" class="badge badge-primary float-right">Detail</a>
                                    </td>
                                </tr>
                            <?php $no += 1;
                            endforeach; ?>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>
    </div>
