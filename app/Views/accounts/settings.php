<div class="container mt-5">
    <h2 class="text-center">User Settings</h2>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form action="/accounts/settings" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= session()->get('email') ?>" />
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control" id="username" name="username" value="<?= session()->get('username') ?>" />
                </div>
                <div class="mb-3">
                    <label for="old-pass" class="form-label">Old password</label>
                    <input type="password" class="form-control" id="old-pass" name="old-pass" />
                </div>
                <div class="mb-3">
                    <label for="new-pass" class="form-label">New password</label>
                    <input type="password" class="form-control" id="new-pass" name="new-pass" />
                </div>
                <div class="mb-3">
                    <label for="conf-new-pass" class="form-label">Confirm new password</label>
                    <input type="password" class="form-control" id="conf-new-pass" name="conf-new-pass" />
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= session()->get('birthdate') ?>" />
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>