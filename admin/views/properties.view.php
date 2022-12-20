<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_properties.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'pt_id', "width": "5%", "className": "text-center" },
     { "mData": null , "width": "12%", "className": "product text-center",
     "mRender" : function (data) {
      return "<img src='../../images/"+data.pt_image+"' class='product-img product-img-p'/>";}
    },
    { mData: 'tr_title'},
    { "mData": null , "width": "10%", "className":"text-center",
     "mRender" : function (data) {
        return '<span>'+formatPrice(data.pt_price, "<?php echo $siteSettings['st_currency']; ?>", "<?php echo $siteSettings['st_currencyposition']; ?>", 0, ".")+'</span>';
      }
    },
    { "mData": null , "width": "8%", "className":"text-center",
     "mRender" : function (data) {
        return '<span>'+data.pt_size+'<?php echo $siteSettings['st_unit']; ?></span>';
      }
    },
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.pt_visibility == 1) {
        return '<span class="badge badge-pill bg-success"><?php echo _ACTIVE; ?></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><?php echo _INACTIVE; ?></span>';
      }
      }
    },
    { "mData": null ,
    "width": "14%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a data-toggle='modal' data-target='#view-modal' id='showEditModal' class='btn btn-small btn-primary' style='color:#fff' data-id='"+data.pt_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_property.php?id="+data.pt_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _PROPERTIES; ?></h5>
        </div>

        <div class="row">

        <div class="col-12 padding-right-20">
            <div class="inline-block">

              <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"  aria-expanded="false">
                  <i class="fa fa-download add-new-i"></i> <?php echo _EXPORT; ?>
                </button>
                <div class="dropdown-menu min-width" aria-label="dropdownMenuButton">
                  <a class="dropdown-item" data-toggle="modal" data-target="#xls_modal" class="pointer">Excel</a>
                  <a class="dropdown-item" data-toggle="modal" data-target="#json_modal" class="pointer">Json</a>
                  <a class="dropdown-item" data-toggle="modal" data-target="#xml_modal" class="pointer">Xml</a>
                  
                </div>
              </div>
              
            </div>
            <div class="float-r">

            <a class="btn btn-primary" href="../controller/new_property.php">
              <i class="fa fa-plus add-new-i"></i> <?php echo _ADDITEM; ?>
            </a>
            </div>
          </div>

          <div class="col-12">
            <div class="block table-block mb-4 c-4">

              <div class="row">
                <div class="table-responsive">
                  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                    <thead>
                      <tr>
                        <th><?php echo _TABLEFIELDID; ?></th>
                        <th><?php echo _TABLEFIELDIMAGE; ?></th>
                        <th><?php echo _TABLEFIELDTITLE; ?></th>
                        <th><?php echo _TABLEFIELDPRICE; ?></th>
                        <th><?php echo _TABLEFIELDAREA; ?></th>
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

<div id="xls_modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Excel</h4>
  </div>
  <div class="modal-body">
    
    <table class="table">

      <?php foreach($properties_languages as $plang): ?>

        <tr>
          <td class="td-middle"><?php echo $plang['language_name']; ?></td>
          <td align="right">
            <a class="btn btn-small btn-success" href="../export/xls/properties.php?lang=<?php echo $plang['language_code']; ?>">
              <?php echo _DOWNLOAD; ?>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>

      <?php if (!$properties_languages): ?>
        <p class="text-center"><?php echo _NOITEMSFOUND; ?></p>
      <?php endif; ?>

    </table>

  </div>
</div>
</div>
</div>


<div id="json_modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">JSON</h4>
  </div>
  <div class="modal-body">
    
    <table class="table">

      <?php foreach($properties_languages as $plang): ?>

        <tr>
          <td class="td-middle"><?php echo $plang['language_name']; ?></td>
          <td align="right">
            <a class="btn btn-small btn-success" href="../export/json/properties.php?lang=<?php echo $plang['language_code']; ?>">
              <?php echo _DOWNLOAD; ?>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>

      <?php if (!$properties_languages): ?>
        <p class="text-center"><?php echo _NOITEMSFOUND; ?></p>
      <?php endif; ?>

    </table>

  </div>
</div>
</div>
</div>

<div id="xml_modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">XML</h4>
  </div>
  <div class="modal-body">
    
    <table class="table">

      <?php foreach($properties_languages as $plang): ?>

        <tr>
          <td class="td-middle"><?php echo $plang['language_name']; ?></td>
          <td align="right">
            <a class="btn btn-small btn-success" href="../export/xml/properties.php?lang=<?php echo $plang['language_code']; ?>">
              <?php echo _DOWNLOAD; ?>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>

      <?php if (!$properties_languages): ?>
        <p class="text-center"><?php echo _NOITEMSFOUND; ?></p>
      <?php endif; ?>

    </table>

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
          url: '../controller/get_property_languages.php',
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
