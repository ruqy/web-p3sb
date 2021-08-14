<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $heading; ?></h1>
    </div>

    <?php if (!empty($this->session->flashdata('success'))) : ?>
    <div class="alert alert-success" role="alert" style="max-width:540px;">
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($this->session->flashdata('error'))) : ?>
    <div class="alert alert-danger" role="alert" style="max-width:540px;">
        <?= $this->session->flashdata('error'); ?>
    </div>
    <?php endif; ?>

    <div class=" card mb-3" style="max-width:540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('asset/img/profil/' . $user['image']); ?>" alt="<?= $user['image']; ?>"
                    class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title"><?= $user['name']; ?> (<?= $role['role']; ?>)</h3>
                    <p class="card-text"><?= $user['email']; ?></p>
                    <p class="card-text"><small class="text-muted">Bergabung dari tahun
                            <?= date('Y', $user['created_at']); ?></small></p>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($task)) { ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tugas</h6>
        </div>
        <div class="card-body">
            <?php foreach ($task as $d) : ?>
            <h4 class="small font-weight-bold"><?= $d['task']; ?> <span class="float-right">20%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php } ?>
</div>
<!-- /.container-fluid -->