<div class="ev-header-2 uk-visible@m">

<div class="ev-topnav uk-dark uk-padding-small">
<div class="ev-container">
<nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
<div class="uk-navbar-left">

<ul class="uk-iconnav">
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

<?php require './sections/languages.php'; ?>


</nav>
</div>
</div>

<nav class="ev-nav uk-navbar-container uk-padding-small">
<div class="ev-container" uk-navbar>

<div class="uk-navbar-left">
<a class="uk-navbar-item uk-logo uk-margin-medium-right" href="<?php echo $urlPath->home(); ?>">
<img src="<?php echo $urlPath->image($theme['th_logo']); ?>">
</a>
</div>

<div class="uk-navbar-center">

<div class="ev-menu-header uk-grid-large" uk-grid>
<div>
<div class="uk-card">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<i class="ev-icon fas fa-comments"></i>
</div>
<div class="uk-width-expand">
<h3 class="uk-card-title"><?php echo $translation['tr_5']; ?></h3>
<p class="uk-text-meta uk-margin-remove-top">
<a href="mailto:info@company.com"><?php echo $settings['st_email']; ?></a></p>
</div>
</div>
</div>
</div>

<div>
<div class="uk-card">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<i class="ev-icon fas fa-phone-alt"></i>
</div>
<div class="uk-width-expand">
<h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $translation['tr_6']; ?></h3>
<p class="uk-text-meta uk-margin-remove-top"><a href="tel:<?php echo $settings['st_phone']; ?>"><?php echo $settings['st_phone']; ?></a></p>
</div>
</div>
</div>
</div>

<div>
<div class="uk-card">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<i class="ev-icon fas fa-map-marker-alt"></i>
</div>
<div class="uk-width-expand">
<h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $translation['tr_4']; ?></h3>
<p class="uk-text-meta uk-margin-remove-top"><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $settings['st_officeaddress']; ?>" target="_blank"><?php echo $settings['st_officeaddress']; ?></a></p>
</div>
</div>
</div>
</div>

</div>
</div>

<div class="uk-navbar-right">
<div class="uk-navbar-item">

<?php if (isLogged()): ?>

<article class="uk-comment ev-profile-header">
<header class="uk-comment-header">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<img class="uk-comment-avatar" src="<?php echo getGravatar($userInfo['user_email']); ?>">
</div>
<div class="uk-width-expand">
<h4 class="uk-comment-title uk-margin-remove"><?php echo echoOutput(textTruncate($userInfo['user_name'], 10)); ?></h4>
<p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" href="<?php echo $urlPath->profile(); ?>"><?php echo $translation['tr_10']; ?></a></p>
</div>
</div>
</header>
</article>

<?php endif; ?>

<?php if (!isLogged()): ?>

<a class="uk-button uk-button-primary uk-button-large uk-text-truncate uk-border-pill" href="<?php echo $urlPath->signin(); ?>">
<i class="fas fa-user uk-margin-small-right"></i> <?php echo $translation['tr_48']; ?>
</a>

<?php endif; ?>

</div>
</div>
</div>
</nav>

<nav class="ev-subnav uk-navbar-container uk-section-primary">
<div class="ev-container" uk-navbar>
<div class="uk-navbar-center">

<ul class="uk-navbar-nav">
<?php foreach($navigationHeader as $item): ?>
<?php if ($item['navigation_type'] == 'custom') { ?>
<li><a href="<?php echo $item['navigation_url']; ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
<?php } else { ?>
<li><a href="<?php echo $urlPath->page($item['navigation_url']); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
<?php } ?>
<?php endforeach; ?>
</ul>

</div>

</div>

</nav>

</div>

<div class="ev-header-2 uk-hidden@m">
<div class="ev-topnav uk-section-primary uk-padding-small">
<div class="ev-container">
<nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
<div class="uk-navbar-center uk-hidden@m">
<?php require './sections/languages.php'; ?>
</div>
</div>
</div>
</div>
</div>

<?php require './sections/views/mobile-header.view.php'; ?>
