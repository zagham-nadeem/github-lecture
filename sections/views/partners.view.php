<?php if(!empty($partners)): ?>
<div class="ev-container ev-section-margin-v-l">

<div class="ev-title-dark uk-text-center">
<p><?php echo echoOutput($translation['tr_38']); ?></p>
<h3><?php echo echoOutput($translation['tr_39']); ?></h3>
</div>

<div uk-slider>
<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
<ul class="uk-slider-items uk-text-center uk-child-width-1-2 uk-child-width-1-3@m uk-child-width-1-5@l" uk-grid>

<?php foreach($partners as $item): ?>
<div>
<img src="<?php echo $urlPath->image($item['partner_image']); ?>" alt="<?php echo echoOutput($item['partner_name']); ?>">
</div>
<?php endforeach; ?>

</ul>
</div>
</div>
</div>
</div>
<?php endif; ?>
