<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_languages.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'asc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'language_id', "width": "3%", "className": "text-left" },
     { mData: 'language_name', "width": "7%", "className": "text-left" },
     { mData: 'language_code', "width": "15%", "className": "text-left" },
     { mData: 'language_type', "width": "5%", "className": "text-left" },
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.language_status == 1) {
        return '<span class="badge badge-pill bg-success"><?php echo _ACTIVE; ?></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><?php echo _INACTIVE; ?></span>';
      }
      }
    },
    { "mData": null ,
    "width": "3%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a class='btn btn-small btn-primary' style='color:#fff' href='../controller/edit_language.php?id="+data.language_id+"'>"+EDITITEM+"</a>";}
    }
    ]
  });
  });
</script>

<!--Page Container-->
<section class="page-container">
  <div class="page-content-wrapper">

    <!--Main Content-->

    <div class="content sm-gutter">
      <div class="container-fluid padding-25 sm-padding-10">

        <div class="section-title">
          <h5 class="text-truncate"><?php echo _LANGUAGES; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">
          <button type="button" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary"><i class="fa fa-plus add-new-i"></i> <?php echo _ADDITEM; ?></button>
          </div>

          <div class="col-12">
            <div class="block table-block mb-4 c-4">

              <div class="row">
                <div class="table-responsive">
                  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                    <thead>
                      <tr>
                      <th><?php echo _TABLEFIELDID; ?></th>
                       <th><?php echo _TABLEFIELDNAME; ?></th>
                       <th><?php echo _TABLEFIELDCODE; ?></th>
                       <th><?php echo _TABLEFIELDDIRECTION; ?></th>
                       <th><?php echo _TABLEFIELDSTATUS; ?></th>
                       <th></th>
                      </tr>
                    </thead>
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