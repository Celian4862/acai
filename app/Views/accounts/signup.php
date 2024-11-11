<?php
// Helper function to display error messages
function check_valid(string $session_var) {
    return isset($_SESSION[$session_var]) && $_SESSION[$session_var];
}
?>

<div class="container mt-5">
    <h2 class="text-center">Sign Up</h2>

    <div id="errors" class="text-danger text-center">
        <?= session()->getFlashdata('error') ?>
        <?= validation_list_errors() ?>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <form action="/accounts/signup" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required value="<?= set_value('email') ?>">
                    <!-- DISPLAY ERROR MESSAGE -->
                    <?php if (check_valid("email-exists")) { ?>
                        <div class="text-danger">Email already exists.</div>
                    <?php } else if (check_valid("invalid-email")) { ?>
                        <div class="text-danger">Invalid email format.</div>
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required value="<?= set_value('username') ?>">
                    <!-- DISPLAY ERROR MESSAGE -->
                    <?php if (check_valid("name-exists")) { ?>
                        <div class="text-danger">Username already exists.</div>
                    <?php } else if (check_valid("invalid-name")) { ?>
                        <div class="text-danger">Username can only contain letters, numbers, and underscores.</div>
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required value="<?= set_value('password') ?>">
                    <!-- DISPLAY ERROR MESSAGE -->
                    <?php if (check_valid("invalid-password")) { ?>
                        <div class="text-danger">Password must either be at least 16 characters long or should contain at least one lowercase letter, one uppercase letter, one special character, and one number, and can be 8 - 15 characters long.</div>
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <label for="confirm-pass" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-pass" name="confirm-pass" placeholder="Confirm your password" required value="<?= set_value('confirm-pass') ?>">
                    <!-- DISPLAY ERROR MESSAGE -->
                    <?php if (check_valid("password-nomatch")) { ?>
                        <div class="text-danger">Passwords do not match.</div>
                    <?php } ?>
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