<?php if(!empty($staff)): ?>
<div class="ev-team ev-section-margin-v-l">

<div class="ev-container ev-section-margin-v-l">

<div class="ev-title-dark uk-text-center uk-margin-remove-top">
<p><?php echo echoOutput($translation['tr_194']); ?></p>
<h3><?php echo echoOutput($translation['tr_195']); ?></h3>
</div>

<div class="uk-child-width-1-2 uk-child-width-1-4@m uk-margin-large-top" uk-grid>
<?php foreach($staff as $item): ?>
<div>
    <img src="<?php echo $urlPath->image($item['staff_image']); ?>">
    <p><?php echo echoOutput($item['tr_name']); ?></p>
    <span><?php echo echoOutput($item['tr_job']); ?></span>
    <div class="ev-profiles">
        <?php if(!empty($item['staff_facebook'])): ?><a href="<?php echo echoOutput($item['staff_facebook']); ?>"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
        <?php if(!empty($item['staff_twitter'])): ?><a href="<?php echo echoOutput($item['staff_twitter']); ?>"><i class="fab fa-twitter"></i></a><?php endif; ?>
        <?php if(!empty($item['staff_linkedin'])): ?><a href="<?php echo echoOutput($item['staff_linkedin']); ?>"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
        <?php if(!empty($item['staff_google'])): ?><a href="<?php echo echoOutput($item['staff_google']); ?>"><i class="fab fa-google-plus-g"></i></a><?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
</div>

</div>
</div>
<?php endif; ?>
