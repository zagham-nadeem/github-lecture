<nav class="ev-mobile-nav uk-navbar-container uk-padding uk-hidden@m" uk-navbar>

<div class="uk-navbar-left">
<a class="uk-button uk-button-link ev-button" href="#sidemenu" uk-toggle>
<i class="fas fa-bars"></i>
</a>
</div>

<div class="uk-navbar-center">

<a class="uk-navbar-item uk-logo" href="<?php echo $urlPath->home(); ?>">
<img src="<?php echo $urlPath->image($theme['th_logo']); ?>">
</a>

</div>

<div class="uk-navbar-right">
<a class="uk-button uk-button-link ev-button" href="<?php echo $urlPath->search(); ?>">
<i class="fas fa-search"></i>
</a>
</nav>
