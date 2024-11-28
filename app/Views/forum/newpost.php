<?php helper('form'); ?>
<div class = "container mt-5">
    <h2> Add new post </h2>
    <div class = "row">
        <div class="text-danger">
            <?= validation_list_errors() ?>
        </div>
        <?= form_open('forum/newpost'); ?>
        <?= csrf_field() ?>
        <div class = "col-8">
            <!-- textarea here for posts -->
        </div>
        <div class = "col-4">
            <!-- all the other post variables here -->
        </div>
    </div>
</div>