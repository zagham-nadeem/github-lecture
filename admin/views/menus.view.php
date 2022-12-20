<?php require 'sidebar.php'; ?>  

<!--Page Container-->
<section class="page-container">
    <div class="page-content-wrapper">

        <!--Main Content-->

        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">

                <div class="section-title">
                    <h5 class="text-truncate"><?php echo _MENUS; ?></h5>
                </div>

                <div class="row">
                  
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
                                              <th><?php echo _TABLEFIELDTITLE; ?></th>
                                              <th><?php echo _TABLEFIELDHEADER; ?></th>
                                              <th><?php echo _TABLEFIELDFOOTER; ?></th>
                                              <th><?php echo _TABLEFIELDSIDEBAR; ?></th>
                                              <th><?php echo _TABLEFIELDLANG; ?></th>
                                              <th></th>
                                              <th></th>
                                          </tr>
                                      </thead>
                                  <tbody>
                                    <?php foreach($menus as $menu): ?>
                                        <tr>
                                          <td><?php echo $menu['menu_id']; ?></td>
                                          <td><?php echo echoOutput($menu['menu_name']); ?></td>

                                          <td><?php if ($menu['menu_header'] == 1) {
                                              echo '<div class="legend-value-w"> <div class="legend-pin" style="background-color: var(--success-color)"></div> </div>';
                                          } else{
                                              echo '<div class="legend-value-w"> <div class="legend-pin" style="background-color: var(--danger-color)"></div> </div>';
                                          }  ?>
                                      </td>

                                      <td><?php if ($menu['menu_footer'] == 1) {
                                          echo '<div class="legend-value-w"> <div class="legend-pin" style="background-color: var(--success-color)"></div> </div>';
                                      } else{
                                          echo '<div class="legend-value-w"> <div class="legend-pin" style="background-color: var(--danger-color)"></div> </div>';
                                      }  ?>
                                  </td>

                                  <td><?php if ($menu['menu_sidebar'] == 1) {
                                      echo '<div class="legend-value-w"> <div class="legend-pin" style="background-color: var(--success-color)"></div> </div>';
                                  } else{
                                      echo '<div class="legend-value-w"> <div class="legend-pin" style="background-color: var(--danger-color)"></div> </div>';
                                  }  ?>
                              </td>

                              <td><?php echo $menu['language_name']; ?></td>

                              <td align="right" width="50px" class="padding-right-5">

                                <a class="btn btn-small btn-primary" href="../controller/edit_menu.php?id=<?php echo $menu['menu_id']; ?>">
                                    <?php echo _EDITITEM; ?>
                                </a>

                            </td>
                            <td align="left" width="50px" class="padding-left-0">
                                <a class="btn btn-small btn-danger btn-delete deleteItem" data-url="../controller/delete_menu.php?id=<?php echo $menu['menu_id']; ?>">
                                  <?php echo _DELETEITEM; ?>
                              </a>
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


<?php require 'new.menu.view.php'; ?>