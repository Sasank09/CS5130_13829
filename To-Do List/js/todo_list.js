"use strict";

var $ele = (id) => document.getElementById(id);
var $qs = (classSelector) => document.querySelector(classSelector);
var $qsa = (classSelector) => document.querySelectorAll(classSelector);


function onLoadingIndexPage() {
    loginFormHandler();
}

function loginFormHandler() {
    toggleSpinner();
    let switchCtn = $qs("#switch-cnt");
    let switchC1 = $qs("#switch-c1");
    let switchC2 = $qs("#switch-c2");
    let switchCircle = $qsa(".switch__circle");
    let switchBtn = $qsa(".switch-btn");
    let aContainer = $qs("#a-container");
    let bContainer = $qs("#b-container");
    let changeForm = (e) => {
        switchCtn.classList.add("is-gx");
        setTimeout(function () {
            switchCtn.classList.remove("is-gx");
        }, 1500)

        switchCtn.classList.toggle("is-txr");
        switchCircle[0].classList.toggle("is-txr");
        switchCircle[1].classList.toggle("is-txr");

        switchC1.classList.toggle("is-hidden");
        switchC2.classList.toggle("is-hidden");
        aContainer.classList.toggle("is-txl");
        bContainer.classList.toggle("is-txl");
        bContainer.classList.toggle("is-z200");
    }
    let toggleForm = (e) => {
        for (var i = 0; i < switchBtn.length; i++)
            switchBtn[i].addEventListener("click", changeForm)
    }
    toggleForm();
    checkUserNameAvailability();
    validateRegistrationForm();
}

function checkUserNameAvailability() {
    $(document).ready(function () {
        $("#mail").keyup(function (e) {
            jQuery.ajax({
                url: "controller/check_user.php",
                data: "email=" + $("#mail").val(),
                type: "post",
                success: function (data) {
                    $("#user-availability-status").html(data);
                    console.log("data", data);
                },
                error: function () { }
            });
        });
    });

}

function toggleSpinner() {
    $(document).ready(function () {
        $("#cover-spinner").show();
        setTimeout(() => {
            $("#cover-spinner").hide();
        }, 2000);
    });
}


function togglePasswordVisibility(togId, passId) {
    const type = $ele(passId).getAttribute("type") === "password" ? "text" : "password";
    $ele(passId).setAttribute("type", type);
    // toggle the icon
    $ele(togId).classList.toggle("fa-eye");
}

function validateRegistrationForm() {
    $(document).ready(function () {
        $("#registration-form").validate({
            errorClass: "error fail-alert",
            validClass: "valid success-alert",
            rules:
            {
                fullname: {
                    required: true,
                    minlength: 3
                },
                mail: {
                    required: true,
                    email: true,
                    pattern: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{1,3})+$/
                },
                pass: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                },
                retype_pass: {
                    required: true,
                    equalTo: '#pass'
                },
            },
            messages:
            {
                fullname: {
                    required: "Full Name is Required",
                    minlength: "Full Name must be at least 3 characters",
                },
                email: {
                    required: "Email is Required",
                    email: "Enter a valid email address",
                    pattern: "Please Enter a Valid Email Address",
                },
                pass: {
                    required: "Please Provide a Password",
                    minlength: "password at least have 8 characters"
                },
                retype_pass: {
                    required: "Please Retype Your Password",
                    equalTo: "Password Doesn't Match!"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    })
}
