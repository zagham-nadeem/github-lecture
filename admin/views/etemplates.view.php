<?php require 'sidebar.php'; ?>  

<!--Page Container-->
<section class="page-container">
    <div class="page-content-wrapper">

        <!--Main Content-->

        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h5 class="text-truncate"><?php echo _EMAILTEMPLATES; ?></h5>
                            
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="block table-block mb-4 c-4">

                            <div class="row">
                                <div class="table-responsive">
                                    <table class="display table table-striped">
                                        <thead>
                                            <tr>
                                            <th><?php echo _EMAILTYPE; ?></th>
                                            <th><?php echo _ITEMSTATUS; ?></th>
                                            <th></th>
                                           </tr>
                                       </thead>
                                       <tfoot>
                                        <tr>
                                            <th><?php echo _EMAILTYPE; ?></th>
                                            <th><?php echo _ITEMSTATUS; ?></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php foreach($etemplates as $etemplate): ?>
                                            <tr>
                                               <td><?php echo echoOutput($etemplate['email_title']); ?></td>
                                               <td class="status td-justify">
                                                <?php
                                                if ($etemplate['email_disabled'] == 1) {
                                                    echo '<span class="badge badge-pill bg-warning">'._DISABLED.'</span>';
                                                }else{
                                                    echo '<span class="badge badge-pill bg-success">'._ENABLED.'</span>';
                                                }
                                                ?>
                                            </td>
                                            <td align="right" width="50px" class="padding-right-5">

                                                <a class="btn btn-small btn-primary" href="../controller/edit_etemplate.php?id=<?php echo $etemplate['email_id']; ?>">
                                                    <?php echo _EDITITEM; ?>
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