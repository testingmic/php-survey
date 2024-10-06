<?php
include_once 'headtags.php';
?>
<div class="container main-content pt-4 mb-4">
    <div class="header">
        <?php foreach($pages as $page => $name) { ?>
            <span <?= $page == 'billing' ? 'class="active"' : '' ?>>
                <a href="<?= $baseURL; ?><?= $page ?>"><?= $name ?></a>
            </span>
        <?php } ?>
    </div>
    <div class="content">
        <div class="content-title">Billing Profile</div>
        <div class="alert alert-danger">
            You have a BASIC (free) plan. Upgrade now to get unlimited questions, downloadable reports, and more.
        </div>
    </div>
</div>
<?php include_once 'foottags.php'; ?>