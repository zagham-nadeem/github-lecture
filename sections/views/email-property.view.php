<div id="email-modal" class="uk-flex-top" uk-modal>
<div class="ev-modal uk-modal-dialog uk-width-1-1 uk-width-1-3@m uk-border-rounded uk-margin-auto-vertical">

<button class="uk-modal-close-default" type="button" uk-close></button>

<div class="uk-modal-header uk-border-rounded">
<h4 class="uk-modal-title"><?php echo echoOutput($translation['tr_119']); ?></h4>
</div>

<div class="uk-modal-body">

<div class="email-form">

<form class="uk-grid-small" method="post" uk-grid>

<input type="hidden" id="pid" name="pid" value="<?php echo $itemDetails['pt_id']; ?>">
<input type="hidden" id="ptitle" name="ptitle" value="<?php echo $itemDetails['tr_title']; ?>">
<input type="hidden" id="pref" name="pref" value="<?php echo $itemDetails['pt_reference']; ?>">
<input type="hidden" id="pimage" name="pimage" value="<?php echo $urlPath->image($itemDetails['pt_image']); ?>">
<input type="hidden" id="pprice" name="pprice" value="<?php echo getPrice($itemDetails['pt_price']); ?>">
<input type="hidden" id="purl" name="purl" value="<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>">

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: user"></span>
<input class="uk-input uk-form-large uk-border-rounded" placeholder="<?php echo echoOutput($translation['tr_191']); ?>" id="sendername" name="sendername" type="text">
</div>
</div>
</div>

<label class="ev-error-label errors" id="errorNameText" style="display: none;"></label>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: mail"></span>
<input class="uk-input uk-form-large uk-border-rounded" placeholder="<?php echo echoOutput($translation['tr_192']); ?>" id="senderemail" name="senderemail" type="email">
</div>
</div>
</div>

<label class="ev-error-label errors" id="errorUserText" style="display: none;"></label>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: mail"></span>
<input class="uk-input uk-form-large uk-border-rounded" placeholder="<?php echo echoOutput($translation['tr_193']); ?>" id="friendemail" name="friendemail" type="email">
</div>
</div>
</div>

<label class="ev-error-label errors" id="errorFriendText" style="display: none;"></label>

<div class="uk-width-1-1">
<div class="uk-margin">
<button class="uk-button uk-button-primary uk-border-rounded uk-width-1-1" type="submit">
	<span id="submit"><?php echo echoOutput($translation['tr_143']); ?> <i class="fas fa-angle-right uk-margin-small-left"></i></span>
	<span id="loading" style="display: none;"><?php echo echoOutput($translation['tr_188']); ?></span>
</button>
</div>
</div>

</form>

<div class="uk-width-1-1 uk-text-left uk-margin-small">

<div class="ev-notify ev-notify-danger uk-text-small uk-border-rounded uk-margin-remove" id="error" style="display: none;">
<p><i class="fas fa-exclamation-triangle uk-margin-small-right"></i> <?php echo echoOutput($translation['tr_168']); ?></p>
</div>

</div>

</div>

<div class="uk-width-1-1 uk-text-left">
<div class="ev-notify ev-notify-success uk-text-small uk-border-rounded uk-margin-remove" id="sendsuccess" style="display: none;">
<p><i class="fas fa-check uk-margin-small-right"></i> <?php echo echoOutput($translation['tr_170']); ?></p>
</div>
</div>

</div>

</div>
</div>