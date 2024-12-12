<div class="container mt-5">
    <div class="row justify-content-center">
        <h4 class="col"><a href="<?= "/forum/posts/{$comment['post_id']}" ?>" class="text-decoration-none text-black">< Back</a></h>
    </div>
    <div class="row justify-content-center">
        <h2 class="mb-3">Edit comment</h2>
    </div>
    <div class="row justify-content-center">
        <?php helper('form'); ?>
        <div class="text-danger">
            <?= validation_list_errors() ?>
        </div>
    </div>
    <?= form_open("/forum/comment/edit/{$comment['id']}", ['class' => 'row']); ?>
        <?= csrf_field() ?>
        <div class="col">
            <div class="mb-3">
                <?= form_textarea('comment', set_value('comment', $comment['comment'], false), ['class' => 'form-control', 'rows' => 3, 'required' => true, 'placeholder' => 'Edit your comment...']); ?>
            </div>
            <div class="mb-3">
                <?= form_submit('submit', 'Edit Comment', ['class' => 'btn btn-primary mt-2']); ?>
            </div>
        </div>
    <?= form_close() ?>
</div>