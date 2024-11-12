<div class="container mt-5">
    <h2 class="text-center">Forgot Password</h2>
    <div class ="row justify-content-center">
        <div class="col-md-4">
            <?= form_open('accounts/forgot-password') ?>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <?= form_label('Email', 'email', ['class' => 'form-label']) ?>
                    <?= form_input('email', set_value('email', '', false), ['id' => 'email', 'class' => 'form-control', 'required' => true], 'email') ?>

                    <div class="text-danger">
                        <?= validation_list_errors() ?>
                    </div>

                    <div class="text-success text-center">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
                <?= form_submit('submit', 'Submit', ['class' => 'btn btn-primary']) ?>
            <?= form_close() ?>
        </div>
    </div>
</div>