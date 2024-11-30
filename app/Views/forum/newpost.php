<div class="container mt-5">
    <h2>Add new post</h2>
    <div class="row justify-content-center">
        <?php helper('form'); ?>
        <div class="text-danger">
            <?= validation_list_errors() ?>
        </div>
    </div>
    <?= form_open('forum/newpost', ['class' => 'row']); ?>
        <?= csrf_field() ?>
        <div class = "col-8">
            <?= form_textarea([
                'name' => 'body',
                'id' => 'body',
                'class' => 'form-control',
                'placeholder' => 'Body'
            ]); ?>
        </div>
        <div class = "col-4">
            <?= form_input([
                'name' => 'title',
                'id' => 'title',
                'class' => 'form-control',
                'placeholder' => 'Title'
            ]); ?>
            <?= form_submit([
                'value' => 'Add Post',
                'class' => 'btn btn-primary mt-2'
            ]); ?>
        </div>
    <?= form_close(); ?>
</div>