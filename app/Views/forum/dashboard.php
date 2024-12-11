<div class="container mt-5">
    <h2 class="text-center">Dashboard</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-3 text-center">
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
                    <div class="card-footer">
                        <!-- This doesn't work yet. -->
                        <a href="/forum/posts/<?= esc($post['slug'], 'url') ?>" class="btn btn-primary">View Post</a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>