<?php if(!empty($preferredChoice)): ?>
<div class="ev-section-margin-v-l">

<div class="ev-container ev-section-margin-v-m">

<div class="ev-title-dark uk-text-center uk-margin-remove-top">
<p><?php echo echoOutput($translation['tr_36']); ?></p>
<h3><?php echo echoOutput($translation['tr_37']); ?></h3>
</div>

<div uk-grid>

<?php foreach($preferredChoice as $item): ?>

<div class="uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
<div class="ev-iconlist-v1">
<img src="<?php echo $urlPath->image($item['pc_image']); ?>">
<h4><?php echo echoOutput($item['tr_title']); ?></h4>
<p><?php echo echoNoHtml($item['tr_content']); ?></p>
</div>
</div>

<?php endforeach; ?>

</div>
</div>
</div>
<?php endif; ?>
