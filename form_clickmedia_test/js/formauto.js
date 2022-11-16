
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
    var forms = document.querySelectorAll('.needs-validation_1')
  
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          } else{
            $.ajax({
                url: '../php/formauto.php',
                type: 'POST',
                data: $('#form_1').serialize(),
                beforeSend: function(){
                  $('.loader').fadeIn();
                },
                success: function(response){
                  $('.loader').fadeOut('slow', function(){
                    let res = JSON.parse(response);
                    if(res.answer == "ok"){
                      $('#form_1').hide();
                      $('#form').hide();
                      $('#answer_1').html(`<div class="alert alert-success" role="alert">
                        Hello ${res.data.login.value}!
                      </div>`);
                    } else {
                      $('#answer_1').html(`<div class="alert alert-danger" role="alert">
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