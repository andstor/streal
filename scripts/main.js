//--Declaration of global variables.
//......

// Initiates the script.
function init() {
    // initiateSharedFunctions();
    evtListeners();
}


function evtListeners() {
    document.getElementById('hamburgerIcon').addEventListener('click', toggleDropDown);

    console.log("kkiifif");

    document.getElementsByClassName('grid-menu')[0].querySelectorAll('li > a').forEach((e, i) => {
        if (i === 0) {return}
        e.addEventListener('mouseover', () => {
            hoverNavbarTab(e, true);
        }, false);

        e.addEventListener('mouseleave', () => {
            hoverNavbarTab(e, false);
        }, false);


    });
}


function toggleDropDown() {
    const navbar = document.getElementById("navbar");

    if (!navbar.classList.contains('responsive')) {
        navbar.className += " responsive";
    } else {
        navbar.classList.remove('responsive');
    }
}

function hoverNavbarTab(e, isHovered) {
    if (isHovered === true) {
        e.style.backgroundColor = "#62bfde";
        document.getElementsByClassName('navbar-background')[0].style.borderColor = "#62bfde";
    } else{
        e.style.backgroundColor = "#fa4b89";
        document.getElementsByClassName('navbar-background')[0].style.borderColor = "#fa4b89";
    }


}

//Runs when the document is loaded. Initialises the script.
document.addEventListener('DOMContentLoaded', function () {
    "use strict";
    init();
});
