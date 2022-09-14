"use strict";
/**
 * @param {*} id 
 * @returns an Element object representing the element whose id property matches the specified string.
 */
var $ = (id) => document.getElementById(id);

//method to hide all expanded elements and bypass current element
function hideExpandedElements(clicked_h2) {
    var h2_expandedElements = document.querySelectorAll('h2.minus')
    for (let each_h2 of h2_expandedElements) {
        if (each_h2 !== clicked_h2) {
            var div_of_h2 = each_h2.nextElementSibling;
            each_h2.removeAttribute("class");
            div_of_h2.removeAttribute("class")
        }
    }
}

//this function expression - toggle between minus and plus of to view answers to respective question(h2)
var toggleElement = function toggle() {
    var h2 = this;
    var div = h2.nextElementSibling;

    //to hide all expanded elements by passing Clicked H2 element to bypass
    hideExpandedElements(h2)

    //logic below to display the selected h2 tag question - answer
    if (h2.hasAttribute("class"))
        h2.removeAttribute("class")
    else
        h2.setAttribute("class", "minus")

    if (div.hasAttribute("class"))
        div.removeAttribute("class")
    else
        div.setAttribute("class", "open")
};

//to handle onload event - changing DOM Content & CSS with help of JS 
onload = function () {
    var faqs = $("faqs");
    var h2_Elements = faqs.getElementsByTagName("h2");

    for (let index = 0; index < h2_Elements.length; index++) {
        h2_Elements[index].onclick = toggleElement;
    }

};