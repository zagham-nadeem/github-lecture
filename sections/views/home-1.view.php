<div class="ev-slide-2">

<?php if ($homeSlider):?>
<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="autoplay: false">
<ul class="uk-slider-items uk-child-width-1-1">


<?php foreach($homeSlider as $item): ?>

<li>
<a href="<?php echo $urlPath->property($item['pt_id'], $item['tr_slug']); ?>">
<div class="ev-slide-item" style="background-image: url(<?php echo $urlPath->image($item['slider_image']); ?>);">
<div class="ev-slide-overlay"></div>
<div class="ev-slide-container">
<div class="ev-slide-content">
<label><?php echo echoOutput($translation['tr_26']); ?></label>
<h2 class="ev-title uk-text-truncate"><?php echo echoOutput($item['tr_title']); ?></h2>
<p class="uk-text-truncate"><?php echo getAddress($item['city'], $item['zone']); ?></p>
<ul class="ev-info uk-subnav">
<li><span><?php echo getPluralText($item['pt_beds'], $translation['tr_49'], $translation['tr_50']); ?></span></li>
<li><span><?php echo getPluralText($item['pt_baths'], $translation['tr_51'], $translation['tr_52']); ?></span></li>
<li><span><?php echo getUnit($item['pt_size']); ?></span></li>
</ul>

<p class="ev-status"><?php echo echoOutput($item['status']); ?></p>
<h3 class="ev-price"><?php echo getPrice($item['pt_price']); ?> 
<?php if(!empty($item['tr_label'])): ?>
<small><?php echo echoOutput($item['tr_label']); ?></small>
<?php endif; ?>
</h3>
</div>
</div>
</div>
</a>
</li>

<?php endforeach; ?>

</ul>

<a class="uk-position-center-left uk-position-small uk-hidden-hover uk-visible@m" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
<a class="uk-position-center-right uk-position-small uk-hidden-hover uk-visible@m" href="#" uk-slidenav-next uk-slider-item="next"></a>

</div>

<?php endif; ?>

</div>
