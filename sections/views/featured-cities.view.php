<?php if(!empty($featuredCities)): ?>

<div class="ev-container ev-section-margin-v-m">

<div class="ev-title-dark uk-text-center">
<p><?php echo echoOutput($translation['tr_28']); ?></p>
<h3><?php echo echoOutput($translation['tr_29']); ?></h3>
</div>

<div class="uk-grid-small uk-text-center" uk-grid>

<?php foreach ($featuredCities as $item) { ?>

<?php if( $counter == 0 ) { ?>

<div class="uk-width-1-4@l uk-width-1-4@m uk-width-1-2@s">
<a href="<?php echo $urlPath->properties(['city' => $item['tr_slug']]); ?>">
<div class="ev-featured-city-1" style="background: url(<?php echo $urlPath->image($item['pt_city_image']); ?>);">
<div class="ev-overlay">
<div class="ev-content">
<h3><?php echo echoOutput($item['tr_name']); ?></h3>
<p><?php echo $item['total_properties']; ?> <?php echo echoOutput($translation['tr_27']); ?></p>
</div>
</div>
</div>
</a>
</div>

<?php } ?>

<?php if( $counter == 1 ) { ?>

<div class="uk-width-3-4@l uk-width-3-4@m uk-width-1-2@s">
<a href="<?php echo $urlPath->properties(['city' => $item['tr_slug']]); ?>">
<div class="ev-featured-city-1" style="background: url(<?php echo $urlPath->image($item['pt_city_image']); ?>);">
<div class="ev-overlay">
<div class="ev-content">
<h3><?php echo echoOutput($item['tr_name']); ?></h3>
<p><?php echo $item['total_properties']; ?> <?php echo echoOutput($translation['tr_27']); ?></p>
</div>
</div>
</div>
</a>
</div>
</div>

<?php } ?>

<?php if ( $counter == 2){ ?>

<div class="uk-child-width-expand@m uk-grid-small uk-text-center" uk-grid>
<div>
<a href="<?php echo $urlPath->properties(['city' => $item['tr_slug']]); ?>">
<div class="ev-featured-city-1" style="background: url(<?php echo $urlPath->image($item['pt_city_image']); ?>);">
<div class="ev-overlay">
<div class="ev-content">
<h3><?php echo echoOutput($item['tr_name']); ?></h3>
<p><?php echo $item['total_properties']; ?> <?php echo echoOutput($translation['tr_27']); ?></p>
</div>
</div>
</div>
</a>
</div>


<?php } ?>
<?php if ( $counter == 3){ ?>


<div>
<div class="uk-child-width-1-2@l uk-child-width-1-2@s uk-grid-small uk-text-center" uk-grid>
<div>
<a href="<?php echo $urlPath->properties(['city' => $item['tr_slug']]); ?>">
<div class="ev-featured-city-1" style="background: url(<?php echo $urlPath->image($item['pt_city_image']); ?>);">
<div class="ev-overlay">
<div class="ev-content">
<h3><?php echo echoOutput($item['tr_name']); ?></h3>
<p><?php echo $item['total_properties']; ?> <?php echo echoOutput($translation['tr_27']); ?></p>
</div>
</div>
</div>
</a>
</div>

<?php } ?>
<?php if ( $counter == 4){ ?>

<div class="uk-box-shadow-medium">
<a href="<?php echo $urlPath->properties(['city' => $item['tr_slug']]); ?>">
<div class="ev-featured-city-1" style="background: url(<?php echo $urlPath->image($item['pt_city_image']); ?>);">
<div class="ev-overlay">
<div class="ev-content">
<h3><?php echo echoOutput($item['tr_name']); ?></h3>
<p><?php echo $item['total_properties']; ?> <?php echo echoOutput($translation['tr_27']); ?></p>
</div>
</div>
</div>
</a>
</div>
</div>
</div>
</div>

<?php } ?>
<?php if ($counter == 5){ ?>

<div class="uk-child-width-expand@m uk-grid-small uk-text-center" uk-grid>

<div>
<div class="uk-box-shadow-medium">
<a href="<?php echo $urlPath->properties(['city' => $item['tr_slug']]); ?>">
<div class="ev-featured-city-1" style="background: url(<?php echo $urlPath->image($item['pt_city_image']); ?>);">
<div class="ev-overlay">
<div class="ev-content">
<h3><?php echo echoOutput($item['tr_name']); ?></h3>
<p><?php echo $item['total_properties']; ?> <?php echo echoOutput($translation['tr_27']); ?></p>
</div>
</div>
</div>
</a>
</div>
</div>

<?php } ?>
<?php if ($counter >= 6 && $counter <= 8){ ?>

<div>
<div class="uk-box-shadow-medium">
<a href="<?php echo $urlPath->properties(['city' => $item['tr_slug']]); ?>">
<div class="ev-featured-city-1" style="background: url(<?php echo $urlPath->image($item['pt_city_image']); ?>);">
<div class="ev-overlay">
<div class="ev-content">
<h3><?php echo echoOutput($item['tr_name']); ?></h3>
<p><?php echo $item['total_properties']; ?> <?php echo echoOutput($translation['tr_27']); ?></p>
</div>
</div>
</div>
</a>
</div>
</div>


<?php } ?>
<?php if ($counter == 8){ ?>

</div>

<?php } $counter++; } ?>

</div>

<?php endif; ?>