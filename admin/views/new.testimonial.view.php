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
   
   <label><?php echo _TABLEFIELDNAME; ?></label>
   <input type="text" value="" name="testimonial_name" class="form-control" required="">

   <br/>

   <label><?php echo _TABLEFIELDCOMMENT; ?></label>
   <textarea name="testimonial_description" class="mceNoEditor form-control" rows="3" style="padding-top: 8px" required=""></textarea>

   <br/>
   
   <label><?php echo _TABLEFIELDJOB; ?></label>
   <input type="text" value="" name="testimonial_job" class="form-control" required="">


   <br/>

       <label><?php echo _TABLEFIELDSTATUS; ?></label>

   <select class="custom-select form-control" name="testimonial_status" required="">
<option value="1" selected=""><?php echo _ENABLED; ?></option>
<option value="0"><?php echo _DISABLED; ?></option>
   </select>

<br/>

   <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

   <select class="custom-select form-control" name="testimonial_lang" required="">
   <?php foreach($activelanguages as $language): ?>
   <option value="<?php echo $language['language_code']; ?>"><?php echo $language['language_name']; ?></option>
   <?php endforeach; ?>
   </select>

   <br/>

        <label><?php echo _TABLEFIELDIMAGE; ?></label>

<div class="new-image" id="image-preview">
  <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
  <input type="file" name="testimonial_image" id="image-upload" required="" />
</div>

<span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>350 x 350</b> </span>
<br/>
   </div>

<button class="btn btn-primary" type="submit" name="save"><?php echo _SAVECHANGES; ?></button>


</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
