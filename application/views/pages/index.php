<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <h1 class="m-0 text-dark"></h1>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <form action="<?= base_url('index/search') ?>" method="post">
                        <div class="row d-flex justify-content-end">
                            <div class="col-4">
                                <label>Filter</label>
                                <div class="row form-group mt-2">
                                    <div class="col-12">
                                        <select name="cabang" class="form-control">
                                            <option value="" disabled selected>Pilih Cabang</option>
                                            <?php foreach ($data_cabang as $key => $cabang) : ?>
                                                <?php if ($cabang['id'] == $session_cabang) : ?>
                                                    <option value="<?= $cabang['id'] ?>" selected><?= $cabang['name'] ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $cabang['id'] ?>"><?= $cabang['name'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <label>Search</label>
                                <div class="row form-group mt-2">
                                    <div class="col-9">
                                        <input type="text" class="form-control" value="<?= $this->session->userdata('search') ?>" name="search">
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-success">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">ID</th>
                                    <th rowspan="2">Nama Produk</th>
                                    <th rowspan="2">Kategori</th>
                                    <th rowspan="2">Stok</th>
                                    <th colspan="3">Penjualan</th>
                                </tr>
                                <tr>
                                    <th>November</th>
                                    <th>Desember</th>
                                    <th>Januari (1-19)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $key => $product) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $product['product_variant_ids'][0] ?></td>
                                        <td><?= $product['name'] ?></td>
                                        <td><?= $product['categ_id'][1] ?></td>
                                        <td><?= $product['qty_available'] ?></td>
                                        <td><?= $product[11] ?></td>
                                        <td><?= $product[12] ?></td>
                                        <td><?= $product[1] ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p><?php echo $links; ?></p>
                    </div>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>