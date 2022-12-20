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
              <h5 class="text-truncate"><?php echo _LANGUAGES; ?></h5>

            </div>
          </div>

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
                       <th><?php echo _TABLEFIELDNAME; ?></th>
                       <th><?php echo _TABLEFIELDCODE; ?></th>
                       <th><?php echo _TABLEFIELDDIRECTION; ?></th>
                       <th><?php echo _TABLEFIELDSTATUS; ?></th>
                       <th></th>
                       <th></th>
                       <th></th>
                     </tr>
                   </thead>
                  <tbody>
                    <?php foreach($languages as $language): ?>
                      <tr>
                       <td><?php echo $language['language_id']; ?></td>
                       <td><?php echo echoOutput($language['language_name']); ?></td>
                       <td><?php echo echoOutput($language['language_code']); ?></td>
                       <td><?php echo echoOutput($language['language_type']); ?></td>
                       <td class="status">
                        <?php
                        if ($language['language_status'] == 1) {
                          echo '<span class="badge badge-pill bg-success">'._ENABLED.'</span>';
                        }else{
                          echo '<span class="badge badge-pill bg-warning">'._DISABLED.'</span>';
                        }
                        ?>
                      </td>
                      <td align="right" width="50px" class="padding-right-5">
                       <?php 
                       $table = "translate_".$language['language_code'];
                       $exists = check_table($connect, $table);
                       if (!$exists)
                       {
                        echo '<a class="btn btn-small btn-outline-success" href="../controller/create_translation.php?lang='. $language['language_code'] .'">'._ADDTRANSLATION.'</a>';
                      }else{

                        echo '<a class="btn btn-small btn-outline-success" href="../controller/edit_translation.php?lang='. $language['language_code'] .'">'._EDITTRANSLATION.'</a>';

                      }
                      ?></td>

                      <td align="right" width="50px" class="padding-left-0">
                        <a class="btn btn-small btn-primary" href="../controller/edit_language.php?id=<?php echo $language['language_id']; ?>">
                          <?php echo _EDITITEM; ?>
                        </a>
                      </td>
                      <td align="left" width="50px" class="padding-left-0">
                        <?php if ($language['language_code'] == $defaultlanguage) { ?>
                          <button class="btn btn-small btn-danger btn-delete cursor-not" type="button" disabled=""><?php echo _DELETEITEM; ?></button>
                        <?php } else{ ?>
                          <button class="btn btn-small btn-danger btn-delete deleteItem" type="button" data-url="../controller/delete_language.php?id=<?php echo $language['language_id']; ?>"><?php echo _DELETEITEM; ?></button>
                        <?php } ?>

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

<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo _ADDITEM; ?></h4>
  </div>
  <div class="modal-body">
    <form enctype="multipart/form-data" method="post" id="insertLanguage">


     <label class="control-label"><?php echo _TABLEFIELDNAME; ?></label>
     <input type="text" value="" placeholder="" name="language_name" class="form-control" required="">

     <br>
     <br>

     <label class="control-label"><?php echo _TABLEFIELDCODE; ?></label>
     <input type="text" value="" placeholder="" name="language_code" class="form-control" required="">
     <br>
     <i class="dripicons-skip text-secondary"></i> <label class="text-secondary"><a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" class="text-secondary" target="_blank">https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes</a></label>

     <br>

     <label class="control-label"><?php echo _TABLEFIELDDIRECTION; ?></label>
     <select class="custom-select form-control" name="language_type">
       <option value="ltr"><?php echo _LANGDIRLTR; ?></option>
       <option value="rtl"><?php echo _LANGDIRRTL; ?></option>
     </select>

     <br>
     <br>

     <input type="submit" name="insert" id="insert" value="<?php echo _SAVECHANGES; ?>" class="btn btn-primary" />

   </form>
 </div>
</div>
</div>
</div>