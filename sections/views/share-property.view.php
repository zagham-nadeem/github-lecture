<div id="share-modal" class="uk-flex-top" uk-modal>
<div class="ev-modal uk-modal-dialog uk-width-1-1 uk-width-1-3@m uk-border-rounded uk-margin-auto-vertical">

<button class="uk-modal-close-default" type="button" uk-close></button>

<div class="uk-modal-header uk-border-rounded">
<h4 class="uk-modal-title"><?php echo echoOutput($translation['tr_116']); ?></h4>
</div>

<div class="uk-modal-body">


<div class="uk-grid-small uk-width-1-1 uk-child-width-1-2@s uk-text-center" uk-grid>

<div>
<a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u=<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>" target="_blank" rel="noopener" aria-label="Facebook">
<div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
<i class="fab fa-facebook-f"></i></div>Facebook</div>
</a>
</div>

<div>
<a class="resp-sharing-button__link" href="https://twitter.com/intent/tweet/?text=<?php echo echoOutput($itemDetails['tr_title']); ?>&amp;url=<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>" target="_blank" rel="noopener" aria-label="Twitter">
<div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
<i class="fab fa-twitter"></i></div>Twitter</div>
</a>
</div>

<div>
<a class="resp-sharing-button__link" href="https://www.tumblr.com/widgets/share/tool?posttype=link&amp;title=<?php echo echoOutput($itemDetails['tr_title']); ?>&amp;caption=<?php echo echoOutput($itemDetails['tr_title']); ?>&amp;content=<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>&amp;canonicalUrl=<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>&amp;shareSource=tumblr_share_button" target="_blank" rel="noopener" aria-label="Tumblr">
<div class="resp-sharing-button resp-sharing-button--tumblr resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
<i class="fab fa-tumblr"></i></div>Tumblr</div>
</a>
</div>

<div>
<a class="resp-sharing-button__link" href="https://pinterest.com/pin/create/button/?url=<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>&amp;media=<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>&amp;description=<?php echo echoOutput($itemDetails['tr_title']); ?>" target="_blank" rel="noopener" aria-label="Pinterest">
<div class="resp-sharing-button resp-sharing-button--pinterest resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
<i class="fab fa-pinterest-p"></i></div>Pinterest</div>
</a>
</div>

<div>
<a class="resp-sharing-button__link" href="whatsapp://send?text=<?php echo echoOutput($itemDetails['tr_title']); ?>%20<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
<div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
<i class="fab fa-whatsapp"></i></div>WhatsApp</div>
</a>
</div>

<div>

<a class="resp-sharing-button__link" href="https://telegram.me/share/url?text=<?php echo echoOutput($itemDetails['tr_title']); ?>&amp;url=<?php echo $urlPath->property($itemDetails['pt_id'], $itemDetails['tr_slug']); ?>" target="_blank" rel="noopener" aria-label="Share on Telegram">
<div class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
<i class="fab fa-telegram-plane"></i>
</div>Telegram</div>
</a>

</div>

</div>
</div>

</div>
</div>