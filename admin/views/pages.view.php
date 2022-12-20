<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_pages.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'page_id', "width": "5%", "className": "text-center" },
    { mData: 'tr_title'},
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.page_visibility == 1) {
        return '<span class="badge badge-pill bg-success"><?php echo _ACTIVE; ?></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><?php echo _INACTIVE; ?></span>';
      }
      }
    },
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.page_private == 1) {
        return '<span class="badge badge-pill bg-warning"><?php echo _PAGEHIDDEN; ?></span>';
      }else{
        return '<span class="badge badge-pill bg-success"><?php echo _PAGEPUBLIC; ?></span>';
      }
      }
    },
    { "mData": null ,
    "width": "14%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a data-toggle='modal' data-target='#view-modal' id='showEditModal' class='btn btn-small btn-primary' style='color:#fff' data-id='"+data.page_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_page.php?id="+data.page_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _PAGES; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">
            <a class="btn btn-primary" href="../controller/new_page.php">
              <i class="fa fa-plus add-new-i"></i> <?php echo _ADDITEM; ?>
            </a>
          </div>

          <div class="col-12">
            <div class="block table-block mb-4 c-4">

              <div class="row">
                <div class="table-responsive">
                  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                    <thead>
                      <tr>
                      <th><?php echo _TABLEFIELDID; ?></th>
                      <th><?php echo _TABLEFIELDTITLE; ?></th>
                      <th><?php echo _TABLEFIELDSTATUS; ?></th>
                      <th><?php echo _TABLEFIELDVISIBILITY; ?></th>
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

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog"> 

<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn btn-primary close reloadonClose" data-dismiss="modal" style="font-size: 24px;">&times;</button>
<h4 class="modal-title" style="font-size: 16px;"><?php echo _EDITITEM; ?></h4>
</div>
<div class="modal-body">
<div id="modal-loader" style="display: none; text-align: center;">
</div>
                        
<div id="dynamic-content"></div>

</div>
</div>

</div>
</div>

<script>  
$(document).ready(function(){
  $(document).on('click', '#showEditModal', function(e){
      e.preventDefault();
      var uid = $(this).data('id');
      $('#dynamic-content').html('');
      $('#modal-loader').show();
      $.ajax({
          url: '../controller/get_pages_languages.php',
          type: 'POST',
          data: 'id='+uid,
          dataType: 'html'
      })
      .done(function(data){
          $('#dynamic-content').html('');    
          $('#dynamic-content').html(data);
          $('#modal-loader').hide(); 
      })
      .fail(function(){
          $('#modal-loader').hide();
      });
  });
});

</script>
