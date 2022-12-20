<?php if ($itemDetails['page_ad_footer'] == 1): ?>
<?php if(!empty($footerAd)): ?>
<div class="ev-container">
<div class="uk-width-1-1">
<div class="ev-header-ads">
<?php foreach($footerAd as $item): ?>

<div class="ev-item">
<?php echo $item['ad_html']; ?>
</div>	

<?php endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>
<?php endif; ?>