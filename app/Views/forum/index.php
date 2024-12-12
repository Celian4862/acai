<div class="container mt-5">
    <h2 class="text-center">Forum</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php if (session()->has('logged_in') && session()->get('logged_in') === true): ?>
                <div class="card mt-3 text-center">
                    <div class="card-body">
                        <a href="/forum/newpost" class="btn btn-primary">+ Add new post</a>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center mt-3"><a href="/login">Login</a> to add a new post.</p>
            <?php endif ?>
            <?php foreach ($posts as $post): ?>
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title"><?= esc($post['title']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= esc($post['body']) ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="/forum/posts/<?= esc($post['id'], 'url') ?>" class="btn btn-primary">View Post</a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>