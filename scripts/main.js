function navbarFunction() {
    var x = document.getElementById("StrealNavbar");
    if (x.classList.contains('navbar')) {
        x.className += " responsive";
    } else {
        x.className = "navbar";
    }
}
