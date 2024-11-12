<?php helper('form'); ?>

<div class="container mt-5">
    <h2 class="text-center">User Settings</h2>
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="text-danger">
                <?= validation_list_errors() ?>
            </div>

            <div class="text-success text-center">
                <?= session()->getFlashdata('success') ?>
            </div>

            <?= form_open('/accounts/settings') ?>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <?= form_label('Email', 'email', ['class' => 'form-label']) ?>
                    <?= form_input('email', set_value('email', session()->get('email'), false), ['id' => 'email', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your email'], 'email') ?>
                </div>

                <div class="mb-3">
                    <?= form_label('Username', 'username', ['class' => 'form-label']) ?>
                    <?= form_input('username', set_value('username', session()->get('username'), false), ['id' => 'username', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your username'], 'text') ?>
                </div>

                <div class="mb-3">
                    <?= form_label('Old pass', 'old-pass', ['class' => 'form-label']) ?>
                    <?= form_password('old-pass', set_value('old-pass', '', false), ['id' => 'old-pass', 'class' => 'form-control', 'placeholder' => 'Enter your old password']) ?>
                </div>

                <div class="mb-3">
                    <?= form_label('New password', 'new-pass', ['class' => 'form-label']) ?>
                    <?= form_password('new-pass', set_value('new-pass', '', false), ['id' => 'new-pass', 'class' => 'form-control', 'placeholder' => 'Enter your new password']) ?>
                </div>

                <div class="mb-3">
                    <?= form_label('Confirm password', 'confirm-pass', ['class' => 'form-label']) ?>
                    <?= form_password('confirm-pass', set_value('confirm-pass', '', false), ['id' => 'confirm-pass', 'class' => 'form-control', 'placeholder' => 'Confirm your new password']) ?>
                </div>

                <div class="mb-3">
                    <?= form_label('Date of Birth', 'birthdate', ['class' => 'form-label']) ?>
                    <?= form_input('birthdate', set_value('birthdate', session()->get('birthdate'), false), ['id' => 'birthdate', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your date of birth'], 'date') ?>
                </div>

                <div class="d-flex justify-content-between">
                    <?= form_submit('submit', 'Update', ['class' => 'btn btn-primary']) ?>
                    <a href="/accounts/delete-account" class="btn btn-outline-danger">Delete account</a>
                </div>

            <?= form_close() ?>
        </div>
    </div>
</div>