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
              <h5><?php echo _EDITITEM; ?></h5>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-block mb-4">

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="form-row">
                  <div class="form-group col-md-9">
                    <div class="block col-md-12">
                     <input type="hidden" value="<?php echo $staff['staff_id']; ?>" name="staff_id">
                     <input type="hidden" value="<?php echo $staff['tr_staff']; ?>" name="tr_staff">
                     <input type="hidden" value="<?php echo $staff['tr_id']; ?>" name="tr_id">
                     <input type="hidden" value="<?php echo $staff['tr_lang']; ?>" name="tr_lang">

                      <label><?php echo _TABLEFIELDNAME; ?></label>
                     <input type="text" value="<?php echo $staff['tr_name']; ?>" name="tr_name" class="form-control" required="">

                     <label>Facebook</label>
                     <input type="text" value="<?php echo $staff['staff_facebook']; ?>" name="staff_facebook" class="form-control">

                     <label>Twitter</label>
                     <input type="text" value="<?php echo $staff['staff_twitter']; ?>" name="staff_twitter" class="form-control">

                     <label>Linkedin</label>
                     <input type="text" value="<?php echo $staff['staff_linkedin']; ?>" name="staff_linkedin" class="form-control">

                     <label>Google +</label>
                     <input type="text" value="<?php echo $staff['staff_google']; ?>" name="staff_google" class="form-control">

                     <label><?php echo _TABLEFIELDJOB; ?></label>
                     <input type="text" value="<?php echo $staff['tr_job']; ?>" name="tr_job" class="form-control" required="">

                     <label><?php echo _TABLEFIELDIMAGE; ?></label>

                     <div class="new-image" id="image-preview" style="background: url(../../images/<?php echo $staff['staff_image'] ?>);">
                      <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                      <input type="hidden" value="<?php echo $staff['staff_image']; ?>" name="staff_image_save">
                      <input type="file" name="staff_image" id="image-upload" />
                    </div>

                    <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>350 x 350</b> </span>
                    <br/>

                  </div>
                </div>
                <div class="form-group col-md-3 sidebar">

                 <div class="block col-md-12">

                   <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

                   <select class="custom-select form-control" name="tr_lang" required="" disabled="">
                    <?php foreach($languages as $language){
                      if($staff['tr_lang'] == $language['language_code'])
                      {
                        echo '<option value="'.$staff['tr_lang'].'" selected="selected">'.$language['language_name'].'</option>';
                      }
                    }
                    ?>
                  </select>

                  <div class="card">

                   <label class="control-label"><?php echo _TRANSLATIONSITEM; ?></label>

                   <?php if( !empty($activelanguages)): ?>

                    <div class="trlanguages">
                      <p><?php echo _DUPLICATETRANSLATIONITEM; ?></p>
                      <table class="table">

                        <?php foreach ($activelanguages as $language) if ($language['language_code'] != $staff['tr_lang']) { ?>  
                         <tr>
                           <td align="left"><?php echo $language['language_name']; ?></td>
                           <td align="right"><a class="addIcon duplicateItem" data-url="../controller/duplicate_staff.php?lang=<?php echo $staff['tr_lang']; ?>&id=<?php echo $staff['staff_id']; ?>&to=<?php echo $language['language_code']; ?>"><i class="fa fa-plus-square-o"></i></a></td>
                         </tr>

                       <?php } ?>

                     </table>
                   </div>
                 <?php endif; ?>


                 <?php if( !empty($languages)): ?>

                  <div class="trlanguages">
                    <p><?php echo _EDITTRANSLATIONITEM; ?></p>
                    <table class="table">
                      <?php foreach ($languages as $language) if ($language['language_code'] != $staff['tr_lang']) { ?>  

                       <tr>
                         <td align="left"><?php echo $language['language_name']; ?></td>
                         <td align="right"><a href="../controller/edit_staff.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $staff['staff_id']; ?>" class="addIcon"><i class="fa fa-edit"></i></a></td>
                       </tr>
                       <?php 
                     }elseif(count($languages) <= 1){
                      echo "<span class='notranslations'>"._NOTRANSLATIONSFOUNDITEM."</span>";
                    }
                    ?>

                  </table>
                </div>
              <?php endif; ?>

              <?php if( !empty($languages)): ?>

                <div class="trlanguages">
                  <p><?php echo _DELETETRANSLATIONITEM; ?></p>
                  <table class="table">
                    <?php foreach ($languages as $language) { ?>  
                     <tr>
                       <td align="left"><?php echo $language['language_name']; ?></td>
                       <td align="right"><a class="addIcon deleteItem" data-url="../controller/delete_tr_staff.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $staff['staff_id']; ?>"><i class="fa fa-trash-o"></i></a></td>
                     </tr>
                     <?php } ?>

                </table>
              </div>
            <?php endif; ?>

          </div>
        </div>


        <div class="block col-md-12">
         <label><?php echo _TABLEFIELDSTATUS; ?></label>

        <select class="custom-select form-control" name="staff_status" required="">

          <?php
          if($staff['staff_status'] == 1){
            echo '<option value="1" selected="selected">'._ENABLED.'</option>';
            echo '<option value="0">'._DISABLED.'</option>';

          } else{
            echo '<option value="0" selected="selected">'._DISABLED.'</option>';
            echo '<option value="1">'._ENABLED.'</option>';
          }
          ?>
        </select>

      </div>

      <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
      <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_staff.php?id=<?php echo $staff['staff_id']; ?>" data-redirect="../controller/staffs.php"><?php echo _DELETEITEM; ?></button>

    </div>
  </div>

</form>
</div>
</div>
</div>
</div>
</div>
</div>
</section>