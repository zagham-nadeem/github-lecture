<div class="ev-property-widget">
<h5 class="ev-title uk-heading-line"><span><?php echo echoOutput($translation['tr_78']); ?></span></h5>

<div class="property-form">
<form class="uk-grid-small" method="post" uk-grid>

<input type="hidden" id="ref" value="<?php echo echoOutput($itemDetails['pt_reference']); ?>">
<input type="hidden" id="url" value="<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>">

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: user"></span>
<input class="uk-input uk-form-large uk-border-rounded" placeholder="<?php echo echoOutput($translation['tr_79']); ?>" id="name" name="name" type="text">
</div>
</div>
</div>

<label class="ev-error-label errors" id="errorNameText" style="display: none;"></label>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: mail"></span>
<input class="uk-input uk-form-large uk-border-rounded" placeholder="<?php echo echoOutput($translation['tr_80']); ?>" id="email" name="email" type="email">
</div>
</div>
</div>

<label class="ev-error-label errors" id="errorEmailText" style="display: none;"></label>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: receiver"></span>
<input class="uk-input uk-form-large uk-border-rounded" placeholder="<?php echo echoOutput($translation['tr_81']); ?>" id="phone" name="phone" type="text">
</div>
</div>
</div>

<label class="ev-error-label errors" id="errorPhoneText" style="display: none;"></label>

<div class="uk-width-1-1">
<textarea class="uk-textarea uk-form-large uk-border-rounded" rows="3" id="message" name="message" placeholder="Message"><?php echo echoOutput($translation['tr_83']); ?></textarea>
</div>

<label class="ev-error-label errors" id="errorMessageText" style="display: none;"></label>

<div class="uk-width-1-1">
<label class="uk-text-light" id="checked">
<input class="uk-checkbox" type="checkbox" id="ischecked"> <span class="ev-checkbox-label" style="max-width: 250px"><span class="uk-link-reset"><?php echo echoOutput($translation['tr_155']); ?> <a class="uk-link-reset" href="<?php echo $urlPath->privacy(); ?>"> <b><?php echo echoOutput($defaultPrivacyPage['tr_title']); ?></b></a>, <a class="uk-link-reset" href="<?php echo $urlPath->terms(); ?>"> <b><?php echo echoOutput($defaultTermsPage['tr_title']); ?></b></a></span></span></label>
</div>

<div class="g-recaptcha"
data-sitekey="<?php echo $settings['st_recaptchakey']; ?>"
data-size="invisible"
data-callback="propertyForm">
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<button class="uk-button uk-button-primary uk-border-rounded uk-width-1-1" type="submit">
	<span id="submit"><?php echo echoOutput($translation['tr_143']); ?> <i class="fa fa-angle-right uk-margin-small-left"></i></span>
	<span id="loading" style="display: none;">Please Wait...</span>
</button>
</div>
</div>

</form>

<div class="uk-width-1-1 uk-text-left uk-margin-small">

<div class="ev-notify ev-notify-danger uk-text-small uk-animation uk-animation-fade uk-border-rounded uk-margin-remove" id="error" style="display: none;">
<p><i class="fas fa-exclamation-triangle uk-margin-small-right"></i> <?php echo echoOutput($translation['tr_168']); ?></p>
</div>

</div>

</div>

<div class="uk-width-1-1 uk-text-left uk-margin-small">
<div class="ev-notify ev-notify-success uk-text-small uk-animation uk-animation-fade uk-border-rounded uk-margin-remove" id="success" style="display: none;">
<p><i class="fas fa-check uk-margin-small-right"></i> <?php echo echoOutput($translation['tr_170']); ?></p>
</div>
</div>

</div>