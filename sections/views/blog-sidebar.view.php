<div class="ev-blog-widget">
<h5 class="ev-title uk-heading-line"><span><?php echo echoOutput($translation['tr_124']); ?></span></h5>
<form class="uk-search uk-search-default uk-width-1-1" method="get" action="<?php echo $urlPath->blog(); ?>">
<span uk-search-icon></span>

<?php if(!getPostQuery() && empty(getPostQuery())): ?>
<input class="uk-search-input" name="query" type="search" placeholder="<?php echo echoOutput($translation['tr_125']); ?>" required>
<?php endif; ?>

<?php if(getPostQuery() && !empty(getPostQuery())): ?>
<input class="uk-search-input" name="query" type="search" value="<?php echo echoOutput(getPostQuery()); ?>">
<?php endif; ?>

</form>
</div>

<?php if(!empty($featuredPosts)): ?>
<div class="ev-blog-widget">

<h5 class="ev-title uk-heading-line"><span><?php echo echoOutput($translation['tr_126']); ?></span></h5>

<?php foreach($featuredPosts as $item): ?>

<div class="ev-featured-posts">
<div class="uk-grid-small" uk-grid>
<div class="uk-width-1-3">
<a href="<?php echo $urlPath->post($item['post_id'], $item['tr_slug']); ?>">
<div class="uk-background-cover" data-src="<?php echo $urlPath->image($item['post_image']); ?>" uk-img></div>
</a>
</div>
<div class="uk-width-expand">
<p class="ev-category"><?php echo echoOutput($item['category_name']); ?></p>
<a class="ev-title" href="<?php echo $urlPath->post($item['post_id'], $item['tr_slug']); ?>"><?php echo echoOutput($item['tr_title']); ?></a>
</div>
</div>
</div>

<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if(!empty($getCategories)): ?>
<div class="ev-blog-widget">
<h5 class="ev-title uk-heading-line"><span><?php echo echoOutput($translation['tr_127']); ?></span></h5>
<div class="ev-categories">
<?php foreach($getCategories as $item): ?>
<a href="<?php echo $urlPath->blog(['category' => $item['tr_slug']]); ?>"><?php echo echoOutput($item['tr_name']); ?></a>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>

<!-- SIDEBAR AD -->
<?php require './sections/views/sidebar-ad.view.php'; ?>
