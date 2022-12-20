<div id="advanced-search" class="uk-modal-full" uk-modal>
<div class="uk-modal-dialog">
<button class="uk-modal-close-default" type="button" uk-close></button>
<div class="uk-modal-body" uk-overflow-auto>

<h5 class="uk-heading-line uk-text-center uk-text-bold"><span><?php echo echoOutput($translation['tr_98']); ?></span></h5>

<form class="uk-grid-small uk-padding-small" method="get" action="<?php echo $urlPath->search(); ?>" id="searchModalForm" uk-grid>

<div class="uk-width-1-1 uk-width-1-2@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">

<label class="uk-form-label"><?php echo echoOutput($translation['tr_112']); ?></label>

<?php if(getParamsReference()) { ?>
<input class="uk-input uk-form-large uk-border-rounded" name="reference" value="<?php echo echoOutput(getParamsReference()); ?>" type="text">
<?php } ?>

<?php if(!getParamsReference() && !getParamsReference()) { ?>
<input class="uk-input uk-form-large uk-border-rounded" name="reference" placeholder="<?php echo echoOutput($translation['tr_113']); ?>" type="text">
<?php } ?>

</div>
</div>
</div>

<div class="uk-width-1-1 uk-width-1-2@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">

<label class="uk-form-label"><?php echo echoOutput($translation['tr_13']); ?></label>

<select class="nc-select wide uk-form-large cities" name="city">

<?php if(getParamsCity()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($cities as $item){ if(getParamsCity() == $item['pt_city_id']){
echo '<option value="'.getParamsCity().'" selected>'.echoOutput($item['tr_name']).'</option>';
}else{
echo '<option value="'.$item['pt_city_id'].'">'.echoOutput($item['tr_name']).'</option>';
}}} ?>

<?php if(!getParamsCity()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($cities as $item): ?>
<option value="<?php echo $item['pt_city_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; } ?>

</select>

</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-1@s">
<div class="uk-margin">

<div class="uk-width-1-1 uk-inline">

<label class="uk-form-label"><?php echo echoOutput($translation['tr_99']); ?></label>

<select class="nc-select wide uk-form-large zones" name="zone">

<?php if(!getParamsZone() && !getParamsCity()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?></option>
<?php } ?>

</select>

</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-1@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_15']); ?></label>
<select class="nc-select wide uk-form-large" name="status">
<?php if(getParamsStatus()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($status as $item){ if(getParamsStatus() == $item['pt_status_id']){
echo '<option value="'.getParamsStatus().'" selected>'.echoOutput($item['tr_name']).'</option>';
}else{
echo '<option value="'.$item['pt_status_id'].'">'.echoOutput($item['tr_name']).'</option>';
}}} ?>

<?php if(!getParamsStatus()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($status as $item): ?>
<option value="<?php echo $item['pt_status_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-1@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_14']); ?></label>
<select class="nc-select wide uk-form-large" name="type">
<?php if(getParamsType()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($types as $item){ if(getParamsType() == $item['pt_type_id']){
echo '<option value="'.getParamsType().'" selected>'.echoOutput($item['tr_name']).'</option>';
}else{
echo '<option value="'.$item['pt_type_id'].'">'.echoOutput($item['tr_name']).'</option>';
}}} ?>

<?php if(!getParamsType()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($types as $item): ?>
<option value="<?php echo $item['pt_type_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-1@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_16']); ?></label>
<select class="nc-select wide uk-form-large" name="condition">
<?php if(getParamsCondition()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($conditions as $item){ if(getParamsCondition() == $item['pt_conditions_id']){
echo '<option value="'.getParamsCondition().'" selected>'.echoOutput($item['tr_name']).'</option>';
}else{
echo '<option value="'.$item['pt_conditions_id'].'">'.echoOutput($item['tr_name']).'</option>';
}}} ?>

<?php if(!getParamsCondition()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach($conditions as $item): ?>
<option value="<?php echo $item['pt_conditions_id']; ?>"><?php echo echoOutput($item['tr_name']); ?></option>
<?php endforeach; } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_17']); ?></label>
<select class="nc-select wide uk-form-large" name="minbeds">
<?php if(getParamsMinBeds()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php for ($num = 1; $num <= 10; $num++) { ?>
<?php if ($num == getParamsMinBeds()) { ?>
<option value="<?php echo $num; ?>" selected><?php echo $num; ?></option>
<?php } else{ ?>
<option value="<?php echo $num; ?>"><?php echo $num; ?></option>    
<?php }}} ?>

<?php if(!getParamsMinBeds()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php for ($num = 1; $num <= 10; $num++) { ?>
<option value="<?php echo $num; ?>"><?php echo $num; ?></option>
<?php }} ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_18']); ?></label>
<select class="nc-select wide uk-form-large" name="minbaths">
<?php if(getParamsMinBaths()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php for ($num = 1; $num <= 10; $num++) { ?>
<?php if ($num == getParamsMinBaths()) { ?>
<option value="<?php echo $num; ?>" selected><?php echo $num; ?></option>
<?php } else{ ?>
<option value="<?php echo $num; ?>"><?php echo $num; ?></option>    
<?php }}} ?>

<?php if(!getParamsMinBaths()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php for ($num = 1; $num <= 10; $num++) { ?>
<option value="<?php echo $num; ?>"><?php echo $num; ?></option>
<?php }} ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_100']); ?></label>
<select class="nc-select wide uk-form-large" name="minarea">
<?php if(getParamsMinArea()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(50, 1000, 100) as $range): ?>
<?php if ($range == getParamsMinArea()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getUnit($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMinArea()) { ?>
<?php foreach (range(1000, 9000, 500) as $range): ?>
<?php if ($range == getParamsMinArea()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getUnit($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMinArea()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(50, 1000, 100) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMinArea()) { ?>
<?php foreach (range(1000, 9000, 500) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>
<?php endforeach; ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_101']); ?></label>
<select class="nc-select wide uk-form-large" name="maxarea">
<?php if(getParamsMaxArea()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(50, 1000, 100) as $range): ?>
<?php if ($range == getParamsMaxArea()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getUnit($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMaxArea()) { ?>
<?php foreach (range(1000, 9000, 500) as $range): ?>
<?php if ($range == getParamsMaxArea()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getUnit($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMaxArea()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(50, 1000, 100) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMaxArea()) { ?>
<?php foreach (range(1000, 9000, 500) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getUnit($range); ?></option>
<?php endforeach; ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_19']); ?></label>
<select class="nc-select wide uk-form-large" name="minprice">
<?php if(getParamsMinPrice()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(100, 1000, 200) as $range): ?>
<?php if ($range == getParamsMinPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMinPrice()) { ?>
<?php foreach (range(1000, 10000, 1000) as $range): ?>
<?php if ($range == getParamsMinPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMinPrice()) { ?>
<?php foreach (range(20000, 100000, 10000) as $range): ?>
<?php if ($range == getParamsMinPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMinPrice()) { ?>
<?php foreach (range(200000, 500000, 100000) as $range): ?>
<?php if ($range == getParamsMinPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMinPrice()) { ?>
<?php foreach (range(1000000, 5000000, 1000000) as $range): ?>
<?php if ($range == getParamsMinPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMinPrice()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(100, 1000, 200) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMinPrice()) { ?>
<?php foreach (range(1000, 10000, 1000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMinPrice()) { ?>
<?php foreach (range(200000, 500000, 100000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMinPrice()) { ?>
<?php foreach (range(200000, 500000, 100000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMinPrice()) { ?>
<?php foreach (range(1000000, 5000000, 1000000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>
</select>
</div>
</div>
</div>


<div class="uk-width-1-2">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<label class="uk-form-label"><?php echo echoOutput($translation['tr_20']); ?></label>
<select class="nc-select wide uk-form-large" name="maxprice">
<?php if(getParamsMaxPrice()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(100, 1000, 200) as $range): ?>
<?php if ($range == getParamsMaxPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMaxPrice()) { ?>
<?php foreach (range(1000, 10000, 1000) as $range): ?>
<?php if ($range == getParamsMaxPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMaxPrice()) { ?>
<?php foreach (range(20000, 100000, 10000) as $range): ?>
<?php if ($range == getParamsMaxPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMaxPrice()) { ?>
<?php foreach (range(200000, 500000, 100000) as $range): ?>
<?php if ($range == getParamsMaxPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(getParamsMaxPrice()) { ?>
<?php foreach (range(1000000, 5000000, 1000000) as $range): ?>
<?php if ($range == getParamsMaxPrice()) { ?>
<option value="<?php echo $range; ?>" selected><?php echo getPrice($range); ?></option>
<?php } else{ ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>    
<?php } ?>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMaxPrice()) { ?>
<option selected value> <?php echo echoOutput($translation['tr_23']); ?> </option>
<?php foreach (range(100, 1000, 200) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMaxPrice()) { ?>
<?php foreach (range(1000, 10000, 1000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMaxPrice()) { ?>
<?php foreach (range(200000, 500000, 100000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMaxPrice()) { ?>
<?php foreach (range(200000, 500000, 100000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>

<?php if(!getParamsMaxPrice()) { ?>
<?php foreach (range(1000000, 5000000, 1000000) as $range): ?>
<option value="<?php echo $range; ?>"><?php echo getPrice($range); ?></option>
<?php endforeach; ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="uk-width-1-2 uk-width-1-1@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">

<?php if(!getParamsOffers()) { ?>
<label class="ev-text-small"><input name="offers" value="1" class="uk-checkbox" type="checkbox"/><?php echo echoOutput($translation['tr_129']); ?></label>
<?php }else{ ?>
<label class="ev-text-small"><input name="offers" class="uk-checkbox" type="checkbox" value="1" checked /><?php echo echoOutput($translation['tr_129']); ?></label>
<?php } ?>

</div>
</div>
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<ul class="ev-other-features" uk-accordion>
<li class="<?php echo getParamsExtras() ? 'uk-open' : 'uk-close'; ?>">
<a class="uk-accordion-title" href="#"><?php echo echoOutput($translation['tr_21']); ?></a>
<div class="uk-accordion-content">

<div class="uk-grid-small" uk-grid>

<?php foreach($extras as $item): ?>

<?php if (getParamsExtras()) { ?>
<?php if (in_array($item['pt_extra_id'], getParamsExtras())) { ?>
<div class="uk-width-1-2">
<label class="uk-text-truncate">
<input name="extras[]" value="<?php echo $item['pt_extra_id']; ?>" class="uk-checkbox" type="checkbox" checked><?php echo echoOutput($item['tr_name']); ?>
</label>
</div>

<?php }else{ ?>
<div class="uk-width-1-2">
<label class="uk-text-truncate">
<input name="extras[]" value="<?php echo $item['pt_extra_id']; ?>" class="uk-checkbox" type="checkbox"><?php echo echoOutput($item['tr_name']); ?>
</label>
</div>
<?php }} ?>

<?php if (!getParamsExtras()) { ?>
<div class="uk-width-1-2">
<label class="uk-text-truncate">
<input name="extras[]" value="<?php echo $item['pt_extra_id']; ?>" class="uk-checkbox" type="checkbox"><?php echo echoOutput($item['tr_name']); ?>
</label>
</div>

<?php } ?>

<?php endforeach; ?>

</div>

</div>
</li>
</ul>
</div>
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<button class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-margin-small-top uk-width-1-1 uk-text-truncate" type="submit"><?php echo echoOutput($translation['tr_22']); ?> <i class="fas fa-angle-right uk-margin-small-left"></i></button>
</div>
</div>

</form>
</div>
</div>
</div>
