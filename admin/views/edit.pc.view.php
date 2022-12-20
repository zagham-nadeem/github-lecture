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

               <input type="hidden" value="<?php echo $pc['pc_id']; ?>" name="pc_id">
               <input type="hidden" value="<?php echo $pc['tr_pc']; ?>" name="tr_pc">
               <input type="hidden" value="<?php echo $pc['tr_id']; ?>" name="tr_id">
               <input type="hidden" value="<?php echo $pc['tr_lang']; ?>" name="tr_lang">

               <div class="form-row">
                <div class="form-group col-md-9">
                  <div class="block col-md-12">
                   
                    <label><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="<?php echo $pc['tr_title']; ?>" name="tr_title" class="form-control" required="">

                    <label><?php echo _TABLEFIELDCONTENT; ?></label>

                    <textarea type="text" class="mceNoEditor form-control" name="tr_content"><?php echo $pc['tr_content']; ?></textarea>

                  <label><?php echo _TABLEFIELDIMAGE; ?></label>

                  <div class="new-image" id="image-preview" style="background: url(../../images/<?php echo $pc['pc_image'] ?>);">
                    <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                    <input type="hidden" value="<?php echo $pc['pc_image']; ?>" name="pc_image_save">
                    <input type="file" name="pc_image" id="image-upload" />
                  </div>

                  <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>350 x 350</b> </span>
                  <br/>
                  <br/>

                  </div>
                </div>

                <div class="form-group col-md-3 sidebar">
                 
                 <div class="block col-md-12">

                   <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

                   <select class="custom-select form-control" name="tr_lang" required="" disabled="">
                    <?php
                    foreach($languages as $language)
                    {
                      if($pc['tr_lang'] == $language['language_code'])
                      {
                        echo '<option value="'.$pc['tr_lang'].'" selected="selected">'.$language['language_name'].'</option>';
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

                        <?php foreach ($activelanguages as $language) if ($language['language_code'] != $pc['tr_lang']) { ?>  
                         <tr>
                           <td align="left"><?php echo $language['language_name']; ?></td>
                           <td align="right"><a class="addIcon duplicateItem" data-url="../controller/duplicate_pc.php?lang=<?php echo $pc['tr_lang']; ?>&id=<?php echo $pc['pc_id']; ?>&to=<?php echo $language['language_code']; ?>"><i class="fa fa-plus-square-o"></i></a></td>
                         </tr>
                       <?php } ?>

                     </table>
                   </div>
                 <?php endif; ?>


                 <?php if( !empty($languages)): ?>

                  <div class="trlanguages">
                    <p><?php echo _EDITTRANSLATIONITEM; ?></p>
                    <table class="table">

                      <?php foreach ($languages as $language) if ($language['language_code'] != $pc['tr_lang']) { ?>  
                       <tr>
                         <td align="left"><?php echo $language['language_name']; ?></td>
                         <td align="right"><a href="../controller/edit_pc.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $pc['pc_id']; ?>" class="addIcon"><i class="fa fa-edit"></i></a></td>
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
                       <td align="right"><a class="addIcon deleteItem" data-url="../controller/delete_tr_pc.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $pc['pc_id']; ?>"><i class="fa fa-trash-o"></i></a></td>
                     </tr>
                     <?php } ?>

                 </table>
               </div>
             <?php endif; ?>

           </div>

         </div>

         <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
         <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_pc.php?id=<?php echo $pc['pc_id']; ?>" data-redirect="../controller/preferred_choice.php"><?php echo _DELETEITEM; ?></button>

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
