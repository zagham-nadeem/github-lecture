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

               <input type="hidden" value="<?php echo $page['page_id']; ?>" name="page_id">
               <input type="hidden" value="<?php echo $page['tr_page']; ?>" name="tr_page">
               <input type="hidden" value="<?php echo $page['tr_id']; ?>" name="tr_id">
               <input type="hidden" value="<?php echo $page['tr_lang']; ?>" name="tr_lang">

               <div class="form-row">
                <div class="form-group col-md-9">
                  <div class="block col-md-12">

                    <label><?php echo _PAGETITLE; ?></label>
                    <input type="text" value="<?php echo $page['tr_title']; ?>" name="tr_title" class="form-control" required="">

                    <label><?php echo _TABLEFIELDSLUG; ?></label>
                    <input type="hidden" value="<?php echo $page['tr_slug']; ?>" name="tr_slug_save">
                    <input type="text" placeholder="<?php echo $page['tr_slug']; ?>" name="tr_slug" class="form-control">
                    
                    <label><?php echo _PAGETEMPLATE; ?></label>
                    <?php if(is_default_page($connect, $page['page_id'])): ?>
                      <input type="hidden" name="page_template" value="<?php echo $page['page_template']; ?>" />
                    <?php endif; ?>
                    
                    <select class="custom-select form-control" id="single-select" data-selected="<?php echo $page['page_template']; ?>" name="page_template" <?php echo !(is_default_page($connect, $page['page_id'])) ? NULL : 'disabled' ?>>
                      <option value="blank"><?php echo _PAGEBLANK; ?></option>
                      <option value="contact"><?php echo _PAGECONTACT; ?></option>
                      <option value="blog"><?php echo _PAGEBLOG; ?></option>
                      <option value="properties"><?php echo _PAGEPROPERTIES; ?></option>
                      <option value="search"><?php echo _PAGESEARCH; ?></option>
                      <option value="terms"><?php echo _PAGETERMSCONDITIONS; ?></option>
                      <option value="privacy"><?php echo _PAGEPRIVACYPOLICY; ?></option>
                    </select>

                    <?php echo !(is_default_page($connect, $page['page_id'])) ? NULL : "<small>"._CANTCHANGEPAGE." <a href='../controller/settings.php#pages'>"._CHANGESETTINGBTN."</a></small><br/>" ?>

                    <label><?php echo _PAGEVISIBILTY; ?></label>
                    <select class="custom-select form-control" name="page_private" required="">

                      <?php
                      if($page['page_private'] == 1){
                        echo '<option value="1" selected="selected">'._PAGEHIDDEN.'</option>';
                        echo '<option value="0">'._PAGEPUBLIC.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._PAGEPUBLIC.'</option>';
                        echo '<option value="1">'._PAGEHIDDEN.'</option>';
                      }
                      ?>

                    </select>

                    <label><?php echo _PAGEFOOTER; ?></label>
                    <select class="custom-select form-control" name="page_footer" required="">

                      <?php
                      if($page['page_footer'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>

                    </select>

                    <label><?php echo _PAGEHEADERAD; ?></label>
                    <select class="custom-select form-control" name="page_ad_header" required="">
                      <?php
                      if($page['page_ad_header'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <label><?php echo _PAGEFOOTERAD; ?></label>
                    <select class="custom-select form-control" name="page_ad_footer" required="">
                      <?php
                      if($page['page_ad_footer'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <label><?php echo _PAGESIDEBARAD; ?></label>
                    <select class="custom-select form-control" name="page_ad_sidebar" required="">
                      <?php
                      if($page['page_ad_sidebar'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <label><?php echo _PAGECONTENT; ?></label>
                    <textarea type="text" class="advancedtinymce form-control" name="tr_content"><?php echo $page['tr_content']; ?></textarea>
                    <br>

                    <fieldset>
                      <legend><?php echo _SEO; ?></legend>

                      <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                      <input type="text" value="<?php echo $page['tr_seotitle']; ?>" name="tr_seotitle" class="form-control">


                      <label><?php echo _SEODESCRIPTION; ?></label>
                      <textarea type="text" class="form-control" name="tr_seodescription"><?php echo $page['tr_seodescription']; ?></textarea>

                    </fieldset>

                  </div>
                </div>

                <div class="form-group col-md-3 sidebar">

                 <div class="block col-md-12">

                   <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

                   <select class="custom-select form-control" name="tr_lang" required="" disabled="">
                    <?php foreach($languages as $language){
                      if($page['tr_lang'] == $language['language_code']){
                        echo '<option value="'.$page['tr_lang'].'" selected="selected">'.$language['language_name'].'</option>';
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

                        <?php foreach ($activelanguages as $language) if ($language['language_code'] != $page['tr_lang']){ ?>  
                          <tr>
                           <td align="left"><?php echo $language['language_name']; ?></td>
                           <td align="right"><a class="addIcon duplicateItem" data-url="../controller/duplicate_page.php?lang=<?php echo $page['tr_lang']; ?>&id=<?php echo $page['page_id']; ?>&to=<?php echo $language['language_code']; ?>"><i class="fa fa-plus-square-o"></i></a></td>
                         </tr>
                       <?php } ?>

                     </table>
                   </div>
                 <?php endif; ?>


                 <?php if( !empty($languages)): ?>

                  <div class="trlanguages">
                    <p><?php echo _EDITTRANSLATIONITEM; ?></p>
                    <table class="table">

                      <?php foreach ($languages as $language) if ($language['language_code'] != $page['tr_lang']) { ?>  

                        <tr>
                         <td align="left"><?php echo $language['language_name']; ?></td>
                         <td align="right"><a href="../controller/edit_page.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $page['page_id']; ?>" class="addIcon"><i class="fa fa-edit"></i></a></td>
                       </tr>
                       <?php 
                     }elseif(count($languages) <= 1){
                      echo "<span class='notranslations'>"._NOTRANSLATIONSFOUNDITEM."</span>";
                    }
                    ?>

                  </table>
                </div>
              <?php endif; ?>

              <?php if(!empty($languages)): ?>

                <div class="trlanguages">
                  <p><?php echo _DELETETRANSLATIONITEM; ?></p>
                  <table class="table">

                    <?php foreach ($languages as $language) { ?>  
                     <tr>
                       <td align="left"><?php echo $language['language_name']; ?></td>
                       <td align="right"><a class="addIcon deleteItem" data-url="../controller/delete_tr_page.php?lang=<?php echo $language['language_code']; ?>&id=<?php echo $page['page_id']; ?>"><i class="fa fa-trash-o"></i></a></td>
                     </tr>
                   <?php } ?>

                 </table>
               </div>
             <?php endif; ?>

           </div>

         </div>

         <div class="block col-md-12">
           <label><?php echo _TABLEFIELDSTATUS; ?></label>

           <select class="custom-select form-control" name="page_visibility" required="">
          <?php
          if($page['page_visibility'] == 1){
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

        <?php if (is_default_page($connect, $page['page_id'])) { ?>

         <button class="btn btn-danger cursor-not" type="button" disabled="">
          <?php echo _DELETEITEM; ?>
        </button>

      <?php } else{ ?>

        <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_page.php?id=<?php echo $page['page_id']; ?>" data-redirect="../controller/pages.php"><?php echo _DELETEITEM; ?></button>

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
