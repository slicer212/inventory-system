$(document).ready(function(){
    var DOMAIN = "http://localhost/inventory_system";

    $("#register_form").on("submit", function(event){
        event.preventDefault(); 

        var name = $("#username");
        var email = $("#email");
        var pass1 = $("#password1");
        var pass2 = $("#password2");
        var type = $("#usertype");

        var e_patt = new RegExp(/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/);
        var status = true; 

        if (name.val() === "") {
            name.addClass("border-danger");
            $("#u_error").html("<span class='text-danger'>Please Enter Your Name</span>");
            status = false;
        } else {
            name.removeClass("border-danger");
            $("#u_error").html("");
        }

        if (!e_patt.test(email.val())) {
            email.addClass("border-danger");
            $("#e_error").html("<span class='text-danger'>Please Enter a Valid Email Address</span>");
            status = false;
        } else {
            email.removeClass("border-danger");
            $("#e_error").html("");
        }

        if (pass1.val() === "" || pass1.val().length < 9) {
            pass1.addClass("border-danger");
            $("#p1_error").html("<span class='text-danger'>Password must be at least 9 characters long</span>");
            status = false;
        } else {
            pass1.removeClass("border-danger");
            $("#p1_error").html("");
        }

        if (pass2.val() === "" || pass2.val().length < 9) {
            pass2.addClass("border-danger");
            $("#p2_error").html("<span class='text-danger'>Password do not match</span>");
            status = false;
        } else {
            pass2.removeClass("border-danger");
            $("#p2_error").html("");
        }

        if (type.val() === "") {
            type.addClass("border-danger");
            $("#t_error").html("<span class='text-danger'>Please Select a User Type</span>");
            status = false;
        } else {
            type.removeClass("border-danger");
            $("#t_error").html("");
        }

        if ($.trim(pass1.val()) !== $.trim(pass2.val())) {
            pass2.addClass("border-danger");
            $("#p2_error").html("<span class='text-danger'>Passwords do not match</span>");
            status = false;
        }

        if (status === true) {
            $(".overlay").show();
            let url = DOMAIN + "/includes/dashboard.php";
            if(type.value === "Faculty"){
                this.url = DOMAIN + "/includes/user_dashboard.php";
            }
            $.ajax({
                url: DOMAIN + "/includes/register.php",
                method: "POST",
                data: $("#register_form").serialize(),
                success: function(data) {
                    $(".overlay").hide();
                    alert(data);
                    if (data.trim() === "SUCCESS") {
                        $(".overlay").hide();
                        window.location.href = this.url;
                    }
                },
                error: function(xhr, status, error) {
                    $(".overlay").hide();
                    console.error("AJAX Error: " + status + ": " + error);
                    alert("An error occurred. Please try again.");
                }
            });
        }
    });

    $("#login_form").on("submit", function(event) {
        
        event.preventDefault(); 

        var email = $("#log_email");
        var pass = $("#log_password");
        var status = true;  

        if (email.val() === "") {
            email.addClass("border-danger");
            $("#e_error").html("<span class='text-danger'>Please Enter Email Address</span>");
            status = false; 
        } else {
            email.removeClass("border-danger");
            $("#e_error").html("");
        }

        if (pass.val() === "") {
            pass.addClass("border-danger");
            $("#p_error").html("<span class='text-danger'>Please Enter Password</span>");
            status = false;  
        } else {
            pass.removeClass("border-danger");
            $("#p_error").html("");
        }

        if (status === true) {
            $(".overlay").show();
            $.ajax({
                url: DOMAIN + "/includes/login.php",
                method: "POST",
                data: $("#login_form").serialize(),
                success: function(data) {
                    if (data.trim() === "LOGIN_SUCCESS") {
                        window.location.href = DOMAIN + "/dashboard.php";
                    } else if (data.trim() === "NOT_REGISTERED") {
                        $(".overlay").hide();
                        alert("This email is not registered. Please check your email or register first.");
                    } else if (data.trim() === "INCORRECT_PASSWORD") {
                        $(".overlay").hide();
                        alert("The password you entered is incorrect. Please try again.");
                    } else if (data.trim() === "USER_NOT_FOUND") {
                        $(".overlay").hide();
                        alert("No user found with this email address. Please check your email or register first.");
                    } else {
                        $(".overlay").hide();
                        alert("Login Failed: " + data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + ": " + error);
                    alert("An error occurred. Please try again.");
                }
            });
        }
    });

    $(document).ready(function(){
        fetch_category();
    
        function fetch_category(){
            $.ajax({
                url : DOMAIN + "/includes/process.php",
                method : "POST",
                data : {getCategory:1},
                success : function(data){
                    var root = "<option value='0'>Root</option>";
                    var choose = "<option value=''>Choose Category</option>";
                    $("#parent_cat").html(root + data);
                    $("#select_cat").html(choose + data);
                }
            });
        }
    });
});
    