<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="game-card p-5 text-center">
            <div class="mb-4">
                <i class="fas fa-gamepad fa-4x text-primary mb-3"></i>
                <h1 class="display-4 fw-bold text-primary">🎮 Secure the Code!</h1>
                <p class="lead text-muted">Game Quiz Keamanan Perangkat Lunak</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-code fa-2x text-info mb-3"></i>
                            <h5>Secure Coding</h5>
                            <p class="text-muted small">Pelajari dasar-dasar keamanan dalam pengembangan software</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-2x text-success mb-3"></i>
                            <h5>SSDLC</h5>
                            <p class="text-muted small">Pahami Secure Software Development Life Cycle</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-trophy fa-2x text-warning mb-3"></i>
                            <h5>Gamifikasi</h5>
                            <p class="text-muted small">Belajar sambil bermain dengan sistem poin dan level</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-5">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('dashboard') ?>" class="btn level-btn btn-lg px-5 py-3 me-3">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('quiz') ?>" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="fas fa-play me-2"></i>Mulai Quiz
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('auth/register') ?>" class="btn level-btn btn-lg px-5 py-3 me-3">
                        <i class="fas fa-user-plus me-2"></i>Daftar Gratis
                    </a>
                    <a href="<?= base_url('quiz') ?>" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="fas fa-play me-2"></i>Coba Sekarang
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
