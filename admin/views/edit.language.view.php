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
            <div class="block form-block mb-4">

              <?php if($language['language_translated'] == '0'): ?>
               <div class="alert alert-danger" role="alert"><i class="fa fa-warning"></i> &nbsp; <?php echo _TRANSLATIONNOTCREATED; ?> <a href="../controller/create_translation.php?lang=<?php echo $language['language_code']; ?>" class="alert-link"><b><?php echo _TRANSLATIONCREATE; ?></b></a> </div>
              <?php endif ?>
              

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                   <input type="hidden" value="<?php echo $language['language_id']; ?>" name="language_id">

                   <label><?php echo _TABLEFIELDNAME; ?></label>
                   <input type="text" value="<?php echo $language['language_name']; ?>" name="language_name" class="form-control" required="">

                   <label><?php echo _TABLEFIELDCODE; ?></label>
                   <input type="text" value="<?php echo $language['language_code']; ?>" name="language_code" class="form-control" required="">
                   <i class="dripicons-skip text-secondary"></i> <label class="text-secondary"><a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" class="text-secondary" target="_blank">https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes</a></label>

                   <br/>

                   <label class="control-label"><?php echo _TABLEFIELDDIRECTION; ?></label>

                   <select class="custom-select form-control" name="language_type" required="">

                    <?php
                    if($language['language_type'] == 'rtl'){
                      echo '<option value="rtl" selected="selected">'._LANGDIRRTL.'</option>';
                      echo '<option value="ltr">'._LANGDIRLTR.'</option>';

                    }else{
                      echo '<option value="ltr" selected="selected">'._LANGDIRLTR.'</option>';
                      echo '<option value="rtl">'._LANGDIRRTL.'</option>';
                    }
                    ?>

                  </select>

                  <label class="control-label"><?php echo _TABLEFIELDSTATUS; ?></label>

                  <select class="custom-select form-control" name="language_status" required="">
                    <?php
                    if($language['language_status'] == 1){
                      echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                      echo '<option value="0">'._DISABLED.'</option>';

                    } else{
                      echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                    }
                    ?>
                  </select>

                  <br/>
                  <br/>

                  <hr>

                  <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>

                  <?php if ($language['language_code'] == $settings['st_language']) { ?>
                  <button class="btn btn-danger cursor-not" type="button" disabled=""><?php echo _DELETEITEM; ?></button>
                  <?php } else{ ?>
                  <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_language.php?id=<?php echo $language['language_id']; ?>" data-redirect="../controller/languages.php"><?php echo _DELETEITEM; ?></button>
                  <?php } ?>

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