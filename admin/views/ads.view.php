<?php require 'sidebar.php'; ?>  

<!--Page Container-->
<section class="page-container">
  <div class="page-content-wrapper">

    <!--Main Content-->

    <div class="content sm-gutter">
      <div class="container-fluid padding-25 sm-padding-10">

        <div class="section-title">
          <h5 class="text-truncate"><?php echo _ADS; ?></h5>
        </div>

        <div class="row">
          
          <div class="col-12 c-col-12">
            <button type="button" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary"><i class="fa fa-plus add-new-i"></i> <?php echo _ADDITEM; ?></button>
          </div>

          <div class="col-12">
            <div class="block table-block mb-4 c-4">

              <div class="row">
                <div class="table-responsive">
                  <table class="display table table-striped">
                    <thead>
                      <tr>
                        <th><?php echo _TABLEFIELDID; ?></th>
                        <th><?php echo _TABLEFIELDTITLE; ?></th>
                        <th><?php echo _TABLEFIELDLOCATION; ?></th>
                        <th><?php echo _TABLEFIELDLANG; ?></th>
                        <th><?php echo _TABLEFIELDSTATUS; ?></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php foreach($ads as $ad): ?>
                        <tr>
                          <td><?php echo $ad['ad_id']; ?></td>
                          <td><?php echo echoOutput($ad['ad_title']); ?></td>
                          <td class="text-capitalize"><?php echo echoOutput($ad['ad_position']); ?></td>
                          <td><?php echo $ad['language_name']; ?></td>
                          <td class="status td-justify">
                            <?php
                            if ($ad['ad_status'] == 1) {
                              echo '<span class="badge badge-pill bg-success">'._ENABLED.'</span>';
                            }else{
                              echo '<span class="badge badge-pill bg-warning">'._DISABLED.'</span>';
                            }
                            ?>
                          </td>
                          <td align="right" width="50px" class="padding-right-5">

                            <a class="btn btn-small btn-primary" href="../controller/edit_ad.php?id=<?php echo $ad['ad_id']; ?>">
                              <?php echo _EDITITEM; ?>
                            </a>

                          </td>
                          <td align="left" width="50px" class="padding-left-0">
                            <a class="btn btn-small btn-danger btn-delete deleteItem" data-url="../controller/delete_ad.php?id=<?php echo $ad['ad_id']; ?>">
                              <?php echo _DELETEITEM; ?>
                            </a>
                          </td>
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
  </div>
</section>


<?php require 'new.ad.view.php'; ?>