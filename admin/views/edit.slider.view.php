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
                        <div class="block form-block mb-4">

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

   <input type="hidden" value="<?php echo $slider['slider_id']; ?>" name="slider_id">

<div class="form-row">

              <div class="form-group col-md-12">

   <label class="control-label"><?php echo _TABLEFIELDPROPERTY; ?></label>

   <select class="custom-select form-control selectDrop" name="slider_property">

      <?php
       foreach($properties as $property){
        if($slider['slider_property'] == $property['pt_id']){
          echo '<option value="'.$slider['slider_property'].'" selected="selected">'.$property['pt_reference'].'</option>';
        }else{
        echo '<option value="'.$property['pt_id'].'">'.$property['pt_reference'].'</option>';
        }
       }
      ?>

   </select>

<br/>

        <label><?php echo _TABLEFIELDIMAGE; ?></label>

<div class="new-image" id="image-preview" style="background: url(../../images/<?php echo $slider['slider_image'] ?>);">
  <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
  <input type="hidden" value="<?php echo $slider['slider_image']; ?>" name="slider_image_save">
  <input type="file" name="slider_image" id="image-upload" />
</div>

<span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>1200 x 600</b> </span>
<br/>
<br/>


       <label><?php echo _TABLEFIELDSTATUS; ?></label>

   <select class="custom-select form-control" name="slider_visibility" required="">

          <?php
          if($slider['slider_visibility'] == 1){
            echo '<option value="1" selected="selected">'._ENABLED.'</option>';
            echo '<option value="0">'._DISABLED.'</option>';

          } else{
            echo '<option value="0" selected="selected">'._DISABLED.'</option>';
            echo '<option value="1">'._ENABLED.'</option>';
          }
          ?>

   </select>

<br/>
<br/>

</div>

<hr>

<button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>

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