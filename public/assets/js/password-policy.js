// This code use password policy

$(".password-policy").after('<div class="password-error" style="display:none;"><h3>Password must contain the following:</h3><p class="letter invalid">A <b>lowercase</b> letter</p><p class="capital invalid">A <b>capital (uppercase)</b> letter</p><p class="number invalid">A <b>number</b></p><p class="length invalid">Minimum <b>8 characters</b></p></div>');

// When the user clicks on the password field, show the message box
$(document).on("focus",".password-policy",function(){
  $(this).parent().children(".password-error").css("display", "");
  $(this).parent().find("#password-error,#"+$(this).attr('id')+"-error").css("display", "none");
});

$(document).on("blur",".password-policy",function(){
  $(this).parent().children(".password-error").css("display", "none");
  $(this).parent().find("#password-error,#"+$(this).attr('id')+"-error").css("display", "");
});

// When the user starts to type something inside the password field

$(document).on("keyup",".password-policy",function(){
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if($(this)[0].value.match(lowerCaseLetters)) {  
    $(this).parent().children(".password-error").children(".letter")[0].classList.remove("invalid");
    $(this).parent().children(".password-error").children(".letter")[0].classList.add("valid");
  } else {
    $(this).parent().children(".password-error").children(".letter")[0].classList.remove("valid");
    $(this).parent().children(".password-error").children(".letter")[0].classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if($(this)[0].value.match(upperCaseLetters)) {  
    $(this).parent().children(".password-error").children(".capital")[0].classList.remove("invalid");
    $(this).parent().children(".password-error").children(".capital")[0].classList.add("valid");
  } else {
    $(this).parent().children(".password-error").children(".capital")[0].classList.remove("valid");
    $(this).parent().children(".password-error").children(".capital")[0].classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if($(this)[0].value.match(numbers)) {  
    $(this).parent().children(".password-error").children(".number")[0].classList.remove("invalid");
    $(this).parent().children(".password-error").children(".number")[0].classList.add("valid");
  } else {
    $(this).parent().children(".password-error").children(".number")[0].classList.remove("valid");
    $(this).parent().children(".password-error").children(".number")[0].classList.add("invalid");
  }
  
  // Validate length
  //console.log("$(this)[0].length",$(this)[0].selectionEnd);
  if($(this)[0].value.length >= 8) {
    $(this).parent().children(".password-error").children(".length")[0].classList.remove("invalid");
    $(this).parent().children(".password-error").children(".length")[0].classList.add("valid");
  } else {
    $(this).parent().children(".password-error").children(".length")[0].classList.remove("valid");
    $(this).parent().children(".password-error").children(".length")[0].classList.add("invalid");
  }

  if($(this)[0].value.match(lowerCaseLetters) && $(this)[0].value.match(upperCaseLetters) && $(this)[0].value.match(numbers) && $(this)[0].value.length >= 8){
    $(this).parent().children(".password-error").css("display", "none");
    $(this).parent().find("#password-error,#"+$(this).attr('id')+"-error").css("display", "");
  }else{
    $(this).parent().children(".password-error").css("display","");
    $(this).parent().find("#password-error,#"+$(this).attr('id')+"-error").css("display", "none");
  }
  
});

// CUSTOM RULE ADD.......

$.validator.addMethod("lowercase_letter", function(value, element){
    var lowerCaseLetters = /[a-z]/g;
    if(value.match(lowerCaseLetters)){
         return true;
    }else{
         return false;
    }
}, "Password does not match the criteria");

$.validator.addMethod("capital_letter", function(value, element){
    var upperCaseLetters = /[A-Z]/g;
    if(value.match(upperCaseLetters)){
         return true;
    }else{
         return false;
    }
}, "Password does not match the criteria");

$.validator.addMethod("a_number", function(value, element){
    var numbers = /[0-9]/g;
    if(value.match(numbers)){
         return true;
    }else{
         return false;
    }
}, "Password does not match the criteria");

$.validator.addMethod("minimum_characters", function(value, element){
    if(value.length >= 8){
         return true;
    }else{
         return false;
    }
}, "Password does not match the criteria");