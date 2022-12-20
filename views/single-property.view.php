<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE TITLE -->

<div class="ev-page-title-2">
<div class="ev-container">

<div class="uk-child-width-1-1 uk-child-width-1-2@m uk-flex uk-flex-middle uk-flex-center uk-grid-small" uk-grid>
<div class="uk-flex uk-flex-center uk-flex-left@m uk-visible@m">
<h5 class="title"><?php echo getAddress($itemDetails['city'], $itemDetails['zone']); ?> · <span><?php echo getPrice($itemDetails['pt_price']); ?></span> <?php if(!empty($itemDetails['tr_label'])): ?>
<span><?php echo echoOutput($itemDetails['tr_label']); ?></span>
<?php endif; ?></h5>
</div>
<div>
<div class="ev-actions uk-text-center uk-text-right@m">
<a href="#email-modal" uk-toggle>
<span uk-icon="icon: mail; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_64']); ?>
</a>

<a href="<?php echo $urlPath->print($itemDetails['pt_id']); ?>" class="uk-visible@s"><span uk-icon="icon: print; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_65']); ?></a>

<?php if(isset($isFav) && $isFav == 0): ?>

<a class="addfav" data-item="<?php echo $itemDetails['pt_id']; ?>" data-user="<?php echo $userInfo['user_id']; ?>"><span uk-icon="icon: heart; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_66']); ?></a>

<a class="removefav uk-hidden" data-item="<?php echo $itemDetails['pt_id']; ?>" data-user="<?php echo $userInfo['user_id']; ?>"><span uk-icon="icon: close; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_67']); ?></a>

<?php endif; ?>


<?php if(isset($isFav) && $isFav == 1): ?>

<a class="addfav uk-hidden" data-item="<?php echo $itemDetails['pt_id']; ?>" data-user="<?php echo $userInfo['user_id']; ?>"><span uk-icon="icon: heart; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_66']); ?></a>

<a class="removefav" data-item="<?php echo $itemDetails['pt_id']; ?>" data-user="<?php echo $userInfo['user_id']; ?>"><span uk-icon="icon: close; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_67']); ?></a>

<?php endif; ?>

<?php if(!isLogged()): ?>

<a href="<?php echo $urlPath->signin(); ?>">
<span uk-icon="icon: heart; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_66']); ?>
</a>

<?php endif; ?>

<a href="#share-modal" uk-toggle>
<span uk-icon="icon: social; ratio: 1.3"></span> <?php echo echoOutput($translation['tr_68']); ?>
</a>
</div>
</div>
</div>

</div>
</div>

<!-- END PAGE TITLE -->

<!-- PAGE CONTENT -->

<div class="ev-page-container">

<?php if ($itemDetails['pt_sold'] == 1): ?>

<div class="ev-alert uk-alert-danger" uk-alert>
<a class="uk-alert-close" uk-close></a>
<p class="uk-text-truncate"><i class="fas fa-exclamation-circle"></i> <?php echo echoOutput($translation['tr_76']); ?></p>
</div>

<?php endif; ?>

<div class="ev-single-property uk-grid-large" uk-grid>

<div class="uk-width-expand@m">

<div uk-slideshow="animation: slide">

<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
<div uk-lightbox>

<ul class="uk-slideshow-items">
<li>
<a href="<?php echo $urlPath->image($itemDetails['pt_image']); ?>">
<img src="<?php echo $urlPath->image($itemDetails['pt_image']); ?>" uk-cover>
</a>
</li>

<?php foreach($itemsGallery as $item): ?>
<li>
<a href="<?php echo $urlPath->image($item['pg_name']); ?>">
<img src="<?php echo $urlPath->image($item['pg_name']); ?>" uk-cover>
</a>
</li>
<?php endforeach; ?>
</ul>

</div>

<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

</div>

<div class="uk-margin-small uk-visible@m">
<ul class="ev-thumbnav-1 uk-thumbnav">
<li class="uk-active" uk-slideshow-item="0">
<a href="#">
<img src="<?php echo $urlPath->image($itemDetails['pt_image']); ?>" width="100">
</a>
</li>

<?php $i = 1; ?>
<?php foreach($itemsGallery as $item): ?>
<li uk-slideshow-item="<?php echo $i++; ?>">
<a href="#">
<img src="<?php echo $urlPath->image($item['pg_name']); ?>" width="100">
</a>
</li>
<?php endforeach; ?>
</ul>
</div>

</div>

<!-- PROPERTY DETAILS -->

<div class="ev-details">

<hr>

<div class="uk-flex uk-flex-middle">

<div class="uk-grid uk-flex-middle uk-grid-small">
<div class="uk-child-width-1-1 uk-width-expand@s">
<h3 class="ev-price">
<?php echo getPrice($itemDetails['pt_price']); ?>
<?php if(!empty($itemDetails['tr_label'])): ?>
<span><?php echo echoOutput($itemDetails['tr_label']); ?></span>
<?php endif; ?>
</h3>
</div>

<div class="uk-child-width-1-1">
<?php if(!empty($itemDetails['pt_oldprice']) && is_numeric($itemDetails['pt_oldprice'])): ?>
<span class="ev-discount">
<?php echo echoOutput($translation['tr_120']); ?> <b class="uk-text-bold"><?php echo getPercent($itemDetails['pt_price'], $itemDetails['pt_oldprice']); ?></b>
</span>
<?php endif; ?>
</div>

<div class="uk-child-width-1-1">
<?php if(!empty($itemDetails['pt_oldprice']) && is_numeric($itemDetails['pt_oldprice'])): ?>
<h3 class="ev-old-price"><?php echo getDiscount($itemDetails['pt_price'], $itemDetails['pt_oldprice']); ?></h3>
<?php endif; ?>
</div>

</div>



</div>

<h1 class="ev-title"><?php echo echoOutput($itemDetails['tr_title']); ?></h1>
<p class="ev-location"><i class="fas fa-map-marker-alt uk-margin-small-right"></i>
<?php echo getAddress($itemDetails['city'], $itemDetails['zone']); ?>
</p>

<hr>

<ul class="ev-meta">
<div class="uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m uk-grid-small" uk-grid>
<div>
<li>
<img class="svg" src="<?php echo $urlPath->assets_img('area.png'); ?>">
<?php echo getUnit($itemDetails['pt_size']); ?>
</li>
</div>

<div>
<li>
<img src="<?php echo $urlPath->assets_img('beds.png'); ?>">
<?php echo getPluralText($itemDetails['pt_beds'], $translation['tr_49'], $translation['tr_50']); ?>
</li>
</div>

<div>
<li>
<img src="<?php echo $urlPath->assets_img('baths.png'); ?>">
<?php echo getPluralText($itemDetails['pt_baths'], $translation['tr_51'], $translation['tr_52']); ?>
</li>
</div>

<div>
<li>
<img class="svg" src="<?php echo $urlPath->assets_img('garage.png'); ?>">
<?php echo getPluralText($itemDetails['pt_garages'], $translation['tr_53'], $translation['tr_54']); ?>
</li>
</div>
<div>
<li>
<img class="svg" src="<?php echo $urlPath->assets_img('floor.png'); ?>">
<?php echo echoOutput($translation['tr_55']); ?> <?php echo echoOutput($itemDetails['pt_floor']); ?>
</li>
</div>
</div>
</ul>

<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_69']); ?></span></h5>

<p><?php echo echoOutput($itemDetails['tr_description']); ?></p>

<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_70']); ?></span></h5>

<div class="uk-column-1-1 uk-column-1-2@s">

<ul class="uk-list uk-list-large ev-details-list">
<li><span><?php echo echoOutput($translation['tr_56']); ?></span> <?php echo getUnit($itemDetails['pt_size']); ?></li>
<li><span><?php echo echoOutput($translation['tr_57']); ?></span> <?php echo echoOutput($itemDetails['pt_baths']); ?></li>
<li><span><?php echo echoOutput($translation['tr_58']); ?></span> <?php echo echoOutput($itemDetails['pt_beds']); ?></li>
<li><span><?php echo echoOutput($translation['tr_59']); ?></span> <?php echo echoOutput($itemDetails['pt_floor']); ?></li>
<li><span><?php echo echoOutput($translation['tr_60']); ?></span> <?php echo echoOutput($itemDetails['type']); ?></li>
<li><span><?php echo echoOutput($translation['tr_61']); ?></span> <?php echo echoOutput($itemDetails['pt_garages']); ?></li>
<li><span><?php echo echoOutput($translation['tr_62']); ?></span> <?php echo echoOutput($itemDetails['conditions']); ?></li>
<li><span><?php echo echoOutput($translation['tr_63']); ?></span> <span class="rating rating-<?php echo echoOutput($itemDetails['pt_rating']); ?>"><?php echo echoOutput($itemDetails['pt_rating']); ?></span></li>
</ul>

</div>

<?php if (!empty($itemsExtras)): ?>

<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_71']); ?></span></h5>

<div class="uk-column-1-1 uk-column-1-2@s uk-column-1-3@m">

<ul class="uk-list uk-list-large ev-features">
<?php foreach ($itemsExtras as $item): ?>
<li><i class="fas fa-check"></i> <?php echo $item['tr_name']; ?></li>
<?php endforeach; ?>
</ul>

</div>

<?php endif; ?>

<?php if(!empty($itemDetails['pt_video'])): ?>

<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_72']); ?></span></h5>

<button class="uk-button uk-button-default uk-width-1-1 uk-border-rounded uk-margin" type="button" uk-toggle="target: +"><i class="fas fa-play uk-margin-small-right"></i> <?php echo echoOutput($translation['tr_74']); ?></button>

<iframe src="https://www.youtube-nocookie.com/embed/<?php echo echoOutput($itemDetails['pt_video']); ?>?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=0&amp;playsinline=1" width="1920" height="1080" frameborder="0" allowfullscreen uk-responsive uk-video="automute: false" hidden></iframe>

<?php endif; ?>

<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_73']); ?></span></h5>

<iframe class="ev-map" height="250" src="https://maps.google.com/maps?q=<?php echo echoOutput($itemDetails['pt_latitude']); ?>,<?php echo echoOutput($itemDetails['pt_longitude']); ?>&amp;hl=<?php echo $lang; ?>&amp;z=14&amp;output=embed"></iframe>

<?php if(!empty($itemDetails['pt_direction'])): ?>
<p><?php echo echoOutput($itemDetails['pt_direction']); ?></p>
<?php endif; ?>


<h5 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_77']); ?></span></h5>

<p><?php echo echoOutput($itemDetails['pt_reference']); ?></p>

</div> <!-- END PROPERTY DETAILS -->

</div>

<!-- END EXPANDED SECTION -->

<div class="uk-width-1-3@m">

<?php require './sections/form-property.php'; ?>

<?php if($settings['st_calculator'] == 1): ?>

<?php require './sections/calculator.php'; ?>

<?php endif; ?>

</div>

</div>

<?php require './views/related-properties.view.php'; ?>

</div>

<!-- END PAGE CONTENT -->

<?php require './sections/email-property.php'; ?>
<?php require './sections/share-property.php'; ?>

<?php require './sections/footer.php'; ?>