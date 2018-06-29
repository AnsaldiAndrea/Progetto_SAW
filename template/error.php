<?php if(isset($_SESSION['error'])) : ?>
    <div class="alert alert-<?= $_SESSION['error'][0]?> alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= $_SESSION['error'][1]; unset($_SESSION['error']) ?>
    </div>
<?php endif ?>