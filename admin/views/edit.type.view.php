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
                    <div class="block col-md-12 padding-bottom-35">
                     <input type="hidden" value="<?php echo $type['pt_type_id']; ?>" name="pt_type_id">
                     <input type="hidden" value="<?php echo $type['tr_type']; ?>" name="tr_type">
                     <input type="hidden" value="<?php echo $type['tr_id']; ?>" name="tr_id">
                     <input type="hidden" value="<?php echo $type['tr_lang']; ?>" name="tr_lang">
                     
                     <label><?php echo _TABLEFIELDNAME; ?></label>
                     <input type="text" value="<?php echo $type['tr_name']; ?>" name="tr_name" class="form-control" required="">

                     <label><?php echo _TABLEFIELDSLUG; ?></label>
                     <input type="hidden" value="<?php echo $type['tr_slug']; ?>" name="tr_slug_save">
                     <input type="text" value="<?php echo $type['tr_slug']; ?>" name="tr_slug" class="form-control" required="">

                   </div>

                 </div>
                 <div class="form-group col-md-3 sidebar">
                   
                   <div class="block col-md-12">

                     <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

                     <select class="custom-select form-control" name="tr_lang" required="" disabled="">
                      <?php
                      foreach($languages as $language)
                      {
                        if($type['tr_lang'] == $language['language_code'])
                        {
                          echo '<option value="'.$type['tr_lang'].'" selected="selected">'.$language['language_name'].'</option>';
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

                          <?php foreach ($activelanguages as $language) if ($language['language_code'] != $type['tr_lang']) { ?>  
                           <tr>
                             <td align="left"><?php echo $language['language_name']; ?></td>
                             <td align="right"><a class="addIcon duplicateItem" data-url="../controller/duplicate_type.php?lang=<?php echo $type['tr_lang']; ?>&id=<?php echo $type['pt_type_id']; ?>&to=<?php echo $language['language_code']; ?>"><i class="fa fa-plus-square-o"></i></a></td>
                           </tr>
                         <?php } ?>

                       </table>
                     </div>
                   <?php endif; ?>


                   <?php if( !empty($languages)): ?>

                    <div class="trlanguages">
                      <p><?php echo _EDITTRANSLATIONITEM; ?></p>
                      <table class="table">

                        <?php foreach ($languages as $language) if ($language['language_code'] != $type['tr_lang']) { ?>  
                         <tr>
                           <td align="left"><?php echo $language['language_name']; ?></td>
                           <td align="right"><a href="../controller/edit_type.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $type['pt_type_id']; ?>" class="addIcon"><i class="fa fa-edit"></i></a></td>
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
                         <td align="right"><a class="addIcon deleteItem" data-url="../controller/delete_tr_type.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $type['pt_type_id']; ?>"><i class="fa fa-trash-o"></i></a></td>
                       </tr>
                     <?php } ?>

                   </table>
                 </div>
               <?php endif; ?>

             </div>
           </div>

           <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
           <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_type.php?id=<?php echo $type['pt_type_id']; ?>" data-redirect="../controller/types.php"><?php echo _DELETEITEM; ?></button>

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
