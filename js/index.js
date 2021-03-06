'use strict';
// var pk = '';
// jQuery(document).ready(function($) {
//   var pk = $('input.publish_key').val();
//   console.log(pk);
      
//     }); 
var element = document.getElementById('publish_key').value;

var stripe = Stripe(element);

function registerElements(elements, exampleName) {
  var formClass = '.' + exampleName;
  var example = document.querySelector(formClass);

  var form = example.querySelector('form');
  var resetButton = example.querySelector('.close_payment');
  // var resetButton = example.querySelector('a.reset');
  var error = form.querySelector('.error');
  var errorMessage = error.querySelector('.message');

  function enableInputs() {
    Array.prototype.forEach.call(
      form.querySelectorAll(
        "input[type='text'], input[type='email'], input[type='tel']"
      ),
      function(input) {
        input.removeAttribute('disabled');
      }
    );
  }

  function disableInputs() {
    Array.prototype.forEach.call(
      form.querySelectorAll(
        "input[type='text'], input[type='email'], input[type='tel']"
      ),
      function(input) {
        input.setAttribute('disabled', 'true');
      }
    );
  }

  function triggerBrowserValidation() {
    // The only way to trigger HTML5 form validation UI is to fake a user submit
    // event.
    var submit = document.createElement('input');
    submit.type = 'submit';
    submit.style.display = 'none';
    form.appendChild(submit);
    submit.click();
    submit.remove();
  }

  // Listen for errors from each Element, and show error messages in the UI.
  var savedErrors = {};
  elements.forEach(function(element, idx) {
    element.on('change', function(event) {
      if (event.error) {
        error.classList.add('visible');
        savedErrors[idx] = event.error.message;
        errorMessage.innerText = event.error.message;
      } else {
        savedErrors[idx] = null;

        // Loop over the saved errors and find the first one, if any.
        var nextError = Object.keys(savedErrors)
          .sort()
          .reduce(function(maybeFoundError, key) {
            return maybeFoundError || savedErrors[key];
          }, null);

        if (nextError) {
          // Now that they've fixed the current error, show another one.
          errorMessage.innerText = nextError;
        } else {
          // The user fixed the last error; no more errors.
          error.classList.remove('visible');
        }
      }
    });
  });

  // Listen on the form's 'submit' handler...
  form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Trigger HTML5 validation UI on the form if any of the inputs fail
    // validation.
    var plainInputsValid = true;
    Array.prototype.forEach.call(form.querySelectorAll('input'), function(
      input
    ) {
      if (input.checkValidity && !input.checkValidity()) {
        plainInputsValid = false;
        return;
      }
    });
    if (!plainInputsValid) {
      triggerBrowserValidation();
      return;
    }

    // Show a loading screen...
    example.classList.add('submitting');

    // Disable all inputs.
    disableInputs();

    // Gather additional customer data we may have collected in our form.
    var name = form.querySelector('#' + exampleName + '-name');
    var email = form.querySelector('#' + exampleName + '-email');
    // var price = form.querySelector('#' + exampleName + '-price');
    // var address1 = form.querySelector('#' + exampleName + '-address');
    // var city = form.querySelector('#' + exampleName + '-city');
    // var state = form.querySelector('#' + exampleName + '-state');
    var zip = form.querySelector('#' + exampleName + '-zip');
    var additionalData = {
      name: name ? name.value : undefined,
      email: email ? email.value : undefined,
      price: $("input[name='price']").val(),
      description: $('p.order_desc').html(),
      // address_line1: address1 ? address1.value : undefined,
      // address_city: city ? city.value : undefined,
      // address_state: state ? state.value : undefined,
      address_zip: zip ? zip.value : undefined,
    };

    // Use Stripe.js to create a token. We only need to pass in one Element
    // from the Element group in order to create a token. We can also pass
    // in the additional customer data we collected in our form.
    stripe.createToken(elements[0], additionalData).then(function(result) {
      // Stop loading!
      // example.classList.remove('submitting');
      // example.classList.add('submitting');
      console.log(additionalData);
      $(".icon").show();
      if (result.token) {
      $(".div_top a").fadeOut('slow', function() {
        // $(".div_top a").show();
         $(".div_top a").hide();
      });        

        // If we received a token, show the token ID.
        $("input[name='token']").val(result.token.id);
        var session_id = $("input[name=session_strategy_id]").val();
        $.ajax({
          url: '../index.php/?action=stripe_payment',
          type: 'POST',
          data: {
            data: additionalData,
            stripe_token: result.token.id,
            session_id: session_id
          },
        })
        .done(function(response) { 
          // 4242 4242 4242 4242              
          console.log(response);
          if(response.includes('payment_done_success')){  
              $('.reset').hide();
              // var payment_id = $.trim(response).slice(0, -2);              
              example.classList.add('submitted'); 
              var file_link = $("input.file_url_compiled").val();

              $("h3.title").html("Payment successful");
              
              $("p.message").html("Thank You"); 
              
              // $('.reset').show();
              
              $(".spinner").hide();
              
              $(".div_top a").attr('href', file_link);
              
              $(".div_top a").fadeIn('slow', function() {
                $(".div_top a").show();
              });
              // var url = $("input[name='check_link_status']").val();
              // var close_interval;
              // close_interval = setInterval(function(){
              //   $.ajax({
              //     url: url,
              //     type: 'POST',
              //     data: {
              //       session_pay_id: payment_id
              //     },
              //   })
              //   .done(function(response) {
              //       var trimmed_res = $.trim(response);                   
              //       if(trimmed_res != ''){
              //       $('.reset').show();
              //       $(".spinner").hide();
              //       $(".div_top a").attr('href', trimmed_res);
              //       $(".div_top a").fadeIn('slow', function() {
              //         $(".div_top a").show();
              //       });
              //       clearInterval(close_interval);                    
              //       }else{
              //         $('.reset').hide();
              //         $(".spinner").show();
              //       }
              //   });
              // }, 1000);
              

          }else{
              console.log(response);
              $('.reset').hide();

              // example.classList.add('submitted'); 
              // $("h3.title").html("Payment Failed");
              // $("p.message").html(response);
              example.classList.remove('submitting');
              $('button.error_text').html(response);
              $("button.error_text").fadeIn().delay(5000).fadeOut();
              $(".icon").hide();
              form.reset();
              enableInputs();
          }
          // example.classList.add('submitted');                      

          // if(response.length > 1000){
          //   var response_data = $.parseJSON(response);
          //   if(response_data.paid){            
          //     example.classList.add('submitted'); 
          //     $("h3.title").html("Payment successful");
          //     $("p.message").html("Thank You"); 
          //     var url = $("input[name='check_link_status']").val();

              
          //     $.ajax({
          //       url: '/path/to/file',
          //       type: 'default GET (Other values: POST)',
          //       dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
          //       data: {param1: 'value1'},
          //     })
          //     .done(function() {
          //       console.log("success");
          //     })
          //     .fail(function() {
          //       console.log("error");
          //     })
          //     .always(function() {
          //       console.log("complete");
          //     });
              

          //   } 
          // }else{
          //     example.classList.add('submitted');                      
          //     $("h3.title").html("Payment Failed");
          //     $("p.message").html(response);
          //     $(".icon").hide();
          // }
         
        });
        // .fail(function(response) {
        //   console.log(response);
        // });       
        

      } else {
        // Otherwise, un-disable inputs.
        // console.log("Token Failed");
        // enableInputs();

              $('.reset').hide();
              example.classList.remove('submitting');
              $('button.error_text').html("Fill the form correctly");
              $("button.error_text").fadeIn().delay(5000).fadeOut();
              $(".icon").hide();
              form.reset();
              enableInputs();
      }
    });
  });

  resetButton.addEventListener('click', function(e) {
    e.preventDefault();

    $(".payment_stripe").fadeOut('slow', function() {
      
      $(".download-tab").css('opacity', '1');
      $(".payment_stripe").hide();

    });

    setInterval(function(){
      
    // Resetting the form (instead of setting the value to `''` for each input)
    // helps us clear webkit autofill styles.
      example.classList.remove('submitting');
    $(".div_top a").fadeOut('slow', function() {
      // $(".div_top a").show();
       $(".div_top a").hide();
    }); 
    form.reset();

    // Clear each Element.
    elements.forEach(function(element) {
      element.clear();
    });

    // Reset error state as well.
    error.classList.remove('visible');

    // Resetting the form does not un-disable inputs, so we need to do it separately:
    enableInputs();
    example.classList.remove('submitted');
    }, 2000);

    

  });


  // $(document).on('click', '.close_payment', function(event) {
  //   event.preventDefault();

  //   $(".payment_stripe").fadeOut('slow', function() {
      
  //     $(".download-tab").css('opacity', '1');
  //     $(".payment_stripe").hide();

  //   });

  // });
}
