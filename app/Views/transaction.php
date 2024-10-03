<?php
include_once 'headtags.php';
?>
<div class="container main-content pt-4 mb-4">
    <div class="header">
        <?php foreach($pages as $page => $name) { ?>
            <span <?= $page == 'transaction' ? 'class="active"' : '' ?>>
                <a href="<?= $baseURL; ?><?= $page ?>"><?= $name ?></a>
            </span>
        <?php } ?>
    </div>
    <div class="content">
        <div class="content-title">Purchase Activity</div>
        <div class="card">
            <div class="card-body">
                You don't have any invoices yet.
            </div>
        </div>
    </div>
</div>
<?php include_once 'foottags.php'; ?>