<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<div class="container mt-5">
    <h2 class="text-center">Forgot Password</h2>
    <div class ="row justify-content-center">
        <div class="col-md-4">
            <form action="./assets/processing_php/send_email.php" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <?php if (isset($_GET['status']) && $_GET['status'] == "email_not_found"): ?>
                        <div style='color: red;'>Email not found.</div>
                    <?php endif ?>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>