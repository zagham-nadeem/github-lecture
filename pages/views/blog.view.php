<!-- PAGE CONTENT -->
<div class="ev-page-container">

<?php if(!empty($itemDetails['tr_content'])): ?>
<div class="uk-width-1-1">
<?php echo $itemDetails['tr_content']; ?>
</div>
<?php endif; ?>

<div class="uk-grid-large" uk-grid>

<div class="uk-width-expand@m">

<div class="uk-width-1-1 uk-margin-top uk-margin-bottom">

<?php if(getPostQuery() && !empty(getPostQuery()) && !getSlugCategory()): ?>
<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_131']); ?>&nbsp;<b><?php echo echoOutput(getPostQuery()); ?></b></span></h5>
<?php endif; ?>

<?php if(getSlugCategory() && !empty($categoryDetails)): ?>
<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($categoryDetails['tr_name']); ?></span></h5>
<?php endif; ?>

</div>

<div uk-grid>

<?php foreach($items as $item): ?>
<div class="uk-width-1-1">
<div class="ev-blog-2">
<div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-grid-margin-small" uk-grid>
<div class="uk-card-media-left uk-cover-container">
<a href="<?php echo $urlPath->post($item['post_id'], $item['tr_slug']); ?>">
<img src="<?php echo $urlPath->image($item['post_image']); ?>" alt="<?php echo echoOutput($item['tr_title']); ?>" uk-cover>
<canvas width="600" height="400"></canvas>
</a>
</div>
<div>
<div class="uk-card-body uk-flex-middle">
<a href="<?php echo $urlPath->blog(['category' => $item['category_slug']]); ?>" class="ev-meta uk-text-small"><?php echo echoOutput($item['category_name']); ?></a>
<a href="<?php echo $urlPath->post($item['post_id'], $item['tr_slug']); ?>" class="ev-title uk-card-title"><?php echo echoOutput($item['tr_title']); ?></a>
<p class="ev-summary"><?php echo echoNoHtml($item['tr_content']); ?></p>
</a>
<p class="ev-author-date"><span class="uk-margin-small-right" uk-icon="icon: calendar; ratio: 0.9"></span> <?php echo formatDate($item['post_date']); ?></p>
</div>
</div>
</div>
</div>
</div>
<?php endforeach; ?>

</div>

<?php if(!$items): ?>
<div class="uk-width-1-1 uk-flex uk-flex-center uk-text-center uk-margin-large-top">
<div class="uk-width-1-1 uk-width-1-2@s">
<p class="uk-text-bold"><?php echo echoOutput($translation['tr_109']); ?></p>
<p><?php echo echoOutput($translation['tr_110']); ?></p>
</div>
</div>
<?php endif; ?>

<?php require './sections/pagination.php'; ?>

</div>

<div class="uk-width-1-3@m">

<?php require './sections/blog-sidebar.php'; ?>

</div>
</div>
</div>

<!-- END PAGE CONTENT -->
