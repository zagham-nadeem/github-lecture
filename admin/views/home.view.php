<?php require'sidebar.php'; ?>

<!--Page Container-->
<section class="page-container">
    <div class="page-content-wrapper">

       <!--Main Content-->
       <div class="content sm-gutter">
        <div class="container-fluid padding-25 sm-padding-10">
            <div class="row">

                <div class="col-12">
                    <div class="section-title">
                        <h4><?php echo _SECTIONES; ?></h4>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="block counter-block mb-4">
                        <div class="value"><?php echo $properties_total; ?></div>
                        <i class="dripicons-home i-icon"></i>
                        <p class="label"><?php echo _PROPERTIES; ?></p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="block counter-block mb-4">
                        <div class="value"><?php echo $posts_total; ?></div>
                        <i class="dripicons-article i-icon"></i>
                        <p class="label"><?php echo _POSTS; ?></p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="block counter-block mb-4">
                        <div class="value"><?php echo $users_total; ?></div>
                        <i class="dripicons-user-group i-icon"></i>
                        <p class="label"><?php echo _USERS; ?></p>
                    </div>
                </div>

                <div class="col-12">
                    <div class="section-title">
                        <h4><?php echo _SUMMARY; ?></h4>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="block table-block mb-4">
                        <div class="block-heading d-flex align-items-center">
                            <h5 class="text-truncate"><?php echo _PROPERTIES; ?></h5>
                            <div class="graph-pills graph-home">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active active-2" href="../controller/properties.php"><?php echo _VIEWALL; ?> <i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                            <div class="table-responsive text-no-wrap">
                                <table class="table">
                                    <tbody class="text-middle">
                                        <?php foreach($properties as $property): ?>
                                            <tr>
                                                <td class="product" width="50px">
                                                    <img class="product-img product-img-w" src="../../images/<?php echo $property['pt_image']; ?>">
                                                </td>
                                                <td class="name"><span class="span-title"><?php echo echoOutput($property['tr_title']); ?></span></td>
                                                <td align="right" class="text-muted"><?php echo FormatDate($connect, $property['pt_date']); ?></td> 
                                            </tr>

                                        <?php endforeach; ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div> 

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="block table-block mb-4">
                        <div class="block-heading d-flex align-items-center">
                            <h5 class="text-truncate"><?php echo _POSTS; ?></h5>
                            <div class="graph-pills graph-home">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active active-2" href="../controller/posts.php"><?php echo _VIEWALL; ?> <i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                            <div class="table-responsive text-no-wrap">
                                <table class="table">
                                    <tbody class="text-middle">
                                        <?php foreach($posts as $post): ?>
                                            <tr>
                                                <td class="product" width="50px">
                                                    <img class="product-img product-img-w" src="../../images/<?php echo $post['post_image']; ?>">
                                                </td>
                                                <td class="name"><span class="span-title"><?php echo echoOutput($post['tr_title']); ?></span></td>
                                                <td align="right" class="text-muted"><?php echo FormatDate($connect, $post['post_date']); ?></td>
                                                </tr>

                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>