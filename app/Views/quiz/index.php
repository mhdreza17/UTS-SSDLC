<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="game-card p-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-gamepad me-2"></i>Pilih Level Permainan
                </h2>
                <p class="text-muted">Pilih level sesuai kemampuan Anda</p>
            </div>

            <div class="row">
                <?php foreach ($levels as $level): ?>
                <div class="col-md-6 mb-4">
                    <div class="card game-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-layer-group fa-3x text-primary"></i>
                            </div>
                            <h4 class="card-title fw-bold"><?= esc($level['level_name']) ?></h4>
                            <p class="card-text text-muted"><?= esc($level['level_description']) ?></p>
                            
                            <div class="mt-4">
                                <a href="<?= base_url('quiz/level/' . $level['id']) ?>" 
                                   class="btn level-btn btn-lg w-100">
                                    <i class="fas fa-play me-2"></i>Mulai Level
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
