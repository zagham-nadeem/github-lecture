<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_users.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'user_id', "width": "3%", "className": "text-left" },
     { mData: 'user_name', "width": "7%", "className": "text-left" },
     { mData: 'user_email', "width": "15%", "className": "text-left" },
     { mData: 'role_name', "width": "5%", "className": "text-left" },
     { mData: 'user_phone', "width": "5%", "className": "text-left" },
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.user_status == 1) {
        return '<span class="badge badge-pill bg-success"><?php echo _ACTIVE; ?></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><?php echo _INACTIVE; ?></span>';
      }
      }
    },
    { "mData": null ,
    "width": "6%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a class='btn btn-small btn-primary' style='color:#fff' href='../controller/edit_user.php?id="+data.user_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_user.php?id="+data.user_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _USERS; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">
            <a class="btn btn-primary" href="../controller/new_user.php">
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
                        <th><?php echo _TABLEFIELDUSERNAME; ?></th>
                        <th><?php echo _TABLEFIELDUSEREMAIL; ?></th>
                        <th><?php echo _TABLEFIELDUSERROLE; ?></th>
                        <th><?php echo _TABLEFIELDUSERPHONE; ?></th>
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