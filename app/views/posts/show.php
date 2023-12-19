<?php require APPROOT . '/views/inc/header.php'; ?>

<a href="<?=URLROOT?>/posts" class="btn btn-primary"><i class="fa fa-backward"></i> Back</a>
<br>
<h1><?=$data['post']->title?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <?= $data['post']->name?> on <?= $data['post']->postCreated?>
</div>
<p><?=$data['post']->body?></p>

<hr>
<div class="d-flex align-items-center justify-content-between">
    <?php if($data['post']->user_id == $_SESSION['user_id']) :?>
        <a href="<?=URLROOT?>/posts/edit/<?=$data['post']->postId?>"
    class="btn btn-dark">Edit</a>
    <form action="<?=URLROOT?>/posts/delete/<?=$data['post']->postId?>" method="POST">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
    <?php endif;?>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>