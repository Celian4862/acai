<div class="container mt-5">
    <h2>Add new post</h2>
    <div class="row justify-content-center">
        <?php helper('form'); ?>
        <div class="text-danger">
            <?= validation_list_errors() ?>
        </div>
    </div>
    <?= form_open_multipart('/forum/newpost', ['class' => 'row']); ?>
        <?= csrf_field() ?>
        <div class="col">
            <div class="mb-3">
                <?= form_input('title', set_value('title', '', false), ['class' => 'form-control', 'placeholder' => 'Title', 'required' => true]); ?>
            </div>
            <div class="mb-3">
                <?= form_textarea('body', set_value('body', '', false), ['class' => 'form-control', 'placeholder' => 'Body', 'required' => true]); ?>
            </div>

            <div id="add-file" class="mb-3">
                <button type="button" class="btn btn-primary" onclick="addFile()">Add Image</button>
            </div>

            <div class="mb-3">
                <?= form_submit('submit', 'Add Post', ['class' => 'btn btn-primary mt-2']); ?>
            </div>
        </div>
    <?= form_close(); ?>
</div>