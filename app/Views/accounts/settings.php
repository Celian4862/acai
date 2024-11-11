<?php helper('form'); ?>

<div class="container mt-5">
    <h2 class="text-center">User Settings</h2>
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="text-danger">
                <?= validation_list_errors() ?>
            </div>

            <?= form_open('accounts/settings') ?>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= ($_SERVER['REQUEST_METHOD'] === 'GET') ? session()->get('email') : set_value('email'); ?>" />
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control" id="username" name="username" required value="<?= ($_SERVER['REQUEST_METHOD'] === 'GET') ? session()->get('username') : set_value('username') ?>" />
                </div>

                <div class="mb-3">
                    <label for="old-pass" class="form-label">Old pass</label>
                    <input type="password" class="form-control" id="old-pass" name="old-pass" value="<?= set_value('old-pass') ?>" />
                </div>

                <div class="mb-3">
                    <label for="new-pass" class="form-label">New pass</label>
                    <input type="password" class="form-control" id="new-pass" name="new-pass" value="<?= set_value('new-pass') ?>" />
                </div>

                <div class="mb-3">
                    <label for="conf-new-pass" class="form-label">Confirm new pass</label>
                    <input type="password" class="form-control" id="confirm-pass" name="confirm-pass" value="<?= set_value('confirm-pass') ?>" />
                </div>

                <div class="mb-3">
                    <label for="birthdate" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required value="<?= ($_SERVER['REQUEST_METHOD'] === 'GET') ? session()->get('birthdate') : set_value('birthdate') ?>" />
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            <?= form_close() ?>
        </div>
    </div>
</div>