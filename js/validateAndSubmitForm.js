function validateForm()
{
    var errorMsg = "";
    var check=false;
         
        if($('#user_name').val() != ''){
             $(".user_name").removeClass("error-msg");
             $(".user_name").addClass("success-msg");
             check = true;
              $(".name_error").html('');
              
            if($('#user_email').val() != ''){
                
                 $(".user_email").removeClass("error-msg");
                 $(".user_email").addClass("success-msg");
                 check = true;
                  $(".email_error").html('');
                  
                 if($('#user_subject').val() != ''){
                      $(".user_subject").removeClass("error-msg");
                     $(".user_subject").addClass("success-msg");
                     check = true;
                     $(".subject_error").html('');
                     
                     if($('#user_message').val() != ''){
                          $(".user_message").removeClass("error-msg");
                         $(".user_message").addClass("success-msg");
                         check = true;
                          $(".message_error").html ('');
                     }
                     else{
                         $(".user_message").addClass("error-msg");
                        check = false;
                        errorMsg="Message is required";
                        $(".message_error").html (errorMsg);
                     }
                     
                 }else{
                     $(".user_subject").addClass("error-msg");
                    check = false;
                    errorMsg="Subject is required";
                    $(".subject_error").html(errorMsg);
                 }
                
            }
            else{
                $(".user_email").addClass("error-msg");
                check = false;
                errorMsg="Email is required";
                $(".email_error").html(errorMsg);
            }
        }
        else{
            $(".user_name").addClass("error-msg");
            check = false;
            errorMsg="Name is required";
           $(".name_error").html(errorMsg);
        }
    return check;    
}


  // jQuery AJAX call when the form is submitted
  $('#userForm').submit(function (event) {
      event.preventDefault(); // Prevent the default form submission

      // Get form data
    var isValid = validateForm();
    if(isValid){
            var formData = {
              userName: $('#user_name').val(),
              userEmail: $('#user_email').val(),
              userSubject: $('#user_subject').val(),
              userMessage: $('#user_message').val(),
              from:"", // abc@yourdomainname.com
              to:"", // abc@gmail.com
              subject:"Khyber Land - Client Information"
          };

            // Display the loading message before starting the AJAX call
        Swal.fire({
          icon: 'info',
          title: 'Sending email...',
          showConfirmButton: false, // Disable the "OK" button
          allowOutsideClick: false, // Prevent users from clicking outside the popup
          willOpen: function () {
              // Start the AJAX call when the loading message is displayed
              $.ajax({
                  url: 'SendEmail.php',
                  type: 'POST',
                  dataType: 'json',
                  data: formData,
                  success: function (data) {
                      // Callback function on success

                      // Close the loading message
                      Swal.close();
                      
                      if(data.status == "error"){
                          Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: 'There was an error sending the email.',
                          });
                        
                      }
                      else{
                          // Display SweetAlert pop-up for success
                          Swal.fire({
                              icon: 'success',
                              title: 'Success!',
                              text: data.message, 
                              footer: data.data,  
                          });

                          // Clear the form fields
                          $('#userForm')[0].reset();
                      }
                   
                     
                  },
              });
          }
      });
    }     
  });
