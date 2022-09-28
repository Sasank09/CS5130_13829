"use strict";
/**
 * @param {*} id 
 * @returns an Element object representing the element whose id property matches the specified string.
 */
var $ = (id) => document.getElementById(id);

//Storing the names of all students to display
const students_Name_list = ["Kumar", "Reddy", "Ajay", "Sandeep", "Teja", "Priya", "Kishore", "Yamini", "Deepika", "Hema",
    "Hima", "Chanakya", "Manideep", "Mohan", "Rohini", "Lakshmi", "Ruchitha", "Raju", "Divya", "Priyanka", "Uday", "Arun", "Mounika", "Deepa", "Ashok",
    "Vamsi", "Akhil", "Leela", "Renna", "Lekhana", "Pavani", "Shiva"];

const middleIndex = Math.ceil(students_Name_list.length / 2);
const leftGrid_Students_list = students_Name_list.splice(0, middleIndex);
const rightGrid_Students_list = students_Name_list.splice(-middleIndex);

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
    //The below logic is to fill the student names on left side grid
    let fill_left_grid_elements = ''
    leftGrid_Students_list.forEach(eachName => {
        fill_left_grid_elements += '<div class="grid_element" id="' + eachName + '" onclick= "toggleAttendance(this.id)">' + eachName + '</div>';
    });
    $("left_grid").innerHTML = fill_left_grid_elements;

    //The below logic is to fill the student names on right side grid
    let fill_right_grid_elements = ''
    rightGrid_Students_list.forEach(eachName => {
        fill_right_grid_elements += '<div class="grid_element" id="' + eachName + '" onclick="toggleAttendance(this.id)">' + eachName + '</div>';
    });
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
    if(getIndex_from_absent_list > -1) {
        element.style.backgroundColor= "lightgray"
        absents_list.splice(getIndex_from_absent_list, 1);
    }
    else {
        absents_list.push(clicked_id)
        element.style.backgroundColor= "red"
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