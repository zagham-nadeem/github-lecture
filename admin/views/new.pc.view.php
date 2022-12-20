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
                        <div class="form-block mb-4">

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">


<div class="form-row">
  <div class="form-group col-md-9">
    <div class="block col-md-12">
     
  <label><?php echo _TABLEFIELDTITLE; ?></label>
  <input type="text" placeholder="" name="tr_title" class="form-control" required="">

  <label><?php echo _TABLEFIELDCONTENT; ?></label>

  <textarea type="text" class="mceNoEditor form-control" name="tr_content"></textarea>

        <label><?php echo _TABLEFIELDIMAGE; ?></label>

<div class="new-image" id="image-preview">
  <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
  <input type="file" name="pc_image" id="image-upload" required="" />
</div>

<span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>450 x 350</b> </span>
   <br/>
   <br/>

     </div>
  </div>
<div class="form-group col-md-3 sidebar">
   
   <div class="block col-md-12">

   <label class="control-label"><?php echo _TABLEFIELDLANG; ?></label>

   <select class="custom-select form-control" name="tr_lang" required="">
   <?php foreach($languages as $language): ?>
   <option value="<?php echo $language['language_code']; ?>"><?php echo $language['language_name']; ?></option>
   <?php endforeach; ?>
   </select>

   </div>

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