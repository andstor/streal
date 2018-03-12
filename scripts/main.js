//--Declaration of global variables.
//......

// Initiates the script.
function init() {
    // initiateSharedFunctions();
    evtListeners();
}


function evtListeners() {
    document.getElementById('hamburgerIcon').addEventListener('click', toggleDropdown);
}


function toggleDropdown() {
    var navbar = document.getElementById("navbar");

    if (!navbar.classList.contains('responsive')) {
        navbar.className += " responsive";
    } else {
        navbar.classList.remove('responsive');
    }
}


//Runs when the document is loaded. Initialises the script.
document.addEventListener('DOMContentLoaded', function () {
    "use strict";
    init();
});

