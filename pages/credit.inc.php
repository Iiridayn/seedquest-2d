<?php if (isset($_SESSION['payment'])): ?>
Credit granted, payment key "<?= htmlspecialchars($_SESSION['payment']) ?>".
<?php else: ?>
Credit not granted
<?php endif; ?>
