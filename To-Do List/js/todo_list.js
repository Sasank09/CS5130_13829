"use strict";

var $ele = (id) => document.getElementById(id);
var $qs = (classSelector) => document.querySelector(classSelector);
var $qsa = (classSelector) => document.querySelectorAll(classSelector);


function onLoadingIndexPage() {
    loginFormHandler();

}

function loginFormHandler() {
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
}

