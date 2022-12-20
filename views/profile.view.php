<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE CONTENT -->

<div class="ev-page-container">
<div class="uk-grid-large" uk-grid>

<div class="uk-width-1-3@s uk-width-1-4@m">

<div class="ev-border-solid uk-border-rounded uk-padding-small">

<div class="uk-padding-small">

<div class="uk-block uk-margin-remove uk-text-center">
<img class="uk-border-pill uk-width-1-4 uk-width-1-2@s" src="<?php echo getGravatar($userInfo['user_email']); ?>">

</div>

<div class="uk-margin uk-text-center">
<p class="uk-text-muted uk-margin-remove"><?php echo maskEmail($userInfo['user_email']); ?></p>
</div>

<hr>

<ul class="uk-list uk-list-collapse">
<li class="uk-text-bold"><?php echo echoOutput($translation['tr_138']); ?></li>
<li><?php echo echoOutput($userInfo['user_name']); ?></li>
</ul>

<ul class="uk-list uk-list-collapse">
<li class="uk-text-bold"><?php echo echoOutput($translation['tr_139']); ?></li>
<li><?php echo echoOutput($userInfo['user_email']); ?></li>
</ul>

<ul class="uk-list uk-list-collapse">
<li class="uk-text-bold"><?php echo echoOutput($translation['tr_178']); ?></li>
<li><?php echo formatDate($userInfo['user_created']); ?></li>
</ul>

<hr style="margin-bottom: 5px;">

</div>

<div class="uk-padding-small">

<ul class="ev-nav uk-nav uk-nav-default">
<?php if(isAdmin()): ?>
<li><a class="ev-text-small ev-link" href="<?php echo $urlPath->admin(); ?>"><span class="uk-margin-small-right" uk-icon="icon: cog"></span> <?php echo echoOutput($translation['tr_179']); ?></a></li>
<?php endif; ?>
<li><a class="ev-text-small" href="<?php echo $urlPath->profile('edit'); ?>"><span class="uk-margin-small-right" uk-icon="icon: user"></span> <?php echo echoOutput($translation['tr_180']); ?></a></li>
<li><a class="ev-text-small" href="<?php echo $urlPath->signout(); ?>"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> <?php echo echoOutput($translation['tr_181']); ?></a></li>
</ul>

</div>

</div>
</div>

<div class="uk-width-expand">

<?php if (!isEditing()): ?>

<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_182']); ?></span></h5>

<?php if (!empty($userFavorites)):?>

<div uk-grid>

<?php foreach($userFavorites as $item): ?>

<div class="uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s uk-width-1-1" id="FavId-<?php echo $item['pt_id']; ?>">
<div class="ev-card-2 uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
<div class="uk-card-media-left uk-cover-container">
<a href="<?php echo $urlPath->property($item['pt_id'], $item['tr_slug']); ?>">
<img alt="<?php echo echoOutput($item['tr_title']); ?>" src="<?php echo $urlPath->image($item['pt_image']); ?>" uk-cover>
<canvas width="600" height="400"></canvas>
</a>
</div>
<div>
<div class="uk-card-body">

<span class="ev-meta uk-text-small uk-position-right uk-margin-small-right uk-margin-small-top"><a class="removefav uk-text-danger" data-item="<?php echo $item['pt_id']; ?>" data-user="<?php echo $userInfo['user_id']; ?>"><i class="fas fa-times-circle uk-margin-small-right"></i></a></span>

<a href="<?php echo $urlPath->property($item['pt_id'], $item['tr_slug']); ?>">
<h3 class="ev-title uk-card-title uk-text-truncate"><?php echo echoOutput($item['tr_title']); ?></h3>
</a>
<p class="ev-price uk-flex uk-flex-middle"><?php echo getPrice($item['pt_price']); ?>
</p>
<p class="ev-location"><i class="fas fa-map-marker-alt uk-margin-small-right"></i><?php echo getAddress($item['city'], $item['zone']); ?></p>
<ul class="ev-info uk-subnav">
<li><span><?php echo getPluralText($item['pt_beds'], $translation['tr_49'], $translation['tr_50']); ?></span></li>
<li><span><?php echo getPluralText($item['pt_baths'], $translation['tr_51'], $translation['tr_52']); ?></span></li>
<li><span><?php echo getUnit($item['pt_size']); ?></span></li>
</ul>
</div>
</div>
</div>
</div>

<?php endforeach; ?>

</div>

<?php endif;?>


<?php if (empty($userFavorites)):?>
<div class="uk-margin uk-text-center uk-text-muted">
<p><?php echo echoOutput($translation['tr_183']); ?></p>
</div>
<?php endif;?>

<?php endif;?>

<?php if (isEditing()): ?>

<?php require './views/edit-profile.view.php'; ?>

<?php endif;?>

</div>

</div>
</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>
