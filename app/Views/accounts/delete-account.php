<?php helper('form'); ?>

<h1 class="text-danger">Are you sure want to delete your account?</h1>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="text-danger text-center">
                <?= session()->getFlashdata('error') ?>
            </div>

            <?= form_open('/accounts/delete-account') ?>
                <?= csrf_field() ?>

                <div class="d-flex justify-content-between">
                    <a href="/accounts/settings" class="btn btn-primary">No</a>
                    <?= form_submit('submit', 'Yes', ['class' => 'btn btn-outline-danger']) ?>
                </div>

            <?= form_close() ?>

        </div>
    </div>
</div>