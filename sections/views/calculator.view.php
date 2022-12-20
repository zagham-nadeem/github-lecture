<div class="ev-property-widget">
<div>
<h5 class="ev-title uk-heading-line"><span><?php echo echoOutput($translation['tr_87']); ?></span></h5>

<div class="uk-grid-small" uk-grid>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-form-large uk-border-rounded" id="inCost" placeholder="<?php echo echoOutput($translation['tr_88']); ?>" type="text">
</div>
</div>
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-form-large uk-border-rounded" id="inDown" placeholder="<?php echo echoOutput($translation['tr_89']); ?>" type="text">
</div>
</div>
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-form-large uk-border-rounded" id="inAPR" placeholder="<?php echo echoOutput($translation['tr_90']); ?>" type="text">
</div>
</div>
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-form-large uk-border-rounded" id="inPeriod" placeholder="<?php echo echoOutput($translation['tr_91']); ?>" type="text">
</div>
</div>
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<button class="uk-button uk-button-primary uk-border-rounded uk-width-1-1" id="btnCalculate"><?php echo echoOutput($translation['tr_92']); ?> <i class="fas fa-angle-right uk-margin-small-left"></i></button>
</div>
</div>

<div class="uk-width-1-1 uk-text-center" id="inResults">
<div class="uk-animation-fade">
<p class="uk-margin-remove"><?php echo echoOutput($translation['tr_93']); ?> <span class="uk-text-bold"><?php echo echoOutput($settings['st_currency']); ?><span id="outMontly"></span></span></p>
</div>
</div>

</div>

</div>
</div>