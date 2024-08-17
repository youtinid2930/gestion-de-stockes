// public/js/custom.js
document.addEventListener("DOMContentLoaded", function() {
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebar-button");
    let homeSection = document.querySelector(".home-section");

    sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        homeSection.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.querySelector('i').classList.replace("bx-menu", "bx-menu-alt-right");
        } else {
            sidebarBtn.querySelector('i').classList.replace("bx-menu-alt-right", "bx-menu");
        }
    };
});
