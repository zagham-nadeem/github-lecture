<!-- PAGE CONTENT -->
<div class="ev-page-container">

<div class="uk-grid-large" uk-grid>

<div class="uk-width-expand@m">

<h3 class="uk-text-bold uk-margin-small-bottom"><?php echo echoOutput($translation['tr_134']); ?></h3>
<p class="uk-margin-small-top uk-margin-medium-bottom"><?php echo echoOutput($translation['tr_135']); ?></p>

<div class="contact-form">
<form class="ev-contact-1 uk-grid-small uk-margin-medium-top" method="post" uk-grid>
<div class="uk-width-1-2@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: user"></span>
<input class="uk-input uk-form-large" placeholder="<?php echo echoOutput($translation['tr_138']); ?>" id="name" name="name" type="text">
</div>

<label class="ev-error-label errors" id="errorNameText" style="display: none;"></label>

</div>
</div>
<div class="uk-width-1-2@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: receiver"></span>
<input class="uk-input uk-form-large" placeholder="<?php echo echoOutput($translation['tr_140']); ?>" id="phone" name="phone" type="text">
</div>

</div>
</div>
<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: mail"></span>
<input class="uk-input uk-form-large" placeholder="<?php echo echoOutput($translation['tr_139']); ?>" id="email" name="email" type="email">
</div>

<label class="ev-error-label errors errors" id="errorEmailText" style="display: none;"></label>

</div>
</div>
<div class="uk-width-1-1 uk-inline">
<textarea class="uk-textarea uk-form-large" rows="3" placeholder="<?php echo echoOutput($translation['tr_141']); ?>" id="message" name="message"></textarea>
</div>

<label class="ev-error-label errors" id="errorMessageText" style="display: none;"></label>

<div class="uk-width-1-1 uk-text-left uk-margin-small-left">
<label id="checked">
<input class="uk-checkbox" type="checkbox" id="ischecked"> <span class="ev-checkbox-label" style="max-width: 450px"><span class="uk-link-reset"><?php echo echoOutput($translation['tr_155']); ?> <a class="uk-link-reset" target="_blank" href="<?php echo $urlPath->privacy(); ?>"> <b><?php echo echoOutput($defaultPrivacyPage['tr_title']); ?></b></a>, <a class="uk-link-reset" target="_blank" href="<?php echo $urlPath->terms(); ?>"> <b><?php echo echoOutput($defaultTermsPage['tr_title']); ?></b></a></span></span></label>
</div>

<div class="g-recaptcha"
data-sitekey="<?php echo $settings['st_recaptchakey']; ?>"
data-size="invisible"
data-callback="contactForm">
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<button class="uk-button uk-width-1-1" type="submit">
	<span id="submit"><?php echo echoOutput($translation['tr_143']); ?> <i class="fas fa-angle-right uk-margin-small-left"></i></span>
	<span id="loading" style="display: none;"><?php echo echoOutput($translation['tr_188']); ?></span>
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

<div class="uk-width-1-2@m">

<h3 class="uk-text-bold uk-margin-small-bottom"><?php echo echoOutput($translation['tr_136']); ?></h3>
<p class="uk-margin-small-top uk-margin-medium-bottom"><?php echo echoOutput($translation['tr_137']); ?></p>

<div class="ev-contact-item">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<i class="ev-icon fas fa-comments"></i>
</div>
<div class="uk-width-expand">
<h3 class="ev-title"><?php echo echoOutput($translation['tr_5']); ?></h3>
<a class="ev-meta" href="mailto:info@company.com"><?php echo $settings['st_email']; ?></a>
</div>
</div>
</div>

<div class="ev-contact-item">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<i class="ev-icon fas fa-phone-alt"></i>
</div>
<div class="uk-width-expand">
<h3 class="ev-title"><?php echo echoOutput($translation['tr_6']); ?></h3>
<a class="ev-meta" href="tel:<?php echo $settings['st_phone']; ?>"><?php echo $settings['st_phone']; ?></a>
</div>
</div>
</div>

<div>
<div class="ev-contact-item">
<div class="uk-grid-small uk-flex-middle" uk-grid>
<div class="uk-width-auto">
<i class="ev-icon fas fa-map-marker-alt"></i>
</div>
<div class="uk-width-expand">
<h3 class="ev-title"><?php echo echoOutput($translation['tr_4']); ?></h3>
<a class="ev-meta" href="https://www.google.com/maps/search/?api=1&query=<?php echo $settings['st_officeaddress']; ?>" target="_blank"><?php echo $settings['st_officeaddress']; ?></a>
</div>
</div>
</div>
</div>
</div>
</div>

<?php if(!empty($itemDetails['tr_content'])): ?>
<div class="uk-width-1-1">
<?php echo $itemDetails['tr_content']; ?>
</div>
<?php endif; ?>

</div>

<!-- END PAGE CONTENT -->
