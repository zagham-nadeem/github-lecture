<div class="update-profile">

<form class="uk-child-width-1-1 uk-child-width-1-2@s uk-margin-medium-top" uk-grid>

<input type="hidden" id="user_id" value="<?php echo echoOutput($userInfo['user_id']); ?>">

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_138']); ?></label>
<div class="uk-form-controls">
<input class="uk-input uk-border-rounded" type="text" id="user_name" name="user_name" value="<?php echo echoOutput($userInfo['user_name']); ?>">
</div>
</div>

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_81']); ?></label>
<div class="uk-form-controls">
<input class="uk-input uk-border-rounded" type="text" id="user_phone" name="user_phone" value="<?php echo echoOutput($userInfo['user_phone']); ?>">
</div>
</div>

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_184']); ?></label>
<div class="uk-form-controls">
<input type="text" value="<?php echo echoOutput($userInfo['user_password']); ?>" id="user_password_save" name="user_password_save" hidden>
<input class="uk-input uk-border-rounded" id="user_password" name="user_password" type="password">
</div>
</div>

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_185']); ?></label>
<div class="uk-form-controls">
<input class="uk-input uk-border-rounded" id="user_confirm_password" name="user_confirm_password" type="password">
</div>
</div>

<div class="uk-width-1-1">

<hr>

<button class="uk-button uk-button-primary uk-border-rounded" value="<?php echo echoOutput($translation['tr_186']); ?>" type="submit" id="submit-send"><?php echo echoOutput($translation['tr_186']); ?></button>
<a class="uk-button uk-button-default uk-border-rounded" onclick="window.history.back();"><?php echo echoOutput($translation['tr_187']); ?></a>

<div id="showresults"></div>

</div>

</form>
</div>

</div>