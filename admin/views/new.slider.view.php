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
                            <h5><?php echo _ADDITEM; ?></h5>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="block form-block mb-4">

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
<div class="form-row">

              <div class="form-group col-md-12">
   
   <label class="control-label"><?php echo _TABLEFIELDPROPERTY; ?></label>

   <select class="custom-select form-control selectDrop" name="slider_property" id="select2" required="">
   <option value="" selected>-</option>
   <?php foreach($properties as $property): ?>
   <option value="<?php echo $property['pt_id']; ?>">Ref. <?php echo $property['pt_reference']; ?></option>
   <?php endforeach; ?>
   </select>
<br/>
<br/>
        <label><?php echo _TABLEFIELDIMAGE; ?></label>

<div class="new-image" id="image-preview">
  <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
  <input type="file" name="slider_image" id="image-upload" required="" />
</div>

<span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>1200 x 600</b> </span>
<br/>
<br/>

       <label><?php echo _TABLEFIELDSTATUS; ?></label>

   <select class="custom-select form-control" name="slider_visibility" required="">
<option value="1" selected=""><?php echo _ENABLED; ?></option>
<option value="0"><?php echo _DISABLED; ?></option>
   </select>
<br/>
<br/>

</div>

<hr>

<button class="btn btn-primary" type="submit" name="save"><?php echo _SAVECHANGES; ?></button>

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
