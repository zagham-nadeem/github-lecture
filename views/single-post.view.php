<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE TITLE -->
<?php require './sections/page-title.php'; ?>

<!-- PAGE CONTENT -->

<div class="ev-page-container">
<div class="uk-grid-large" uk-grid>

<div class="uk-width-expand@m">

<div uk-grid>

<div class="ev-single-post uk-width-1-1">

<div class="ev-image uk-cover-container uk-height-medium">
    <img src="<?php echo $urlPath->image($itemDetails['post_image']); ?>" alt="<?php echo echoOutput($itemDetails['tr_title']); ?>" uk-cover>
</div>

<h3 class="ev-title"><?php echo echoOutput($itemDetails['tr_title']); ?></h3>

<ul class="uk-subnav">
<li><a href="<?php echo $urlPath->blog(['category' => $itemDetails['category_slug']]); ?>"><span class="uk-margin-small-right" uk-icon="icon: folder; ratio: 1"></span> <?php echo echoOutput($itemDetails['category_name']); ?></a></li>
<li><p><span class="uk-margin-small-right" uk-icon="icon: calendar; ratio: 1"></span> <?php echo formatDate($itemDetails['post_date']); ?></p></li>
</ul>

<hr class="uk-margin-medium-bottom">

<div class="ev-description">
<?php echo $itemDetails['tr_content']; ?>
</div>

<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_132']); ?></span></h5>

<?php require './sections/share-post.php'; ?>

<?php if(!empty($itemsRelated)): ?>

<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_133']); ?></span></h5>

<div class="uk-child-width-1-2@s uk-child-width-1-2@m uk-grid-medium" uk-grid>

<?php foreach ($itemsRelated as $item): ?>

<div>
<div class="ev-blog-1">
<div class="uk-card uk-card-default uk-width-1-1">
<a href="<?php echo $urlPath->post($item['post_id'], $item['tr_slug']); ?>">
<div class="uk-inline">
<div class="uk-card-media-top uk-cover-container">
<img alt="<?php echo echoOutput($item['tr_title']); ?>" class="uk-border-rounded" src="<?php echo $urlPath->image($item['post_image']); ?>" uk-cover>
<canvas width="600" height="350"></canvas>
</div>
<div class="uk-card-body">
<div class="uk-card-badge uk-label"><?php echo $item['category_name']; ?></div>
<a class="uk-card-title" href="<?php echo $urlPath->post($item['post_id'], $item['tr_slug']); ?>"><?php echo echoOutput($item['tr_title']); ?></a>
<p><?php echo echoNoHtml($item['tr_content']); ?></p>
</div>
</div>
</a>
</div>
</div>
</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

</div>
</div>

</div>

<div class="uk-width-1-3@m">

<?php require './sections/blog-sidebar.php'; ?>

</div>

</div>
</div>

<!-- END PAGE CONTENT -->

<?php require './sections/footer.php'; ?>
