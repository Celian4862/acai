<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-1"></div>
        <h4 class="col"><a href="<?= site_url('/forum') ?>" class="text-decoration-none text-black">< Back</a></h>
    </div>
    <div class="row justify-content-center">
        <h2 class="col-md p-0 inline-block mb-3 text-center"><?= esc($post['title']) ?></h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text"><?= esc($post['body']) ?></p>
                    <div>
                        <div class="d-flex justify-content-between">
                            <span class="card-text text-muted">Posted by: <?= esc($op_name) ?></span>
                            <span class="card-text text-muted">Last updated <?= esc($post['updated_at']) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (session()->has('logged_in') && session()->get('logged_in') === true): ?>
                <h3 class="mb-3">Add Comment</h3>
                <div class="text-danger">
                    <?= validation_list_errors() ?>
                </div>
                <?= form_open('/forum/comment/' . esc($post['id'])) ?>
                    <?= csrf_field() ?>
                    <div class="form-group mb-3">
                        <?= form_textarea('comment', set_value('comment', '', false), ['class' => 'form-control', 'rows' => 3, 'required' => true, 'placeholder' => 'Add your thoughts...']) ?>
                    </div>
                    <?= form_submit('submit', 'Submit', ['class' => 'btn btn-primary mb-3']) ?>
                <?= form_close() ?>
            <?php else: ?>
                <p class=""><a href="<?= site_url('login') ?>">Login</a> to add a comment.</p>
            <?php endif ?>

            <h3 class="mb-3">Comments</h3>
            <?php if (! empty($comments) && is_array($comments)) : ?>
                <?php foreach ($comments as $comment) : ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text"><?=esc($comment['comment']) ?></p>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <span class="card-text text-muted">Posted by: <?= esc($comment['username']); ?></span>
                                    <span class="card-text text-muted">Last updated <?= esc($comment['updated_at']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
          <p>No comments found.</p>
            <?php endif ?>
        </div>
    </div>
</div>