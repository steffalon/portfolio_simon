function setdropdown() {
    document.getElementById("pmenu").classList.toggle("show");
}

window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var d = 0; d < dropdowns.length; d++) {
            var openDropdown = dropdowns[d];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

function mobiledrop() {
    document.getElementById("mmenu").classList.toggle("dshow");
}

window.onclick = function(e) {
    if (!e.target.matches('.mdropbtn')) {

        var dropdowns = document.getElementsByClassName("mobile-dropdown-content");
        for (var d = 0; d < dropdowns.length; d++) {
            var openDropdown = dropdowns[d];
            if (openDropdown.classList.contains('dshow')) {
                openDropdown.classList.remove('dshow');
            }
        }
    }
}
