<div class="container mt-5 p=0 m-0">
    <div class="row justify-content-center vw-100 vh-100 signup-bg"> 
        <div class="col"> </div>
        <div class="col align-self-center field-bubble">
                <div class="m-5">
                    <h2 class="text-center">Sign Up</h2>
                    <div class="text-danger">
                        <?= validation_list_errors() ?>
                    </div>
                
                    <?= form_open('/signup') ?>
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <?= form_label('Email address', 'email', ['class' => 'form-label']) ?>
                            <?= form_input('email', set_value('email', '', false), ['id' => 'email', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your email'], 'email') ?>
                        </div>

                        <div class="mb-3">
                            <?= form_label('Username', 'username', ['class' => 'form-label']) ?>
                            <?= form_input('username', set_value('username', '', false), ['id' => 'username', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your username'], 'text') ?>
                        </div>

                        <div class="mb-3">
                            <?= form_label('Password', 'password', ['class' => 'form-label']) ?>
                            <?= form_password('password', set_value('password', '', false), ['id' => 'password', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter your password']) ?>
                        </div>

                        <div class="mb-3">
                            <?= form_label('Confirm Password', 'confirm-pass', ['class' => 'form-label']) ?>
                            <?= form_password('confirm-pass', set_value('confirm-pass', '', false), ['id' => 'confirm-pass', 'class' => 'form-control', 'required' => true, 'placeholder' => 'Confirm your password']) ?>
                        </div>

                        <div class="mb-3">
                            <?= form_label('Date of Birth', 'birthdate', ['class' => 'form-label']) ?>
                            <?= form_input('birthdate', set_value('birthdate', '', false), ['id' => 'birthdate', 'class' => 'form-control', 'required' => true], 'date') ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <?= form_submit('submit', 'Create account', ['class' => 'btn btn-primary']) ?>
                            <a href="/login" class="btn btn-outline-secondary">Log in</a>
                        </div>
                    <?= form_close() ?>
                </div>
        </div>
        <div class="col"> </div>
    </div>
    
</div>