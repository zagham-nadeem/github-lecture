<?php

// Get Menu Footer

$footermenu = getFooterMenu($connect, $lang);

$navigationFooter = getNavigation($connect, $footermenu['menu_id'], $lang);

require './sections/views/footer.view.php';

?>