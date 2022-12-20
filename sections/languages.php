<?php if (count($getLanguages) >= 2): ?>

<?php if (empty($getLanguagesByPage)): ?>

<div class="uk-navbar-right uk-flex uk-flex-center uk-flex-right@m">
<ul class="uk-subnav uk-subnav-divider">
<?php foreach($getLanguages as $item): ?>
<li class="<?php echo $item['language_code'] == $lang ? 'uk-active' : 'uk-inactive' ?>">
<a class="<?php echo $item['language_code'] == $lang ? 'active-language' : 'change-lang' ?>" data-lang="<?php echo echoOutput($item['language_code']); ?>"><?php echo echoOutput($item['language_name']); ?></a>
</li>
<?php endforeach; ?>
</ul>
</div>

<?php endif; ?>

<?php if (!empty($getLanguagesByPage)): ?>

<div class="uk-navbar-right  uk-flex uk-flex-center uk-flex-right@m">
<ul class="uk-subnav uk-subnav-divider">
<?php foreach($getLanguagesByPage as $item): ?>
<li class="<?php echo $item['language_code'] == $lang ? 'uk-active' : 'uk-inactive' ?>">
<a class="<?php echo $item['language_code'] == $lang ? 'active-language' : 'change-lang' ?>" data-lang="<?php echo echoOutput($item['language_code']); ?>"><?php echo echoOutput($item['language_name']); ?></a>
</li>
<?php endforeach; ?>
</ul>
</div>

<?php endif; ?>

<?php endif; ?>

