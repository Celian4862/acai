<div class="container mt-5">
  <h2 class="text-center">Dashboard</h2>
  <?php foreach ($posts as $post): ?>
    <div class="row justify-content-center">
      <div class="col-md-4">
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
      </div>
    </div>
  <?php endforeach ?>
</div>