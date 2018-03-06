function navbarFunction() {
    var x = document.getElementById("strealNavbar");
    if (x.className === "navbar") {
        x.className += " responsive";
    } else {
        x.className = "navbar";
    }
}
