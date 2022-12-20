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

               <input type="hidden" value="<?php echo $post['post_id']; ?>" name="post_id">
               <input type="hidden" value="<?php echo $post['tr_post']; ?>" name="tr_post">
               <input type="hidden" value="<?php echo $post['tr_id']; ?>" name="tr_id">
               <input type="hidden" value="<?php echo $post['tr_lang']; ?>" name="tr_lang">

               <div class="form-row">
                <div class="form-group col-md-9">
                  <div class="block col-md-12">

                    <label><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="<?php echo $post['tr_title']; ?>" name="tr_title" class="form-control" required="">

                    <label><?php echo _TABLEFIELDSLUG; ?></label>
                    <input type="hidden" value="<?php echo $post['tr_slug']; ?>" name="tr_slug_save">
                    <input type="text" placeholder="<?php echo $post['tr_slug']; ?>" name="tr_slug" class="form-control">
                    
                    <label><?php echo _TABLEFIELDCONTENT; ?></label>

                    <textarea type="text" class="advancedtinymce form-control" name="tr_content"><?php echo $post['tr_content']; ?></textarea>

                    <label class="control-label"><?php echo _TABLEFIELDCATEGORY; ?></label>

                    <select class="custom-select form-control" name="post_category">

                      <?php
                      foreach($categories as $category)
                      {
                        if($post['post_category'] == $category['category_id'])
                        {
                          echo '<option value="'.$post['post_category'].'" selected="selected">'.$category['tr_name'].'</option>';
                        }
                        else{
                          echo '<option value="'.$category['category_id'].'">'.$category['tr_name'].'</option>';
                        }
                      }
                      ?>

                    </select>

                    <label class="control-label"><?php echo _TABLEFIELDFEATURED; ?></label>

                    <select class="custom-select form-control" name="post_featured" required="">
                      <?php
                      if($post['post_featured'] == 1)
                      {
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';

                      }
                      else {
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <br>
                    <br>

                    <fieldset>
                      <legend><?php echo _SEO; ?></legend>

                      <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                      <input type="text" value="<?php echo $post['tr_seotitle']; ?>" name="tr_seotitle" class="form-control">


                      <label><?php echo _SEODESCRIPTION; ?></label>
                      <textarea type="text" class="form-control" name="tr_seodescription"><?php echo $post['tr_seodescription']; ?></textarea>

                    </fieldset>

                  </div>
                </div>

                <div class="form-group col-md-3 sidebar">

                 <div class="block col-md-12">

                   <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

                   <select class="custom-select form-control" name="tr_lang" required="" disabled="">
                    <?php
                    foreach($languages as $language)
                    {
                      if($post['tr_lang'] == $language['language_code'])
                      {
                        echo '<option value="'.$post['tr_lang'].'" selected="selected">'.$language['language_name'].'</option>';
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

                        <?php foreach ($activelanguages as $language) if ($language['language_code'] != $post['tr_lang']) { ?>  
                         <tr>
                           <td align="left"><?php echo $language['language_name']; ?></td>
                           <td align="right"><a class="addIcon duplicateItem" data-url="../controller/duplicate_post.php?lang=<?php echo $post['tr_lang']; ?>&id=<?php echo $post['post_id']; ?>&to=<?php echo $language['language_code']; ?>"><i class="fa fa-plus-square-o"></i></a></td>
                         </tr>
                       <?php } ?>

                     </table>
                   </div>
                 <?php endif; ?>

                 <?php if( !empty($languages)): ?>

                  <div class="trlanguages">
                    <p><?php echo _EDITTRANSLATIONITEM; ?></p>
                    <table class="table">

                      <?php foreach ($languages as $language) if ($language['language_code'] != $post['tr_lang']) { ?>
                       <tr>
                         <td align="left"><?php echo $language['language_name']; ?></td>
                         <td align="right"><a href="../controller/edit_post.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $post['post_id']; ?>" class="addIcon"><i class="fa fa-edit"></i></a></td>
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
                       <td align="right"><a class="addIcon deleteItem" data-url="../controller/delete_tr_post.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $post['post_id']; ?>"><i class="fa fa-trash-o"></i></a></td>
                     </tr>
                   <?php } ?>

                 </table>
               </div>
             <?php endif; ?>

           </div>

         </div>

         <div class="block col-md-12">
           <label><?php echo _TABLEFIELDSTATUS; ?></label>

           <select class="custom-select form-control" name="post_visibility" required="">

            <?php
            if($post['post_visibility'] == 1){
              echo '<option value="1" selected="selected">'._ENABLED.'</option>';
              echo '<option value="0">'._DISABLED.'</option>';

            } else{
              echo '<option value="0" selected="selected">'._DISABLED.'</option>';
              echo '<option value="1">'._ENABLED.'</option>';
            }
            ?>
          </select>

        </div>

        <div class="block col-md-12">
          <label><?php echo _TABLEFIELDIMAGE; ?></label>

          <div class="new-image" id="image-preview" style="background: url(../../images/<?php echo $post['post_image'] ?>);">
            <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
            <input type="hidden" value="<?php echo $post['post_image']; ?>" name="post_image_save">
            <input type="file" name="post_image" id="image-upload" />
          </div>

          <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>650 x 350</b> </span>
          <br/>
        </div>

        <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
        <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_post.php?id=<?php echo $post['post_id']; ?>" data-redirect="../controller/posts.php"><?php echo _DELETEITEM; ?></button>

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
