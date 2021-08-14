<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $heading; ?></h1>
    </div>

    <?php if (!empty($this->session->flashdata('success'))) : ?>
    <div class="alert alert-success" role="alert">
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>

    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <div class="row">
        <div class="col-lg">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newsubMenuModal">Tambah Submenu
                Baru</a>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Submenu</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Url</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Aktif</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($subMenu as $sm) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $sm['submenu']; ?></td>
                        <td><?= $sm['menu']; ?></td>
                        <td><?= $sm['url']; ?></td>
                        <td><i class="<?= $sm['icon']; ?>"></i></td>
                        <td><?= $sm['is_active']; ?></td>
                        <td>
                            <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editSubmenuModal<?= $sm['id']; ?>">edit</a>
                            <form action="<?= base_url('menu/submenu-delete/' . $sm['id']); ?>" method="post"
                                class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('apakah anda yakin?')">delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="newsubMenuModal" tabindex="-1" role="dialog" aria-hidden="true"
        aria-labelledby="newsubMenuModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsubMenuModalLabel">Tambah Submenu Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/submenu'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="submenu" id="submenu"
                                placeholder="Nama submenu...">
                        </div>
                        <div class="form-group">
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">Pilih Menu</option>
                                <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="url" id="url" placeholder="Url submenu...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon submenu...">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" value="1" name="is_active"
                                    id="is_active" checked>
                                <label for="is_active" class="form-check-label">Aktif?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php foreach ($subMenu as $esm) : ?>
    <div class="modal fade" id="editSubmenuModal<?= $esm['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true"
        aria-labelledby="editSubmenuModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubmenuModalLabel">Edit Submenu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/submenu-edit/' . $esm['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="submenu" id="submenu"
                                value="<?= $esm['submenu']; ?>">
                        </div>
                        <div class="form-group">
                            <select name="menu_id" id="menu_id" class="form-control">
                                <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"
                                    <?= ($m['id'] == $esm['menu_id']) ? "selected" : ""; ?>>
                                    <?= $m['menu']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="url" id="url" value="<?= $esm['url']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="icon" id="icon" value="<?= $esm['icon']; ?>">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" value="1" name="is_active"
                                    id="is_active" <?= ($esm['is_active'] == 1) ? "checked" : ""; ?>>
                                <label for="is_active" class="form-check-label">Aktif?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- /.container-fluid -->