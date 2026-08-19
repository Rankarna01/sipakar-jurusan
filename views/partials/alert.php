<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show alert-auto-dismiss"><i class="bi bi-check-circle-fill me-2"></i><?= clean($_SESSION['success']); unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show alert-auto-dismiss"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= clean($_SESSION['error']); unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
