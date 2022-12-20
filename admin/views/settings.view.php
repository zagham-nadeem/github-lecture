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
  <h4><?php echo _SETTINGS; ?></h4> 
</div>
</div>

<div class="col-12 c-col-12">
<div id="saved"><i class="fa fa-check"></i> <?php echo _CHANGESSAVED; ?></div>
<input type="submit" name="save" id="save" value="<?php echo _SAVECHANGES; ?>" class="btn btn-primary" form="setSettings" />
</div>

<div class="col-md-12">
<div class="block form-block mb-4" style="margin-top: 20px;">

  <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="setSettings">

    <div class="form-row">

      <div class="form-group col-md-12">

        <div class="table-responsive">

          <fieldset>
            <legend><?php echo _ADMINSETTINGS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _DEFAULTLANGUAGE; ?></label>
                  <select class="custom-select form-control" id="adminlanguages">
                      <option value="en"<?php if( $_COOKIE["adminLang"] == "en" ) { echo " selected"; } ?>>English</option>
                      <option value="es"<?php if( $_COOKIE["adminLang"] == "es" ) { echo " selected"; } ?>>Español</option>
                      <option value="fr"<?php if( $_COOKIE["adminLang"] == "fr" ) { echo " selected"; } ?>>Français</option>
                      <option value="ar"<?php if( $_COOKIE["adminLang"] == "ar" ) { echo " selected"; } ?>>العربية</option>
                  </select>
                </td>
              </tr>
            </table>
          </fieldset>

          <fieldset>
            <legend><?php echo _SITESETTINGS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _DEFAULTLANGUAGE; ?></label>

                  <select class="custom-select form-control" name="st_language" required="">
                    <?php
                    foreach($languages as $language)
                    {
                      if($settings['st_language'] == $language['language_code'])
                      {
                        echo '<option value="'.$settings['st_language'].'" selected="selected">'.$language['language_name'].'</option>';
                      }
                      else{
                        echo '<option value="'.$language['language_code'].'">'.$language['language_name'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _MAINTENANCEMODE; ?></label>

                  <select class="custom-select form-control" name="st_maintenance">
                    <?php
                      if($settings['st_maintenance'] == '1')
                      {
                        echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                        echo '<option value="0" >'._DISABLED.'</option>';
                      }
                      else
                      {
                        echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                        echo '<option value="1">'._ENABLED.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _CURRENCYSYMBOL; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_currency']; ?>" name="st_currency" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _CURRENCYPOSITION; ?></label>
                  <select class="custom-select form-control" id="currency-position" data-selected="<?php echo $settings['st_currencyposition']; ?>" name="st_currencyposition">
                    <option value="left"><?php echo $settings['st_currency']; ?>0.00</option>
                    <option value="right">0.00<?php echo $settings['st_currency']; ?></option>
                    <option value="left-space"><?php echo $settings['st_currency']; ?> 0.00</option>
                    <option value="right-space">0.00 <?php echo $settings['st_currency']; ?></option>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DECIMALSEPARATOR; ?></label>
                  <select class="custom-select form-control" id="decimal-separator" data-selected="<?php echo $settings['st_decimalseparator']; ?>" name="st_decimalseparator">
                    <option value=".">100.11</option>
                    <option value=",">100,11</option>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _UNIT; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_unit']; ?>" name="st_unit" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DATEFORMAT; ?></label>
                  <select class="custom-select form-control" id="date-format" data-selected="<?php echo $settings['st_dateformat']; ?>" name="st_dateformat">
                    <option value="d/m/Y">DD/MM/YYYY</option>
                    <option value="m/d/Y">MM/DD/YYYY</option>
                    <option value="Y/m/d">YYYY/MM/DD</option>
                    <option value="d-m-Y">DD-MM-YYYY</option>
                    <option value="m-d-Y">MM-DD-YYYY</option>
                    <option value="Y-m-d">YYYY-MM-DD</option>
                    <option value="d.m.Y">DD.MM.YYYY</option>
                    <option value="m.d.Y">MM.DD.YYYY</option>
                    <option value="Y.m.d">YYYY.MM.DD</option>
                  </select>
                </td>
              </tr>

            </table>

          </fieldset>

          <fieldset id="pages">
            <legend><?php echo _DEFAULTPAGES; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _DEFAULTPROPERTIESPAGE; ?></label>

                  <select class="custom-select form-control" name="st_defaultpropertiespage">
                    <option value>-</option>
                    <?php
                    foreach($propertiespages as $page)
                    {
                      if($settings['st_defaultpropertiespage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultpropertiespage'].'" selected="selected">'.$page['tr_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['tr_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DEFAULTSEARCHPAGE; ?></label>

                  <select class="custom-select form-control" name="st_defaultsearchpage">
                    <option value>-</option>
                    <?php
                    foreach($searchpages as $page)
                    {
                      if($settings['st_defaultsearchpage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultsearchpage'].'" selected="selected">'.$page['tr_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['tr_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DEFAULTCONTACTPAGE; ?></label>

                  <select class="custom-select form-control" name="st_defaultcontactpage">
                    <option value>-</option>
                    <?php
                    foreach($contactpages as $page)
                    {
                      if($settings['st_defaultcontactpage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultcontactpage'].'" selected="selected">'.$page['tr_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['tr_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DEFAULTBLOGPAGE; ?></label>

                  <select class="custom-select form-control" name="st_defaultblogpage">
                    <option value>-</option>
                    <?php
                    foreach($blogpages as $page)
                    {
                      if($settings['st_defaultblogpage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultblogpage'].'" selected="selected">'.$page['tr_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['tr_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DEFAULTPRIVACYPAGE; ?></label>

                  <select class="custom-select form-control" name="st_defaultprivacypage">
                    <option value>-</option>
                    <?php
                    foreach($privacypages as $page)
                    {
                      if($settings['st_defaultprivacypage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaultprivacypage'].'" selected="selected">'.$page['tr_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['tr_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _DEFAULTTERMSPAGE; ?></label>

                  <select class="custom-select form-control" name="st_defaulttermspage">
                    <option value>-</option>
                    <?php
                    foreach($termspages as $page)
                    {
                      if($settings['st_defaulttermspage'] == $page['page_id'])
                      {
                        echo '<option value="'.$settings['st_defaulttermspage'].'" selected="selected">'.$page['tr_title'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$page['page_id'].'">'.$page['tr_title'].'</option>';
                      }
                    }
                    ?>
                  </select>
                </td>
              </tr>

            </table>
          </fieldset>

          <fieldset>
            <legend><?php echo _COMPANYINFO; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _EMAIL; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_email']; ?>" name="st_email" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _PHONE; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_phone']; ?>" name="st_phone" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _OFFICEADDRESS; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_officeaddress']; ?>" name="st_officeaddress" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Facebook</label>
                  <input class="form-control" value="<?php echo $settings['st_facebook']; ?>" name="st_facebook" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Twitter</label>
                  <input class="form-control" value="<?php echo $settings['st_twitter']; ?>" name="st_twitter" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Youtube</label>
                  <input class="form-control" value="<?php echo $settings['st_youtube']; ?>" name="st_youtube" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Instagram</label>
                  <input class="form-control" value="<?php echo $settings['st_instagram']; ?>" name="st_instagram" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Linkedin</label>
                  <input class="form-control" value="<?php echo $settings['st_linkedin']; ?>" name="st_linkedin" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label>Whatsapp</label>
                  <input class="form-control" value="<?php echo $settings['st_whatsapp']; ?>" name="st_whatsapp" type="text">
                </td>
              </tr>

            </table>

          </fieldset>

          <fieldset>
            <legend><?php echo _SMTPEMAILS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _RECIPIENTEMAIL; ?>  <small style="display: block; margin-bottom: 8px; margin-top: 5px;"><?php echo _MESSAGERECIPIENTEMAIL; ?></small></label>
                  <input class="form-control" value="<?php echo $settings['st_recipientemail']; ?>" name="st_recipientemail" type="email">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPHOST; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtphost']; ?>" name="st_smtphost" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPUSER; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtpemail']; ?>" name="st_smtpemail" type="email">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPPASSWORD; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtppassword']; ?>" name="st_smtppassword" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPENCRYPT; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtpencrypt']; ?>" name="st_smtpencrypt" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SMTPPORT; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_smtpport']; ?>" name="st_smtpport" type="text">
                </td>
              </tr>

            </table>

          </fieldset>

          <fieldset>
            <legend><?php echo _LAYOUTSETTINGS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _MORTAGECALCULATOR; ?></label>
                    <select class="custom-select form-control" name="st_calculator" required="">
                      <?php
                      if($settings['st_calculator'] == 1)
                      {
                        echo '<option value="1" selected="selected">'._VISIBLE.'</option>';
                        echo '<option value="0">'._HIDDEN.'</option>';
                      }
                      else
                      {
                        echo '<option value="0" selected="selected">'._HIDDEN.'</option>';
                        echo '<option value="1">'._VISIBLE.'</option>';
                      }
                      ?>
                    </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _FEATUREDPROPERTIESLIMIT; ?></label>

                    <select class="custom-select form-control" name="st_featuredproperties">
                      <?php foreach (range(1, 9) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_featuredproperties'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _RECENTPROPERTIESLIMIT; ?></label>

                    <select class="custom-select form-control" name="st_recentproperties">
                      <?php foreach (range(1, 9) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_recentproperties'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _OFFERSPROPERTIESLIMIT; ?></label>

                    <select class="custom-select form-control" name="st_offersproperties">
                      <?php foreach (range(1, 9) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_offersproperties'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _SIMILARPROPERTIESLIMIT; ?></label>

                    <select class="custom-select form-control" name="st_similarproperties">
                      <?php foreach (range(1, 9) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_similarproperties'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _FEATUREDPOSTSLIMIT; ?></label>

                    <select class="custom-select form-control" name="st_featuredposts">
                      <?php foreach (range(1, 9) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_featuredposts'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _FEATUREDCITIESLIMIT; ?></label>

                    <select class="custom-select form-control" name="st_featuredcities">
                      <?php foreach (range(1, 9) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_featuredcities'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _RESULTSPERPAGESEARCH; ?></label>

                    <select class="custom-select form-control" name="st_searchlimit">
                      <?php foreach (range(1, 20) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_searchlimit'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _RESULTSPERPAGEPROPERTIES; ?></label>

                    <select class="custom-select form-control" name="st_propertieslimit">
                      <?php foreach (range(1, 20) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_propertieslimit'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _RESULTSPERPAGEBLOG; ?></label>

                    <select class="custom-select form-control" name="st_bloglimit">
                      <?php foreach (range(1, 20) as $num): ?>
                      <option value="<?php echo $num ?>" <?php echo ($settings['st_bloglimit'] != $num ? NULL : "selected") ?>><?php echo $num ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
              </tr>

            </table>

          </fieldset>


          <fieldset>
            <legend><?php echo _GENERALSETTINGS; ?></legend>

            <table class="display table s-table">

              <tr>  
                <td>
                  <label><?php echo _ANALYTICSTRACKINGCODE; ?></label>
                  <textarea class="form-control mceNoEditor" name="st_analytics" type="text"><?php echo $settings['st_analytics']; ?></textarea>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _GOOGLERECAPTCHAKEY; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_recaptchakey']; ?>" name="st_recaptchakey" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _GOOGLERECAPTCHASECRETKEY; ?></label>
                  <input class="form-control" value="<?php echo $settings['st_recaptchasecretkey']; ?>" name="st_recaptchasecretkey" type="text">
                </td>
              </tr>

            </table>

          </fieldset>


</div>
</div>
</div>

<input type="submit" name="save" id="save2" value="<?php echo _SAVECHANGES; ?>" class="btn btn-primary" form="setSettings" />
<div id="saved2"><i class="fa fa-check"></i> <?php echo _CHANGESSAVED; ?></div>

</form>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

  <div class="scrollTop">
    <span><a href=""><i class="dripicons-arrow-thin-up"></i></a></span>
  </div>