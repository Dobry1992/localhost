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
                    if(res.answer == "ok"){
                      $('#form').removeClass('was-validated').trigger('reset');
                      $('#answer').html(`<div class="alert alert-success" role="alert">
                        Регистрация прошла успешно!
                      </div>`);
                    } else {
                      $('#answer').html(`<div class="alert alert-danger" role="alert">
                        ${res.errors}
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