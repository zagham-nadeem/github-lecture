/* PRELOADER */

'use strict';
$(window).on('load', function() {
 $('#preloader').fadeOut('slow');
});

/* NICE-SELECT */

'use strict';
$(document).ready(function() {
	$('.nc-select').niceSelect();
});

'use strict';
function goBack() {
  window.history.back();
}

/* SUBMIT NO EMPTY FIELD */

'use strict';
$(document).ready(function($){

  $("#searchForm").submit(function() {
    $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
    return true;
  });

  $( "#searchForm" ).find( ":input" ).prop( "disabled", false );

});

'use strict';
$(document).ready(function($){

  $("#searchModalForm").submit(function() {
    $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
    return true;
  });

  $( "#searchModalForm" ).find( ":input" ).prop( "disabled", false );

});

/* ORDER BY */

'use strict';
function insertParam(key, value) {
  key = escape(key); value = escape(value);

  var kvp = document.location.search.substr(1).split('&');
  if (kvp == '') {
    document.location.search = '?' + key + '=' + value;
  }
  else {

    var i = kvp.length; var x; while (i--) {
      x = kvp[i].split('=');

      if (x[0] == key) {
        x[1] = value;
        kvp[i] = x.join('=');
        break;
      }
    }

    if (i < 0) { kvp[kvp.length] = [key, value].join('='); }

    document.location.search = kvp.join('&');
  }
}

$('#sortby').on('change', function () {
 var key = 'sortby';
 var value = $(this).val();
 insertParam(key, value);
});

/* PAGINATION */

'use strict';
$(document).ready(function(){
  $('.change-page').on('click', function(){

    var paramName = 'p';
    var paramValue = $(this).data('page');

    var url = window.location.href;
    var hash = location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0)
    {
      var prefix = url.substring(0, url.indexOf(paramName + "=")); 
      var suffix = url.substring(url.indexOf(paramName + "="));
      suffix = suffix.substring(suffix.indexOf("=") + 1);
      suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
      url = prefix + paramName + "=" + paramValue + suffix;
    }
    else
    {
      if (url.indexOf("?") < 0)
        url += "?" + paramName + "=" + paramValue;
      else
        url += "&" + paramName + "=" + paramValue;
    }
    
    window.location.href = url + hash;

  });
  
});

/* CHANGE LANGUAGE */

'use strict';
$(document).ready(function(){
  $('.change-lang').on('click', function(){

    var paramName = 'lang';
    var paramValue = $(this).data('lang');

    var url = window.location.href;
    var hash = location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0)
    {
      var prefix = url.substring(0, url.indexOf(paramName + "=")); 
      var suffix = url.substring(url.indexOf(paramName + "="));
      suffix = suffix.substring(suffix.indexOf("=") + 1);
      suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
      url = prefix + paramName + "=" + paramValue + suffix;
    }
    else
    {
      if (url.indexOf("?") < 0)
        url += "?" + paramName + "=" + paramValue;
      else
        url += "&" + paramName + "=" + paramValue;
    }
    
    window.location.href = url + hash;

  });
  
});


/* GET ZONES BY CITY */

'use strict';
$(document).ready(function(){

 $(".cities").change(function(){
  var city = $(this).val();
  var id = 'city='+city;

  $.ajax({
   type: "POST",
   url: SITEURL+"/controllers/zones.php",
   data: id,
   cache: false,
   success: function(html){
    $(".zones").html(html);
    $('.zones').niceSelect('update');
  } 
});
});
});

/* DISABLE NICE SELECT MOBILE DEVICES */

'use strict';
$(document).ready(function() {
  checkSize();
  $(window).resize(checkSize);
});

function checkSize(){
  if (window.matchMedia("(min-width: 768px)").matches) {
    $("select").removeClass('uk-select');
    $("select").niceSelect();
    $("select").addClass('nc-select');
  } else {
    $("select").niceSelect("destroy");
    $("select").removeClass('nc-select');
    $("select").addClass('uk-select');
  }
}

/* REMOVE FILTER FROM URL */
'use strict';
function removeFilter(param) {

  var url = document.location + '';

  var urlParts = url.split('?'),
  preservedQueryParams = '';

  if (urlParts.length === 2) {
    preservedQueryParams = urlParts[1]
    .split('&')
    .filter(function(queryParam) {
      return !(queryParam === param || queryParam.indexOf(param + '=') === 0)
    })
    .join('&');
  }

  var newUrl = urlParts[0] + (preservedQueryParams && '?' + preservedQueryParams);

  window.location.href = newUrl;

}

/* FROMS */

'use strict';
  function onRecaptchaSuccess(){
    $('#submit-form').submit();
  }

/* CONTACT FORM */

'use strict';
$('.contact-form form').submit(function (event) {

$('#submit').hide();
$('#loading').show();

  event.preventDefault();
  grecaptcha.reset();
  grecaptcha.execute();

});

'use strict';
$(document).ready(function(){
  $('.contact-form input, .contact-form textarea').on('focus', function() {

    $('.contact-form input, .contact-form textarea').removeClass('uk-form-danger');
    $('.contact-form label').removeClass('uk-text-danger');
    $('.contact-form #ischecked').removeClass('ev-danger-checkbox');
    $('.contact-form .errors').hide("");
  });
});

function contactForm(response) {

    $('.contact-form input, .contact-form textarea').removeClass('uk-form-danger');
    $('.contact-form label').removeClass('uk-text-danger');
    $('.contact-form #ischecked').removeClass('ev-danger-checkbox');

    $.ajax({
      type: 'POST',
      url: SITEURL+"/controllers/contact-form.php",
      data: {
          name:$("#name").val(),
          phone:$("#phone").val(),
          email:$("#email").val(),
          message:$("#message").val(),
          ischecked:$("#ischecked").is(':checked'),
          recaptcha: response
      },
      dataType: 'json',
      success: function(json) {

        $('#submit').show();
        $('#loading').hide();
    
        if(json.contactName != '') {
          $('.contact-form #errorNameText').show().html(json.contactName);
          $('.contact-form #name').addClass('uk-form-danger');
        }
        if(json.contactEmail != '') {
          $('.contact-form #errorEmailText').show().html(json.contactEmail);
          $('.contact-form #email').addClass('uk-form-danger');
        }
        if(json.contactMessage != '') {
          $('.contact-form #errorMessageText').show().html(json.contactMessage);
          $('.contact-form #message').addClass('uk-form-danger');
        }
        if(json.isChecked != '') {
          $('.contact-form #errorCheckedText').show().html(json.isChecked);
          $('.contact-form #ischecked').addClass('ev-danger-checkbox');
          $('.contact-form #checked').addClass('uk-text-danger');
        }
        if(json.error != '' && json.recaptcha == '' && json.contactName == '' && json.contactEmail == ''
        && json.isChecked == '' && json.contactMessage == ''){

        $('.contact-form #error').css("display", "block");

        setTimeout(function() {
            $('.contact-form #error').css("display", "none");
        }, 5000);

    }
      if (json.error == '' && json.recaptcha == '' && json.contactName == ''
        && json.contactEmail == ''
        && json.isChecked == '' && json.contactMessage == '') {
          $(".contact-form form")[0].reset();
          $('.contact-form').hide();
          $('#success').show();
    }
}
});

};


/* PROPERTY FORM */

$('.property-form form').submit(function (event) {

$('#submit').hide();
$('#loading').show();

  event.preventDefault();
  grecaptcha.reset();
  grecaptcha.execute();

});

'use strict';
$(document).ready(function(){
  $('.property-form input, .property-form textarea').on('focus', function() {

    $('.property-form input, .property-form textarea').removeClass('uk-form-danger');
    $('.property-form label').removeClass('uk-text-danger');
    $('.property-form #ischecked').removeClass('ev-danger-checkbox');
    $('.property-form .errors').hide("");
  });
});

function propertyForm(response) {

    $('.property-form input, .property-form textarea').removeClass('uk-form-danger');
    $('.property-form label').removeClass('uk-text-danger');
    $('.property-form #ischecked').removeClass('ev-danger-checkbox');

    $.ajax({
      type: 'POST',
      url: SITEURL+"/controllers/property-form.php",
      data: {
          ref:$("#ref").val(),
          url:$("#url").val(),
          name:$("#name").val(),
          phone:$("#phone").val(),
          email:$("#email").val(),
          message:$("#message").val(),
          ischecked:$("#ischecked").is(':checked'),
          recaptcha: response
      },
      dataType: 'json',
      success: function(json) {

        $('#submit').show();
        $('#loading').hide();
    
        if(json.contactName != '') {
          $('.property-form #errorNameText').show().html(json.contactName);
          $('.property-form #name').addClass('uk-form-danger');
        }
        if(json.contactPhone != '') {
          $('.property-form #errorPhoneText').show().html(json.contactPhone);
          $('.property-form #phone').addClass('uk-form-danger');
        }
        if(json.contactEmail != '') {
          $('.property-form #errorEmailText').show().html(json.contactEmail);
          $('.property-form #email').addClass('uk-form-danger');
        }
        if(json.contactMessage != '') {
          $('.property-form #errorMessageText').show().html(json.contactMessage);
          $('.property-form #message').addClass('uk-form-danger');
        }
        if(json.isChecked != '') {
          $('.property-form #ischecked').addClass('ev-danger-checkbox');
          $('.property-form #checked').addClass('uk-text-danger');
        }
        if(json.error != '' && json.recaptcha == '' && json.contactName == ''
        && json.contactPhone == ''  && json.contactEmail == ''
        && json.isChecked == '' && json.contactMessage == ''){

        $('.property-form #error').css("display", "block");

        setTimeout(function() {
            $('.property-form #error').css("display", "none");
        }, 5000);

    }
      if (json.error == '' && json.recaptcha == '' && json.contactName == ''
        && json.contactPhone == ''  && json.contactEmail == ''
        && json.isChecked == '' && json.contactMessage == '') {
          $(".property-form form")[0].reset();
          $('.property-form').hide();
          $('#success').show();
    }
}
});

};

/* SEND TO FRIEND FORM */

'use strict';
$(document).ready(function(){

  $('.email-form input').on('focus', function() {

    $('.email-form input').removeClass('uk-form-danger');
    $('.email-form label').removeClass('uk-text-danger');
    $('.email-form .errors').hide("");
  });
});

    $('.email-form input').removeClass('uk-form-danger');
    $('.email-form label').removeClass('uk-text-danger');

$('.email-form form').on("submit", function(event){ 

  $('.email-form #submit').hide();
  $('.email-form #loading').show();

  event.preventDefault();  

    $.ajax({
      type: 'POST',
      url: SITEURL+"/controllers/send-property.php",
      data: {
          pid:$("#pid").val(),
          ptitle:$("#ptitle").val(),
          pref:$("#pref").val(),
          pimage:$("#pimage").val(),
          pprice:$("#pprice").val(),
          purl:$("#purl").val(),
          sendername:$("#sendername").val(),
          senderemail:$("#senderemail").val(),
          friendemail:$("#friendemail").val()
      },
      dataType: 'json',
      success: function(json) {

        $('.email-form #submit').show();
        $('.email-form #loading').hide();
    
        if(json.senderName != '') {
          $('.email-form #errorNameText').show().html(json.senderName);
          $('.email-form #sendername').addClass('uk-form-danger');
        }

        if(json.senderEmail != '') {
          $('.email-form #errorUserText').show().html(json.senderEmail);
          $('.email-form #senderemail').addClass('uk-form-danger');
        }
        if(json.friendEmail != '') {
          $('.email-form #errorFriendText').show().html(json.friendEmail);
          $('.email-form #friendemail').addClass('uk-form-danger');
        }
        if(json.error != '' && json.senderName == '' && json.senderEmail == '' && json.friendEmail == ''){

        $('.email-form #error').css("display", "block");

        setTimeout(function() {
            $('.email-form #error').css("display", "none");
        }, 5000);

    }
      if (json.error == '' && json.senderName == '' && json.senderEmail == '' && json.friendEmail == '') {
          $(".email-form form")[0].reset();
          $('.email-form').hide();
          $('#sendsuccess').show();
    }
}
});
});

/* UPDATE PROFILE */

'use strict';
$('.update-profile form').on("submit", function(event){ 

  event.preventDefault();  

  var $this = $('#submit-send');
  var loadingText = '<i class="fas fa-circle-notch fa-spin"></i>';
  if ($('#submit-send').html() !== loadingText) {
    $this.html(loadingText);
  }

    $.ajax({
      type: 'POST',
      url: SITEURL+"/controllers/update-profile.php",
      data: {
          user_id:$("#user_id").val(),
          user_name:$("#user_name").val(),
          user_phone:$("#user_phone").val(),
          user_password_save:$("#user_password_save").val(),
          user_password:$("#user_password").val(),
          user_confirm_password:$("#user_confirm_password").val()
      },
      success: function(data) {

        setTimeout(function(){
          $('#showresults').html(data);
          $this.html($this.val());
        }, 1000);

    }
});
});

/* NEW SUBSCRIBER */

'use strict';
$('.new-subscriber form').on("submit", function(event){ 

  event.preventDefault();  

  var $this = $('#submit-subscriber');
  var loadingText = '<i class="fas fa-circle-notch fa-spin"></i>';
  if ($('#submit-subscriber').html() !== loadingText) {
    $this.html(loadingText);
  }

    $.ajax({
      type: 'POST',
      url: SITEURL+"/controllers/add-subscriber.php",
      data: {
          subscriber_email:$("#subscriber_email").val(),
      },
      success: function(data) {

        setTimeout(function(){
          $('#showresults').html(data);
          $this.html($this.val());
        }, 1000);

    }
});
});

/* FAVORITES */
  'use strict';
    $(document).ready(function(){
        $('.addfav').on('click', function(){
            var itemId = $(this).data('item');
            var userId = $(this).data('user');
            $.ajax({
                url: SITEURL+"/controllers/favorite.php?action=add",
                type: 'post',
                data: {
                    'item': itemId,
                    'user': userId
                },
                success: function(response){
                    $('.addfav').addClass('uk-hidden uk-animation-fade');
                    $('.addfav').siblings().removeClass('uk-hidden');
                },
            });
        });

        $('.removefav').on('click', function(){
            var itemId = $(this).data('item');
            var userId = $(this).data('user');
            $.ajax({
                url: SITEURL+"/controllers/favorite.php?action=remove",
                type: 'post',
                data: {
                    'item': itemId,
                    'user': userId
                },
                success: function(response){
                    $('.removefav').addClass('uk-hidden uk-animation-fade');
                    $('.removefav').siblings().removeClass('uk-hidden');
                    $('#FavId-'+itemId).addClass('uk-hidden');
                }
            });
        });
    });

/* MORTAGE CALCULATOR */

function calculateMortgage(p,r,n) {

  r = percentToDecimal(r);

  n = yearsToMonths(n);

  var pmt = ( r * p ) / (1 - Math.pow((1 + r) , (-n) ));

  return parseFloat(pmt.toFixed(2));
}

function percentToDecimal(percent) {
  return (percent/12)/100;
}

function yearsToMonths(year) {
  return year * 12;
}

function postPayments(payment) {
  document.getElementById("inResults").style.display = "block";
  var htmlEl = document.getElementById('outMontly');
  htmlEl.innerText = payment;
}

var btn = document.getElementById('btnCalculate');
btn.onclick = function() {

 var cost = document.getElementById('inCost').value;

 var downPayment = document.getElementById('inDown').value;
 var interst = document.getElementById('inAPR').value;
 var term   = document.getElementById('inPeriod').value;

 if (cost < 0 || downPayment < 0 || interst < 0 || term <0) {
   return false;
 }
 if (cost == "" || downPayment == "" || interst == "" || term == "") {
   return false;
 }

 var amount = cost - downPayment;
 var pmt = calculateMortgage(amount,interst,term);
 postPayments(pmt);

};
