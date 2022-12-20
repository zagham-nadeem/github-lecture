<?php if (!empty($itemsRelated)): ?>

<div class="uk-width-1-1 uk-margin-medium-top">

<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_75']); ?></span></h5>

<div uk-slider="finite: true">
<div class="uk-position-relative uk-visible-toggle">
<div class="uk-slider-container">

<ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-small" uk-grid>

<?php foreach ($itemsRelated as $item): ?>
<li>
<div class="ev-card-1">

<div class="uk-card uk-card-default uk-card-body" style="margin: 10px;">
<a href="<?php echo $urlPath->property($item['pt_id'], $item['tr_slug']); ?>">
<div class="uk-inline">
<div class="uk-card-media-top uk-cover-container">
<img alt="<?php echo echoOutput($item['tr_title']); ?>" class="uk-border-rounded" src="<?php echo $urlPath->image($item['pt_image']); ?>" uk-cover>
<canvas width="600" height="400"></canvas>
</div>
<div class="uk-overlay uk-light uk-position-top">
<span class="uk-label uk-label-primary">
<?php echo echoOutput($translation['tr_26']); ?>
</span>

<?php if(!empty($item['pt_oldprice']) && is_numeric($item['pt_oldprice'])): ?>
<span class="ev-discount uk-label uk-label-default">
<?php echo echoOutput($translation['tr_120']); ?> <b class="uk-text-bold"><?php echo getPercent($item['pt_price'], $item['pt_oldprice']); ?></b>
</span>
<?php endif; ?>
</div>

<div class="uk-overlay overlay-gradient uk-position-bottom">
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
</div>

</div>
</a>
<div class="ev-body">
<span class="ev-meta uk-text-small"><?php echo echoOutput($item['status']); ?></span>

<h3 class="ev-title uk-card-title uk-text-bolder uk-text-truncate uk-text-truncate"><?php echo echoOutput($item['tr_title']); ?></h3>
<p class="ev-location"><i class="fas fa-map-marker-alt uk-margin-small-right"></i><?php echo getAddress($item['city'], $item['zone']); ?></p>
<ul class="ev-info uk-subnav" uk-margin>
<li><span><?php echo getPluralText($item['pt_beds'], $translation['tr_49'], $translation['tr_50']); ?></span></li>
<li><span><?php echo getPluralText($item['pt_baths'], $translation['tr_51'], $translation['tr_52']); ?></span></li>
<li><span><?php echo getUnit($item['pt_size']); ?></span></li>
</ul>
</div>
</div>
</div>
</li>

<?php endforeach; ?>

</ul>
</div>

<div class="uk-visible@s">
<a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
<a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
</div>
</div>

<ul class="ev-dotnav-1 uk-slider-nav uk-dotnav uk-flex-center uk-margin-medium-top"></ul>

</div>
</div>

<?php endif; ?>