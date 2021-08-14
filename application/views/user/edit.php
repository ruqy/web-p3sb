<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $heading; ?></h1>
    </div>


    <?php if (!empty(validation_errors())) : ?>
    <div class="alert alert-danger pb-0" style="max-width: 540px;">
        <?= validation_errors(); ?>
    </div>
    <?php endif; ?>
    <div class="card mb-3" style="max-width:540px;">
        <form action="<?= base_url('user/edit'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="row no-gutters">
                <div class="col-md-4">
                    <div class="form-group">
                        <img src="<?= base_url('asset/img/profil/' . $user['image']); ?>" alt="" class="card-img p-2"
                            id="foto">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="email" id="disableInput" class="form-control"
                                value="<?= $user['email']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="<?= $user['name']; ?>">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Ubah gambar ...</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3 mb-3">Ubah</button>
                <a href="<?= base_url('user'); ?>" class="btn btn-secondary ml-2 mb-3">Batal</a>
            </div>
        </form>
    </div>
</div>