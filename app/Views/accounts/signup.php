<div class="container mt-5">
    <h2 class="text-center">Sign Up</h2>

    <div id="errors" class="text-danger text-center">
        <?= validation_list_errors() ?>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <form action="/accounts/signup" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required value="<?= set_value('email') ?>">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required value="<?= set_value('username') ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required value="<?= set_value('password') ?>">
                </div>

                <div class="mb-3">
                    <label for="confirm-pass" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-pass" name="confirm-pass" placeholder="Confirm your password" required value="<?= set_value('confirm-pass') ?>">
                </div>

                <div class="mb-3">
                    <label for="birthdate" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required value="<?= set_value('birthdate') ?>">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Create account</button>
                    <a href="/accounts/login" class="btn btn-outline-secondary">Log in</a>
                </div>
            </form>
        </div>
    </div>
</div>