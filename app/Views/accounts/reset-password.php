<div class="m-5">
  <h2 class="text-center">Reset Password</h2>
  <div class ="row justify-content-center">
    <div class="col-md-4">
      <?= form_open('/reset-password', '', ['reset-token' => $token]) ?>
        <?= csrf_field() ?>
  
        <div class="mb-3">
          <?= form_label('New password', 'password', ['class' => 'form-label']) ?>
          <?= form_input('password', set_value('password', '', false), ['id' => 'password', 'class' => 'form-control', 'required' => true], 'password') ?>
        </div>

        <div class="mb-3">
          <?= form_label('Confirm password', 'confirm-password', ['class' => 'form-label']) ?>
          <?= form_password('confirm-password', set_value('confirm-password', '', false), ['id' => 'confirm-password', 'class' => 'form-control', 'required' => true]) ?>
  
          <div class="text-danger">
            <?= validation_list_errors() ?>
          </div>
        </div>
        <?= form_submit('submit', 'Submit', ['class' => 'btn btn-primary']) ?>
      <?= form_close() ?>
    </div>
  </div>
</div>