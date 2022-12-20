<?php if ($itemDetails['page_ad_header'] == 1): ?>
<?php if(!empty($headerAd)): ?>
<div class="ev-container uk-margin-medium-top">
<div class="uk-width-1-1">
<div class="ev-header-ads">
<?php foreach($headerAd as $item): ?>

<div class="ev-item">
<?php echo $item['ad_html']; ?>
</div>	

<?php endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>
<?php endif; ?>