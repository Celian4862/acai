<div class="container mt-5">
    <h2 class="text-center">Forgot Password</h2>
    <div class ="row justify-content-center">
        <div class="col-md-4">
            <form action="/accounts/forgot-password" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= set_value('email') ?>">

                    <div class="text-danger">
                        <?= session()->getFlashdata('error') ?>
                        <?= validation_list_errors() ?>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>