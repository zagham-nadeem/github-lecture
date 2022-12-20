<?php if(!empty($testimonials)): ?>
<div class="ev-container ev-section-margin-v-m">

<div class="ev-title-dark uk-text-center">
<p><?php echo echoOutput($translation['tr_114']); ?></p>
<h3><?php echo echoOutput($translation['tr_115']); ?></h3>
</div>


<div uk-slider>
<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
<ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-3@l uk-grid-large" uk-grid>

<?php foreach($testimonials as $item): ?>
<div>
<div class="ev-testimonials-1">
<div class="uk-card-body">
<p><?php echo echoOutput($item['testimonial_description']); ?></p>
</div>
<div class="uk-card-footer">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<img class="uk-border-circle" width="40" height="40" src="<?php echo $urlPath->image($item['testimonial_image']); ?>">
</div>
<div class="uk-width-expand">
<h3 class="uk-card-title uk-margin-remove-bottom"><?php echo echoOutput($item['testimonial_name']); ?></h3>
<p class="uk-text-meta uk-margin-remove-top"><?php echo echoOutput($item['testimonial_job']); ?></p>
</div>
</div>
</div>
</div>
</div>

<?php endforeach; ?>

</div>
</div>
</div>
</div>
<?php endif; ?>
