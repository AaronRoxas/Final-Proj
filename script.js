// Get the modals
var addGradeModal = document.getElementById('addGradeModal');
var addStudentModal = document.getElementById('addStudentModal');
var addCourseModal = document.getElementById('addCourseModal');



// Get the buttons that open the modals
var addGradeBtn = document.getElementById('addGradeBtn');
var addStudentBtn = document.getElementById('addStudentBtn');
var addCourseBtn = document.getElementById('addCourseBtn');
var dashboardBtn = document.getElementById('dashboardBtn');
var viewCourseListBtn = document.getElementById('viewCourseListBtn');
var viewStudentListBtn = document.getElementById('viewStudentListBtn');
var viewGradeListBtn = document.getElementById('viewGradeListBtn');

// Get the <span> elements that close the modals
var gradeSpan = document.getElementsByClassName('close')[0];
var studentSpan = document.getElementsByClassName('close')[1];
var courseSpan = document.getElementsByClassName('close')[2];



//Get the id for it to pop up
var dashboard = document.getElementById('dashboard');
var viewGradeListPop = document.getElementById('grade');
var viewCourseListPop = document.getElementById('course-list');
var viewStudentListPop = document.getElementById('student-list');

// When the user clicks the button, open the modal 
addGradeBtn.onclick = function() {
    addGradeModal.style.display = "block";
}

addStudentBtn.onclick = function() {
    addStudentModal.style.display = "block";
}

addCourseBtn.onclick = function() {
    addCourseModal.style.display = "block";
}



//  Styles for grades section to pop
viewGradeListBtn.onclick = function() {
    viewGradeListPop.style.display = "block"; 
    viewCourseListPop.style.display = "none"; 
    viewStudentListPop.style.display = "none"; 
    dashboard.style.display = "none"; 
}
viewCourseListBtn.onclick = function() {
    viewCourseListPop.style.display = "block"; 
    viewGradeListPop.style.display = "none"; 
    viewStudentListPop.style.display = "none"; 
    dashboard.style.display = "none"; 
}
viewStudentListBtn.onclick = function() {
    viewStudentListPop.style.display = "block"; 
    viewCourseListPop.style.display = "none"; 
    viewGradeListPop.style.display = "none"; 
    dashboard.style.display = "none"; 
}
dashboardBtn.onclick = function() {
    dashboard.style.display = "block"; 
    viewStudentListPop.style.display = "none"; 
    viewCourseListPop.style.display = "none"; 
    viewGradeListPop.style.display = "none"; 
}

// When the user clicks on <span> (x), close the modal
gradeSpan.onclick = function() {
    addGradeModal.style.display = "none";
}
studentSpan.onclick = function() {
    addStudentModal.style.display = "none";
}
courseSpan.onclick = function() {
    addCourseModal.style.display = "none";
}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == addGradeModal) {
        addGradeModal.style.display = "none";
    } else if (event.target == addStudentModal) {
        addStudentModal.style.display = "none";
    } else if (event.target == addCourseModal) {
        addCourseModal.style.display = "none";
    }
}

function showSuccessAlert() {
    var alert = document.getElementById('successAlert');
    alert.style.display = 'block';

    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 3000);
}

function showRemoveAlert() {
    var alert = document.getElementById('removeAlert');
    alert.style.display = 'block';

    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 3000);
}