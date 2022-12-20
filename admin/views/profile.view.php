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
              <h4>Profile</h4>
            </div>
          </div>

          <div class="col-md-7">
            <div class="block form-block mb-4">

              <div class="form-row">

                <div class="form-group col-md-12">

                  <?php if($check_access['user_role'] != 1): ?>
                    <div class="alert alert-light" role="alert">
                     You don't have permission <b>to change your information</b>, contact the administrator.
                   </div>
                 <?php endif; ?>

                 <label><?php echo _TABLEFIELDNAME; ?></label>
                 <input type="text" value="<?php echo $user['user_name']; ?>" name="user_name" class="form-control" required="">

                 <br/>

                 <label>Email</label>
                 <input type="text" value="<?php echo $user['user_email']; ?>" name="user_email" class="form-control" disabled>

                 <label>Phone</label>
                 <input type="text" value="<?php echo $user['user_phone']; ?>" name="user_phone" class="form-control" required="">


                 <div style="margin-top: 20px;">
                  <table>
                    <tr>
                      <td style="padding: 0 !important; padding-right: 15px !important;"><p><b>Published: </b> <?php echo FormatDate($connect, $user['user_created']); ?></p></td>
                      <td style="padding: 0 !important; padding-right: 15px !important;"><p><b>Updated: </b> <?php echo FormatDate($connect, $user['user_updated']); ?></p></td>
                      <td style="padding: 0 !important; padding-right: 15px !important;"><p><b>Total Properties: </b> <?php echo $totalproperties; ?></p></td>
                    </tr>
                  </table>
                </div>


              </div>


            </div>
          </div>
        </div>

        <div class="col-md-5 sidebar">
          <div class="block form-block mb-4">

            <div class="form-group col-md-12">

              <label class="control-label">Latest 5 Properties</label>

                            <div class="table-responsive text-no-wrap">
                                <table class="table">
                                    <tbody class="text-middle">
                                        <?php foreach($properties as $property): ?>
                                            <tr>
                                                <td class="product" width="50px">
                                                    <img class="product-img product-img-w" src="../../images/<?php echo $property['pt_image']; ?>">
                                                </td>
                                                <td class="name"><span class="span-title" style="max-width: 180px"><?php echo echoOutput($property['tr_title']); ?></span></td>
                                                <td align="right" class="text-muted"><?php echo FormatDate($connect, $property['pt_date']); ?></td> 
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
