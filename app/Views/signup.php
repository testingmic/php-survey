<?php
include_once 'headtags.php';

global $AppName, $baseURL;
?>
<?= dashboard_header($baseURL, false, $isLoggedIn) ?>
<div class='dialog-container'>
    <div class='card card-width mb-5'>
        <div class='card-content text-center position-relative'>
            <?= form_overlay() ?>
            <h3 class="border-bottom pb-2 border-primary">Create an Account</h3>
            <form class="appForm" action="<?= $baseURL ?>api/auth/signup">
                <div class="form-group mb-3">
                    <label for="company">Company Name <span class="required">*</span></label>
                    <input type="text" name="company" maxlength="64" id="company" class="form-control text-center">
                </div>
                <div class="form-group mb-3">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" maxlength="16" id="phone" class="form-control text-center">
                </div>
                <div class="form-group mb-2">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" name="email" maxlength="64" id="email" class="form-control text-center">
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" name="password" maxlength="32" id="password" class="form-control text-center">
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