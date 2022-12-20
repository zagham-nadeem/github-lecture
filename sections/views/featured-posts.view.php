<?php if(!empty($featuredPosts)): ?>
<div class="ev-container ev-section-margin-v-m">

<div class="ev-title-dark uk-text-center">
<p><?php echo echoOutput($translation['tr_34']); ?></p>
<h3><?php echo echoOutput($translation['tr_35']); ?></h3>
</div>

<div class="ev-featured-posts" uk-grid>

<?php foreach($featuredPosts as $item): ?>

<div class="uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">

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
<p class="uk-text-muted uk-margin-small-bottom"><span class="uk-margin-small-right" uk-icon="icon: calendar; ratio: 1"></span> <?php echo formatDate($item['post_date']); ?></p>
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
</div>
<?php endif; ?>
