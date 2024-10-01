<?php
include_once 'headtags.php';

global $AppName, $baseURL;
?>
<?= dashboard_header($baseURL, false) ?>
<div class='dialog-container'>
    <div class='card card-width mb-5'>
        <div class='card-content text-center position-relative'>
            <?= form_overlay() ?>
            <h3 class="border-bottom pb-2 border-primary">Create an Account</h3>
            <form class="appForm" action="<?= $baseURL ?>api/auth/signup">
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control text-center">
                </div>
                <div class="form-group mb-2">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control text-center">
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control text-center">
                </div>
                <div class="form-group">
                    <button class="btn btn-success signup-button"><i class="fa fa-user-cog"></i> Create Account</button>
                </div>
            </form>
        </div>
        <div class='card-footer'>
            <a class="card-footer-item" href="<?= $baseURL ?>login">Already have an account?</a>
        </div>
    </div>
</div>
<?php include_once 'foottags.php'; ?>