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

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                   <input type="hidden" value="<?php echo $testimonial['testimonial_id']; ?>" name="testimonial_id">
                   
                  <label><?php echo _TABLEFIELDNAME; ?></label>
                   <input type="text" value="<?php echo $testimonial['testimonial_name']; ?>" name="testimonial_name" class="form-control" required="">

                   <br/>

                   <label><?php echo _TABLEFIELDCOMMENT; ?></label>
                   <textarea name="testimonial_description" class="mceNoEditor form-control" rows="3" style="padding-top: 8px" required=""><?php echo $testimonial['testimonial_description']; ?></textarea>
                  
                   <br/>

                   <label><?php echo _TABLEFIELDJOB; ?></label>
                   <input type="text" value="<?php echo $testimonial['testimonial_job']; ?>" name="testimonial_job" class="form-control" required="">

                   <br/>

                   <label class="control-label"><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="testimonial_status" required="">
                    <?php
                    if($testimonial['testimonial_status'] == 1){
                      echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                      echo '<option value="0">'._DISABLED.'</option>';

                    } else{
                      echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                    }
                    ?>
                  </select>
                  <br/>

                   <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

                  <select class="custom-select form-control" name="testimonial_lang" required="">
                    <?php
                    foreach($activelanguages as $language)
                    {
                      if($testimonial['testimonial_lang'] == $language['language_code'])
                      {
                        echo '<option value="'.$testimonial['testimonial_lang'].'" selected="selected">'.$language['language_name'].'</option>';
                      }
                      else{
                        echo '<option value="'.$language['language_code'].'">'.$language['language_name'].'</option>';        
                      }
                    }
                    ?>
                  </select>

                  <label><?php echo _TABLEFIELDIMAGE; ?></label>

                  <div class="new-image" id="image-preview" style="background: url(../../images/<?php echo $testimonial['testimonial_image'] ?>);">
                    <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                    <input type="hidden" value="<?php echo $testimonial['testimonial_image']; ?>" name="testimonial_image_save">
                    <input type="file" name="testimonial_image" id="image-upload" />
                  </div>

                  <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>350 x 350</b> </span>
                  <br/>
                  <br/>

                  <hr>

                  <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                  <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_testimonial.php?id=<?php echo $testimonial['testimonial_id']; ?>" data-redirect="../controller/testimonials.php"><?php echo _DELETEITEM; ?></button>

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
