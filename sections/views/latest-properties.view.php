<?php if(!empty($latestProperties)): ?>
<div class="ev-container ev-section-margin-v-l">

<div class="ev-title-dark uk-text-center">
<p><?php echo echoOutput($translation['tr_117']); ?></p>
<h3><?php echo echoOutput($translation['tr_118']); ?></h3>
</div>

<div uk-grid>

<?php foreach($latestProperties as $item): ?>

<div class="uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s uk-width-1-1">
<div class="ev-card-2 uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
<div class="uk-card-media-left uk-cover-container">
<a href="<?php echo $urlPath->property($item['pt_id'], $item['tr_slug']); ?>">
<img alt="<?php echo echoOutput($item['tr_title']); ?>" src="<?php echo $urlPath->image($item['pt_image']); ?>" uk-cover>
<canvas width="600" height="400"></canvas>
</a>
</div>
<div>
<div class="uk-card-body">

<span class="ev-meta uk-text-small"><?php echo echoOutput($item['status']); ?></span>
<a href="<?php echo $urlPath->property($item['pt_id'], $item['tr_slug']); ?>">
<h3 class="ev-title uk-card-title uk-text-truncate"><?php echo echoOutput($item['tr_title']); ?></h3>
</a>
<p class="ev-price uk-flex uk-flex-middle"><?php echo getPrice($item['pt_price']); ?>
<?php if(!empty($item['tr_label'])): ?>
<small><?php echo echoOutput($item['tr_label']); ?></small>
<?php endif; ?>

<?php if(!empty($item['pt_oldprice']) && is_numeric($item['pt_oldprice'])): ?>
<span class="ev-old-price">
<?php echo getDiscount($item['pt_price'], $item['pt_oldprice']); ?>
</span>
<?php endif; ?>
</p>
<p class="ev-location"><i class="fas fa-map-marker-alt uk-margin-small-right"></i><?php echo getAddress($item['city'], $item['zone']); ?></p>
<ul class="ev-info uk-subnav">
<li><span><?php echo getPluralText($item['pt_beds'], $translation['tr_49'], $translation['tr_50']); ?></span></li>
<li><span><?php echo getPluralText($item['pt_baths'], $translation['tr_51'], $translation['tr_52']); ?></span></li>
<li><span><?php echo getUnit($item['pt_size']); ?></span></li>
</ul>
</div>
</div>
</div>
</div>

<?php endforeach; ?>

</div>

</div>
<?php endif; ?>