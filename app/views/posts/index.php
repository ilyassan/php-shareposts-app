<?php require APPROOT . '/views/inc/header.php'; ?>

    <?= flash('post_message')?>

    <div class="row">
        <div class="col-md-6">
            <h1>Posts</h1>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end">
            <a href="<?= URLROOT ?>/posts/add" class="btn btn-primary">
                <i class="fa fa-pencil"></i> Add Post
            </a>
        </div>
    </div>
    <?php if(count($data['posts']) == 0):?>
        <p class="alert alert-light mt-5">No posts to show</p>
    <?php else :?>
    <?php foreach($data['posts'] as $post) : ?>
        <div class="card card-body mb-3">
            <h4 class="card-title"><?= $post->title ?></h4>
            <div class="bg-light p-2 mb-3">
                Written by <u><?= $post->name?></u> on <?= $post->postCreated?>
            </div>
            <p class="card-text">- <?= $post->body?></p>
            <a href="<?=URLROOT?>/posts/show/<?= $post->postId?>" class="btn btn-dark">More</a>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>