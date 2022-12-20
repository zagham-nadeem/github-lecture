<div class="ev-footer">
<div class="ev-container">
<div class="ev-widgets uk-grid-large" uk-grid>
<div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
<h4 class="ev-title"><?php echo echoOutput($translation['tr_40']); ?></h4>
<p class="ev-about"><?php echo echoOutput($translation['tr_41']); ?></p>

<ul class="ev-follow uk-iconnav">
<?php foreach($socialMedia as $item): ?>
<?php if (!empty($item['st_facebook'])): ?>
<li><a href="<?php echo $item['st_facebook'] ?>" uk-icon="icon: facebook"></a></li>
<?php endif;?>
<?php if (!empty($item['st_twitter'])): ?>
<li><a href="<?php echo $item['st_twitter'] ?>" uk-icon="icon: twitter"></a></li>
<?php endif;?>
<?php if (!empty($item['st_youtube'])): ?>
<li><a href="<?php echo $item['st_youtube'] ?>" uk-icon="icon: youtube"></a></li>
<?php endif;?>
<?php if (!empty($item['st_linkedin'])): ?>
<li><a href="<?php echo $item['st_linkedin'] ?>" uk-icon="icon: linkedin"></a></li>
<?php endif;?>
<?php if (!empty($item['st_instagram'])): ?>
<li><a href="<?php echo $item['st_instagram'] ?>" uk-icon="icon: instagram"></a></li>
<?php endif;?>
<?php if (!empty($item['st_whatsapp'])): ?>
<li><a href="<?php echo $item['st_whatsapp'] ?>" uk-icon="icon: whatsapp"></a></li>
<?php endif;?>
<?php endforeach; ?>
</ul>

</div>

<div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
<h4 class="ev-title"><?php echo echoOutput($translation['tr_42']); ?></h4>
<ul class="uk-list">
<?php foreach($navigationFooter as $item): ?>
<?php if ($item['navigation_type'] == 'custom') { ?>
<li><a href="//<?php echo $item['navigation_url']; ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
<?php } else { ?>
<li><a href="<?php echo $urlPath->page($item['navigation_url']); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
<?php } ?>
<?php endforeach; ?>
</ul>
</div>

<div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
<h4 class="ev-title"><?php echo echoOutput($translation['tr_43']); ?></h4>
<ul class="uk-list">
<li><i class="ev-icon fas fa-envelope"></i> <?php echo $settings['st_email']; ?></li>
<li><i class="ev-icon fas fa-map-marker-alt"></i> <?php echo $settings['st_officeaddress']; ?></li>
<li><i class="ev-icon fas fa-phone-alt"></i> <?php echo $settings['st_phone']; ?></li>
</ul>
</div>
<div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
<h4 class="ev-title"><?php echo echoOutput($translation['tr_44']); ?></h4>

<div class="new-subscriber">
<form class="uk-light">
<input type="email" id="subscriber_email" name="subscriber_email" class="uk-input uk-width-1-1 uk-form-large uk-border-pill uk-margin-small-bottom" placeholder="<?php echo echoOutput($translation['tr_46']); ?>">

<button class="uk-button uk-width-1-1 uk-button-large uk-button-primary uk-border-pill" value="<?php echo echoOutput($translation['tr_45']); ?>" type="submit" id="submit-subscriber"><?php echo echoOutput($translation['tr_45']); ?></button>

<div id="showresults"></div>

</form>
</div>

</div>
</div>
</div> 

<div class="ev-copyright">
<div class="uk-container">
<div uk-grid>
<div class="uk-width-1-1 uk-width-1-2@m uk-text-center uk-text-left@m">
<?php echo echoOutput($translation['tr_47']); ?>
</div>

<div class="uk-width-1-1 uk-width-1-2@m uk-text-center uk-text-right@m">
<?php require './sections/languages.php'; ?>
</div>

</div>
</div>
</div>
</div>
