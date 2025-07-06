<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="game-card p-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-trophy me-2"></i>Leaderboard
                </h2>
                <p class="text-muted">Peringkat Pemain Terbaik</p>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Rank</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th>Skor</th>
                            <th>Persentase</th>
                            <th>Waktu</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topScores as $index => $result): ?>
                        <tr>
                            <td>
                                <?php if ($index == 0): ?>
                                    <i class="fas fa-crown text-warning"></i> #1
                                <?php elseif ($index == 1): ?>
                                    <i class="fas fa-medal text-secondary"></i> #2
                                <?php elseif ($index == 2): ?>
                                    <i class="fas fa-medal text-warning"></i> #3
                                <?php else: ?>
                                    #<?= $index + 1 ?>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold"><?= esc($result['player_name']) ?></td>
                            <td><span class="badge bg-primary"><?= esc($result['level_name']) ?></span></td>
                            <td><?= $result['score'] ?> / <?= $result['total_questions'] ?></td>
                            <td>
                                <?php 
                                $percentage = round(($result['score'] / $result['total_questions']) * 100);
                                $badgeClass = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= $percentage ?>%</span>
                            </td>
                            <td>
                                <?php
                                $minutes = floor($result['time_taken'] / 60);
                                $seconds = $result['time_taken'] % 60;
                                echo sprintf("%02d:%02d", $minutes, $seconds);
                                ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($result['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="<?= base_url('quiz') ?>" class="btn level-btn btn-lg">
                    <i class="fas fa-play me-2"></i>Main Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
