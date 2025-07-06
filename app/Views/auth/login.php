<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="game-card p-5">
            <div class="text-center mb-4">
                <i class="fas fa-sign-in-alt fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold text-primary">Login</h2>
                <p class="text-muted">Masuk ke akun Anda</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?= form_open('auth/attemptLogin') ?>
                <div class="mb-3">
                    <label for="login" class="form-label">Username atau Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control <?= isset($errors['login']) ? 'is-invalid' : '' ?>" 
                               id="login" name="login" value="<?= old('login') ?>" required>
                        <?php if (isset($errors['login'])): ?>
                            <div class="invalid-feedback"><?= $errors['login'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                               id="password" name="password" required>
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn level-btn btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </div>
            <?= form_close() ?>

            <div class="text-center">
                <p class="text-muted">Belum punya akun? 
                    <a href="<?= base_url('auth/register') ?>" class="text-primary fw-bold">Daftar di sini</a>
                </p>
                <a href="<?= base_url() ?>" class="text-muted">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
