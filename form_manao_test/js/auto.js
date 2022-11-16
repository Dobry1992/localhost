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
                    if(res.flag_error){
                        if(res.error_login){
                            $('#error_login').html(`<p class="error">
                            ${res.error_login}</p>`);}
                        if(res.error_password){
                            $('#error_password').html(`<p class="error">
                            ${res.error_password}</p>`);}
                    } else {
                      $('#form_1').hide();
                      $('#form').hide();
                      $('#answer').html(`<nav class="navbar navbar-expand-lg navbar-light bg-light"><div = class="collapse navbar-collapse"><a class="nav-link active" aria-current="page">Hello, ${res.name}!</a></div>
                      <button class ="btn btn-danger">Выйти</button>
                    </nav>`
                    );}
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