<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<div class="container mt-5">
    <div class="row">
        <div class="col login-bg"> imago dei </div>
        <div class="col justify-content-center">
            <div class = "m-5">
                <h2>Log In</h2>
                <form action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address / Username</label>
                        <input type="text" class="form-control" id="name_email" name="name_email" placeholder="Enter your email or username" required value="<?= $_SESSION['name_email'] ?? ''; ?>">
                        <?php if (isset($_SESSION["invalid_user"])) { ?>
                            <div class="form-text text-danger">User not found.</div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        <!-- DISPLAY ERROR MESSAGE -->
                        <?php if (isset($_SESSION["invalid_pass"])) { ?>
                            <div class="form-text text-danger">Wrong password.</div>
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Log In</button>
                        <a href="/signup" class="btn btn-outline-secondary">Create account</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="/forgot-password">Forgot password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>