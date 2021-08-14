<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $heading; ?></h1>
    </div>
    <?= form_error('menu', '<div class="alert alert-danger">', '</div>'); ?>

    <?php if (!empty($this->session->flashdata('success'))) : ?>
    <div class="alert alert-success" role="alert">
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>



    <div class="row">
        <div class="col-lg-6">
            <h5>Role: <?= $role['role']; ?></h5>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($menu as $m) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $m['menu']; ?></td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    <?= (check_access($role['id'], $m['id'])) ? 'checked' : ''; ?>
                                    data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>"
                                    data-hash="<?= $this->security->get_csrf_hash(); ?>">
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?= base_url('menu/role'); ?>" class="btn btn-primary">Kembali</a>
        </div>
    </div>

</div>

<script>
$('.form-check-input').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');
    const csrfHash = $(this).data('hash');

    console.log(menuId + ' ' + roleId);
    $.ajax({
        url: "<?= base_url('admin/changeAccess'); ?>",
        type: 'post',
        data: {
            <?= $this->security->get_csrf_token_name(); ?>: csrfHash,
            menuId: menuId,
            roleId: roleId,
        },
        success: function() {
            document.location.href = "<?= base_url('admin/role-access/'); ?>" + roleId;
        }
    });
});
</script>