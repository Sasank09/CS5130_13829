"use strict";
/**
 * @param {*} id 
 * @returns an Element object representing the element whose id property matches the specified string.
 */
var $ = (id) => document.getElementById(id);

/**
 * this function expression performs the logic part to calculate tax and total amount
 */
var performCalculation = function calculate() {
    let subtotal = parseFloat($("subtotal").value)
    let tax_rate = parseFloat($("tax_rate").value)
    //calculating tax for the subtotal 
    let sales_tax = (subtotal * tax_rate) / 100
    //adding subtotal with tax to get total sales amount
    let total = subtotal + sales_tax
    //writing back to html inputs to display the result
    $("sales_tax").value = sales_tax.toFixed(2)
    $("total").value = total.toFixed(2)
};

/**
 * to handle onload event - onclicking button to call function expression for calculation 
 */
onload = function () {
    $("calculate").onclick = performCalculation
};