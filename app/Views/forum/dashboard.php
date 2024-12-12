<div class="container mt-5">
    <h2 class="text-center">Your Posts</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mt-3 text-center">
                <div class="card-body">
                    <a href="/forum/newpost" class="btn btn-primary">+ Add new post</a>
                </div>
            </div>
            <?php foreach ($posts as $post): ?>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title"><?= esc($post['title']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= esc($post['body']) ?></p>
                    </div>
                    <div class="card-footer d-flex">
                        <a href="/forum/posts/<?= esc($post['id'], 'url') ?>" class="btn btn-primary me-2">View Post</a>
                        <a href="/forum/posts/edit/<?= esc($post['id'], 'url') ?>" class="btn btn-warning me-2">Edit</a>
                        <?= form_open("/forum/posts/delete/{$post['id']}") ?>
                            <?= csrf_field() ?>
                            <?= form_submit('submit', 'Delete', ['class' => 'btn btn-danger']) ?>
                        <?= form_close() ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>