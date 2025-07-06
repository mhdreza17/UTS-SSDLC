<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="game-card p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold text-primary mb-2">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </h2>
                    <p class="text-muted mb-0">Selamat datang kembali, <?= esc(session()->get('full_name')) ?>!</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i><?= esc(session()->get('username')) ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('auth/profile') ?>">
                                <i class="fas fa-user me-2"></i>Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-4 mb-4">
        <div class="game-card p-4 text-center">
            <i class="fas fa-trophy fa-2x text-warning mb-3"></i>
            <h4 class="fw-bold"><?= count($userProgress) ?></h4>
            <p class="text-muted mb-0">Level Diselesaikan</p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="game-card p-4 text-center">
            <i class="fas fa-star fa-2x text-success mb-3"></i>
            <h4 class="fw-bold">
                <?php 
                $totalScore = 0;
                foreach($userProgress as $progress) {
                    $totalScore += $progress['best_score'];
                }
                echo $totalScore;
                ?>
            </h4>
            <p class="text-muted mb-0">Total Skor Terbaik</p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="game-card p-4 text-center">
            <i class="fas fa-clock fa-2x text-info mb-3"></i>
            <h4 class="fw-bold">
                <?php 
                $totalAttempts = 0;
                foreach($userProgress as $progress) {
                    $totalAttempts += $progress['attempts'];
                }
                echo $totalAttempts;
                ?>
            </h4>
            <p class="text-muted mb-0">Total Percobaan</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Available Levels -->
    <div class="col-lg-8 mb-4">
        <div class="game-card p-4">
            <h4 class="fw-bold text-primary mb-4">
                <i class="fas fa-gamepad me-2"></i>Level Tersedia
            </h4>
            
            <div class="row">
                <?php foreach ($allLevels as $level): ?>
                    <?php 
                    $completed = false;
                    $bestScore = 0;
                    $attempts = 0;
                    
                    foreach($userProgress as $progress) {
                        if($progress['level_id'] == $level['id']) {
                            $completed = true;
                            $bestScore = $progress['best_score'];
                            $attempts = $progress['attempts'];
                            break;
                        }
                    }
                    ?>
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold"><?= esc($level['level_name']) ?></h5>
                                    <?php if ($completed): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Selesai
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Belum Dimulai</span>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="card-text text-muted small"><?= esc($level['level_description']) ?></p>
                                
                                <?php if ($completed): ?>
                                    <div class="row text-center mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">Skor Terbaik</small>
                                            <div class="fw-bold text-success"><?= $bestScore ?></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Percobaan</small>
                                            <div class="fw-bold text-info"><?= $attempts ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?= base_url('quiz/level/' . $level['id']) ?>" 
                                   class="btn <?= $completed ? 'btn-outline-primary' : 'level-btn' ?> w-100">
                                    <i class="fas fa-play me-2"></i>
                                    <?= $completed ? 'Main Lagi' : 'Mulai Level' ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-4 mb-4">
        <div class="game-card p-4">
            <h4 class="fw-bold text-primary mb-4">
                <i class="fas fa-history me-2"></i>Aktivitas Terakhir
            </h4>
            
            <?php if (empty($recentResults)): ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-3"></i>
                    <p>Belum ada aktivitas</p>
                    <a href="<?= base_url('quiz') ?>" class="btn btn-sm level-btn">Mulai Quiz</a>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($recentResults as $result): ?>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Quiz Level <?= $result['level_id'] ?></h6>
                                    <p class="mb-1 text-muted small">
                                        Skor: <?= $result['score'] ?>/<?= $result['total_questions'] ?>
                                        (<?= round(($result['score']/$result['total_questions'])*100) ?>%)
                                    </p>
                                    <small class="text-muted">
                                        <?= date('d M Y, H:i', strtotime($result['created_at'])) ?>
                                    </small>
                                </div>
                                <span class="badge bg-<?= $result['score'] >= ($result['total_questions'] * 0.8) ? 'success' : 'warning' ?>">
                                    <?= round(($result['score']/$result['total_questions'])*100) ?>%
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
