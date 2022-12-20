<div class="ev-section-light ev-bottom-border">

<div class="ev-container ev-section-padding-v-m ev-advanced-search">

<div class="ev-title-dark uk-text-center uk-margin-remove-top">
<p><?php echo echoOutput($translation['tr_11']); ?></p>
<h3><?php echo echoOutput($translation['tr_12']); ?></h3>
</div>

<form class="uk-grid-small" method="get" action="<?php echo $urlPath->search(); ?>" id="searchForm" uk-grid>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_13']); ?></label>

<select class="nc-select wide uk-form-large" name="city">
<option selected value data-display="<?php echo echoOutput($translation['tr_13']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach($cities as $item): ?>
<option value="<?php echo $item['pt_city_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">

<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_14']); ?></label>

<select class="nc-select wide uk-form-large" name="type">
<option selected value data-display="<?php echo echoOutput($translation['tr_14']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach($types as $item): ?>
<option value="<?php echo $item['pt_type_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_15']); ?></label>

<select class="nc-select wide uk-form-large" name="status">
<option selected value data-display="<?php echo echoOutput($translation['tr_15']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach($status as $item): ?>
<option value="<?php echo $item['pt_status_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_16']); ?></label>

<select class="nc-select wide uk-form-large" name="condition">
<option selected value data-display="<?php echo echoOutput($translation['tr_16']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach($conditions as $item): ?>
<option value="<?php echo $item['pt_conditions_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_17']); ?></label>

<select class="nc-select wide uk-form-large" name="minbeds">
<option selected value data-display="<?php echo echoOutput($translation['tr_17']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php for ($num = 1; $num <= 10; $num++) { ?>
<option value="<?php echo $num; ?>"><?php echo $num; ?></option>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_18']); ?></label>

<select class="nc-select wide uk-form-large" name="minbaths">
<option selected value data-display="<?php echo echoOutput($translation['tr_18']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php for ($num = 1; $num <= 10; $num++) { ?>
<option value="<?php echo $num; ?>"><?php echo $num; ?></option>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_19']); ?></label>

<select class="nc-select wide uk-form-large" name="minprice">
<option selected value data-display="<?php echo echoOutput($translation['tr_19']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach (range(100, 1000, 200) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(1000, 10000, 1000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(20000, 100000, 10000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(200000, 500000, 100000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(1000000, 5000000, 1000000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_20']); ?></label>

<select class="nc-select wide uk-form-large" name="maxprice">
<option selected value data-display="<?php echo echoOutput($translation['tr_20']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach (range(100, 1000, 200) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(1000, 10000, 1000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(20000, 100000, 10000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(200000, 500000, 100000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
<?php foreach (range(1000000, 5000000, 1000000) as $range) { ?>
<option value="<?php echo $range; ?>">
<?php echo getPrice($range); ?>
</option>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_100']); ?></label>

<select class="nc-select wide uk-form-large" name="minarea">
<option selected value data-display="<?php echo echoOutput($translation['tr_100']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach (range(50, 1000, 100) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php endforeach; ?>
<?php foreach (range(1000, 9000, 500) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php endforeach; ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-2@s uk-width-1-4@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_101']); ?></label>

<select class="nc-select wide uk-form-large" name="maxarea">
<option selected value data-display="<?php echo echoOutput($translation['tr_101']); ?>"><?php echo echoOutput($translation['tr_23']); ?></option>
<?php foreach (range(50, 1000, 100) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php endforeach; ?>
<?php foreach (range(1000, 9000, 500) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php endforeach; ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-1 uk-width-1-2@m">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label uk-hidden@m"><?php echo echoOutput($translation['tr_112']); ?></label>

<input class="uk-input uk-form-large uk-border-rounded" name="reference" placeholder="<?php echo echoOutput($translation['tr_112']); ?>" type="text">
</div>
</div>
</div>

<div class="uk-width-1-1@s uk-width-5-6@m">
<div class="uk-margin">
<ul class="ev-other-features" uk-accordion>
<li>
<a class="uk-accordion-title" href="#"><?php echo echoOutput($translation['tr_21']); ?></a>
<div class="uk-accordion-content">

<div class="uk-grid-small" uk-grid>

<?php foreach($extras as $item): ?>

<div class="uk-width-1-2@s uk-width-1-3@m uk-width-1-4@l">
<label class="uk-text-truncate"><input name="extras[]" value="<?php echo $item['pt_extra_id']; ?>" class="uk-checkbox" type="checkbox"><?php echo echoOutput($item['tr_name']); ?></label>
</div>

<?php endforeach; ?>

</div>

</div>
</li>
</ul>
</div>
</div>

<div class="uk-width-1-1@s uk-width-1-6@m">
<div class="uk-margin">
<button class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-margin-small-top uk-width-1-1 uk-text-truncate" type="submit"><?php echo echoOutput($translation['tr_22']); ?> <i class="fa fa-angle-right uk-margin-small-left"></i></button>
</div>
</div>

</form>

</div>
</div>
