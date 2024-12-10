<div class="container mt-5">
    <div class="row">
        <div class="col login-bg"></div>
        <div class="col justify-content-center">
            <div class="m-5">
                <h2>Log In</h2>

                <div class="text-danger">
                    <?= validation_list_errors() ?>
                </div>
                
                <?= form_open('/login') ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <?= form_label('Email address / Username', 'name-email', ['class' => 'form-label']) ?>
                        <?= form_input ('name-email', set_value('name-email', '', false), ['id' => 'name-email', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your email or username'], 'text') ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= form_label('Password', 'password', ['class' => 'form-label']) ?>
                        <?= form_password('password', set_value('password', '', false), ['id' => 'password', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your password']) ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <?= form_submit('submit', 'Log In', ['class' => 'btn btn-primary']) ?>
                        <a href="/signup" class="btn btn-outline-secondary">Create account</a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="/forgot-password">Forgot password?</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>