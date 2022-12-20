<?php

$testimonials = getTestimonials($connect, $lang);

require './sections/views/testimonials.view.php';

?>