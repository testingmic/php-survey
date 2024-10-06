<?php
include_once 'headtags.php';

$menu_pages = [
    'account' => 'Account Details',
    'password' => 'Change Password',
    'activity_logs' => 'Activity Logs',
    'login_history' => 'Login History',
    'delete' => 'Delete Account',
];
?>
<div class="container main-content pt-4 mb-4">
    <div class="header">
        <?php foreach($pages as $page => $name) { ?>
            <span <?= $page == $path ? 'class="active"' : '' ?>>
                <a href="<?= $baseURL; ?><?= $page ?>"><?= $name ?></a>
            </span>
        <?php } ?>
    </div>
    <div class="content">
        <div class="content-title">Account Summary</div>
        <div class="row">
            <div class="col-lg-3 col-md-5 mb-3">
                <div class="card">
                    <div class="card-header">
                        Account Menu
                    </div>
                    <div class="card-body">
                        <?php foreach($menu_pages as $page => $name) { ?>
                            <div class="side-menu <?= $page == $path ? 'active disabled' : '' ?>">
                                <a class="<?= $page == $path ? 'active disabled' : '' ?>" href="<?= $baseURL ?>account/<?= $page ?>">
                                    <?= $name ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="<?= in_array($path, ['password', 'account']) ? 'col-lg-5 col-md-7' : 'col-lg-9 col-md-7' ?> mb-3">
                <div class="card">

                    <div class="card-header">
                        <?= $menu_pages[$path] ?>
                    </div>
                    <div class="card-body">
                        <?= form_overlay() ?>

                        <?php if(in_array($path, ['account'])) { ?>
                            <form class="appForm" method="PUT" action="<?= $baseURL ?>api/users/update">
                                <div class="form-group mb-3">
                                    <label for="company">Company Name</label>
                                    <input type="text" class="form-control" id="company" name="company" value="<?= $user['client']['name'] ?? null ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Fullname</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?? null ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?? null ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= $user['client']['address'] ?? null ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $user['phone'] ?? null ?>">
                                </div>
                                <input type="hidden" name="client_id" value="<?= $user['client']['id'] ?? null ?>">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?? null ?>">
                                <div class="form-group text-center">
                                    <button class="btn btn-success signup-button"><i class="fa fa-user-cog"></i> Update Account</button>
                                </div>
                            </form>
                        <?php } ?>

                        <?php if($path == 'password') { ?>
                            <form class="appForm" method="POST" action="<?= $baseURL ?>api/users/changepassword">
                                <div class="form-group mb-3">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password_confirm">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                                </div>
                                <div class="form-group text-center">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?? null ?>">
                                    <input type="hidden" name="client_id" value="<?= $user['client']['id'] ?? null ?>">
                                    <button class="btn btn-success signup-button"><i class="fa fa-user-cog"></i> Change Password</button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'foottags.php'; ?>