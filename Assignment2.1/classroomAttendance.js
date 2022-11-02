"use strict";
/**
 * @param {*} id 
 * @returns an Element object representing the element whose id property matches the specified string.
 */
var $ = (id) => document.getElementById(id);

//to store absent students name in array and counter to count
var absents_list = [];

/**
 * This function expression is to loop through all the images to display in TV Screen
 */
var loopThroughImages = function () {
    var path = 'images/tvSet/img'
    var num = 2
    var imageTag = $("imagesLoop")
    setInterval(function () {
        imageTag.src = path + String(num) + '.png';
        num++
        if (num == 7)
            num = 1
    }, 1000)
};

/**
 * This function expression is to display all student names in the app 
 */
var displayStudentNamesInGrid = function () {
    var count = 0;
    var fill_left_grid_elements = '';
    var fill_right_grid_elements = '';
    Object.values(student_records).forEach(record => {
        if( count%8 >= 0 && count % 8 < 4) {
            fill_left_grid_elements += '<div class="grid_element" id="' + record['name'] + '" onclick= "toggleAttendance(this.id)">' + record['name'] + '</div>';
        }
        else if(count % 8 >= 4 && count % 8 < 8) {
            fill_right_grid_elements += '<div class="grid_element" id="' + record['name'] + '" onclick= "toggleAttendance(this.id)">' + record['name'] + '</div>';  
        }
        count++;
    });
    $("left_grid").innerHTML = fill_left_grid_elements;
    $("right_grid").innerHTML = fill_right_grid_elements;
};

/**
 * This function is to print the absents count and display it 
 */
var showAbsentCount = function () {
    var resultElement = $("absent_count")
    var absent_counter = absents_list.length
    resultElement.innerText = 'The number of students absent = ' + absent_counter;
    if (absent_counter > 0) {
        resultElement.style.color = "red";
    }
    else {
        resultElement.style.color = "green";
    }

}

/**
 * This function is to handle onClick event on div grid elements to toggle attendance of students
 */
function toggleAttendance(clicked_id) {
    var getIndex_from_absent_list = absents_list.indexOf(clicked_id)
    var element = $(clicked_id)
    if (getIndex_from_absent_list > -1) {
        element.style.backgroundColor = "lightgray"
        absents_list.splice(getIndex_from_absent_list, 1);
    }
    else {
        absents_list.push(clicked_id)
        element.style.backgroundColor = "red"
    }
    showAbsentCount()
}

/**
 * This expression handles onload event and rendering of html with javascript
 */
onload = function () {
    loopThroughImages()
    displayStudentNamesInGrid()
    showAbsentCount()
};