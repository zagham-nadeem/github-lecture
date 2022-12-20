<div class="ev-header-1 uk-visible@m">

<div class="ev-topnav uk-section-primary uk-padding-small">
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

<div class="uk-navbar-right">
<div class="uk-navbar-item">

<?php if (isLogged()): ?>

<article class="uk-comment ev-profile-header">
<header class="uk-comment-header">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<img class="uk-comment-avatar" src="<?php echo getGravatar($userInfo['user_email']); ?>" alt="">
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

<a class="uk-button uk-button-secondary uk-button-large uk-text-truncate uk-border-pill" href="<?php echo $urlPath->signin(); ?>">
<i class="fas fa-user uk-margin-small-right"></i> <?php echo $translation['tr_48']; ?>
</a>

<?php endif; ?>

</div>
</div>
</div>
</div>
</nav>

<div class="ev-header-1 uk-hidden@m">
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
