// hiding error messages on input
              $(".input-group input").focusin(function() {
              $(this).siblings(".error").hide()
              });
              // confirm box on deletion
              function ConfirmDelete() {
                 var x = confirm("Are you sure you want to delete this record?");
                 if(x)
                    return true;
                 else             
                    return false;
              }


              $(document).on("change", "#dropdownid", function() {
                  var y= ($(this).find("option:selected").val());
                  alert(y);
              });

                          // setTimeout(function(){
              //    document.getElementById("msg").style.display='none';
  