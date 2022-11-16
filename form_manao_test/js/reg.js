let input = document.querySelectorAll('input');
for(let i = 0; i < input.length; i++){
  input[i].disabled = false;
}
let button = document.querySelectorAll('button');
for(let i = 0; i < button.length; i++){
  button[i].disabled = false;
}

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        } else{
          $.ajax({
              url: '../php/formreg.php',
              type: 'POST',
              data: $('#form').serialize(),
              beforeSend: function(){
                $('.loader').fadeIn();
              },
              success: function(response){
                $('.loader').fadeOut('slow', function(){
                  let res = JSON.parse(response);
                  if(res.flag_error){
                    if(res.login_error){
                      $('#login_error').html(`<p class="error">
                      ${res.login_error}
                    </p>`);
                    }
                    if(res.password_error){
                      $('#password_error').html(`<p class="error">
                      ${res.password_error}
                    </p>`);
                    }
                    if(res.name_error){
                      $('#name_error').html(`<p class="error">
                      ${res.name_error}
                    </p>`);
                    }
                    if(res.email_error){
                      $('#email_error').html(`<p class="error">
                      ${res.email_error}
                    </p>`);
                    }
                    if(res.confirm_error){
                      $('#confirm_error').html(`<p class="error">
                      ${res.confirm_error}
                    </p>`);
                    }
                  } else {
                    $('#form').removeClass('was-validated').trigger('reset');
                    $('#answer').html(`<div class="alert alert-success" role="alert">
                      Регистрация прошла успешно!
                    </div>`);
                  }
                });
              },
              error: function(){
                alert('Error!');
              }
          });
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated')
      }, false)
    })
})()


