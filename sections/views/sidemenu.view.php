<!-- SIDEMENU -->

<div class="ev-sidemenu" id="sidemenu" uk-offcanvas="overlay: true;">

    <div class="uk-offcanvas-bar uk-flex uk-flex-column">

        <button class="uk-offcanvas-close" type="button" uk-close></button>

            <div class="uk-width-1-1 uk-flex uk-flex-middle uk-flex-center">
                <a href="<?php echo $urlPath->home(); ?>">
                <img class="uk-logo" src="<?php echo $urlPath->image($theme['th_logo']); ?>">
                </a>
            </div>

        <?php if (isLogged()): ?>

        <article class="uk-comment ev-profile-header" style="margin: 14px 0;">
        <header class="uk-comment-header">
        <div class="uk-grid-small uk-flex-middle" uk-grid>
        <div class="uk-width-auto">
        <img class="uk-comment-avatar" src="<?php echo getGravatar($userInfo['user_email']); ?>" alt="">
        </div>
        <div class="uk-width-expand">
        <h4 class="uk-comment-title uk-margin-remove"><?php echo echoOutput(textTruncate($userInfo['user_name'], 10)); ?></h4>
        <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" href="<?php echo $urlPath->profile(); ?>"><?php echo $translation['tr_10']; ?></a></p>
        </div>
        </div>
        </header>
        </article>

        <?php endif; ?>

        <?php if (!isLogged()): ?>

        <a class="ev-signin uk-button uk-border-pill" href="<?php echo $urlPath->signin(); ?>">
        <i class="fas fa-user uk-margin-small-right"></i> <?php echo $translation['tr_48']; ?>
        </a>

        <?php endif; ?>
        <ul class="ev-main-menu uk-nav-default uk-margin-small-bottom" uk-nav>
        <?php foreach($navigationHeader as $item): ?>
        <?php if ($item['navigation_type'] == 'custom') { ?>
        <li><a href="<?php echo $item['navigation_url']; ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
        <?php } else { ?>
        <li><a href="<?php echo $urlPath->page($item['navigation_url']); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
        <?php } ?>
        <?php endforeach; ?>
        </ul>

        <div class="uk-width-1-1 uk-flex uk-flex-center">
        <ul class="ev-followus uk-iconnav uk-margin-small-top uk-margin-small-bottom">
        <?php foreach($socialMedia as $item): ?>
        <?php if (!empty($item['st_facebook'])): ?>
        <li><a href="<?php echo $item['st_facebook'] ?>" uk-icon="icon: facebook" style="color: #3b5998"></a></li>
        <?php endif;?>
        <?php if (!empty($item['st_twitter'])): ?>
        <li><a href="<?php echo $item['st_twitter'] ?>" uk-icon="icon: twitter" style="color: #1da1f2"></a></li>
        <?php endif;?>
        <?php if (!empty($item['st_youtube'])): ?>
        <li><a href="<?php echo $item['st_youtube'] ?>" uk-icon="icon: youtube" style="color: #ff0000"></a></li>
        <?php endif;?>
        <?php if (!empty($item['st_linkedin'])): ?>
        <li><a href="<?php echo $item['st_linkedin'] ?>" uk-icon="icon: linkedin" style="color: #0077b5"></a></li>
        <?php endif;?>
        <?php if (!empty($item['st_instagram'])): ?>
        <li><a href="<?php echo $item['st_instagram'] ?>" uk-icon="icon: instagram" style="color: #c13584"></a></li>
        <?php endif;?>
        <?php if (!empty($item['st_whatsapp'])): ?>
        <li><a href="<?php echo $item['st_whatsapp'] ?>" uk-icon="icon: whatsapp" style="color: #25d366"></a></li>
        <?php endif;?>
        <?php endforeach; ?>
        </ul>
        </div>

    </div>

</div>

<!-- END SIDEMENU -->