// Get the modals
var addGradeModal = document.getElementById('addGradeModal');
var addStudentModal = document.getElementById('addStudentModal');
var addCourseModal = document.getElementById('addCourseModal');
var assignToAllModal = document.getElementById('assignToAllModal');
var viewGradeCoursesModal = document.getElementById('viewGradeCoursesModal');

// Get the buttons that open the modals
var addGradeBtn = document.getElementById('addGradeBtn');
var viewGradeCoursesBtn = document.getElementById('viewGradeCoursesBtn');
var addStudentBtn = document.getElementById('addStudentBtn');
var assignToAllBtn = document.getElementById('assignToAllBtn');
var addCourseBtn = document.getElementById('addCourseBtn');
var dashboardBtn = document.getElementById('dashboardBtn');
var viewCourseListBtn = document.getElementById('viewCourseListBtn');
var viewStudentListBtn = document.getElementById('viewStudentListBtn');

// Get the <span> elements that close the modals
var spans = document.getElementsByClassName('close');

// Assign click event to each span element
for (var i = 0; i < spans.length; i++) {
    spans[i].onclick = function() {
        this.parentElement.parentElement.style.display = "none";
    }
}

// Get the id for it to pop up
var dashboard = document.getElementById('dashboard');
var viewGradeListPop = document.getElementById('grade');
var viewCourseListPop = document.getElementById('course-list');
var viewStudentListPop = document.getElementById('student-list');
var editGradePop = document.getElementById('edit-grade');

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

assignToAllBtn.onclick = function() {
    assignToAllModal.style.display = "block";
}

viewGradeCoursesBtn.onclick = function() {
    viewGradeCoursesModal.style.display = "block";
}

// Styles for grades section to pop
viewCourseListBtn.onclick = function() {
    viewCourseListPop.style.display = "block"; 
    viewGradeListPop.style.display = "none"; 
    viewStudentListPop.style.display = "none"; 
    dashboard.style.display = "none"; 
    editGradePop.style.display ="none";
}

viewStudentListBtn.onclick = function() {
    viewStudentListPop.style.display = "block"; 
    viewCourseListPop.style.display = "none"; 
    viewGradeListPop.style.display = "none"; 
    dashboard.style.display = "none";
    editGradePop.style.display ="none"; 
}

dashboardBtn.onclick = function() {
    dashboard.style.display = "block"; 
    viewStudentListPop.style.display = "none"; 
    viewCourseListPop.style.display = "none"; 
    viewGradeListPop.style.display = "block"; 
    editGradePop.style.display ="none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == addGradeModal) {
        addGradeModal.style.display = "none";
    } else if (event.target == addStudentModal) {
        addStudentModal.style.display = "none";
    } else if (event.target == addCourseModal) {
        addCourseModal.style.display = "none";
    } else if (event.target == assignToAllModal) {
        assignToAllModal.style.display = "none";
    } else if (event.target == viewGradeCoursesModal) {
        viewGradeCoursesModal.style.display = "none";
    }else if(event.target == document.getElementById('help-modal')) {
        document.getElementById('help-modal').style.display = 'none';
    }
}


// Functions to show alerts
function showSuccessAlert() {
    var alert = document.getElementById('successAlert');
    alert.style.display = 'block';

    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 2000);
}
function showUpdatedAlert() {
    var alert = document.getElementById('updatedAlert');
    alert.style.display = 'block';
    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 2000);
}

function passSuccessAlert() {
    var alert = document.getElementById('passSuccessAlert');
    alert.style.display = 'block';

    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 2000);
}

function showRemoveAlert() {
    var alert = document.getElementById('removeAlert');
    alert.style.display = 'block';

    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 2000);
}

function showNothingFoundAlert() {
    var alert = document.getElementById('nothingAlert');
    alert.style.display = 'block';

    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 2000);
}

function showNoPermAlert() {
    var alert = document.getElementById('noPermAlert');
    alert.style.display = 'block';

    // Hide the alert after 3 seconds
    setTimeout(function() {
        alert.style.display = 'none';
    }, 2000);
}
document.getElementById('help-icon').onclick = function() {
    document.getElementById('help-modal').style.display = 'block';
}
document.getElementById('cancel-button').onclick = function() {
    window.location.href = "dashboard.php";
}

