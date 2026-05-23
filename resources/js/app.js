import './bootstrap';
import '../css/dashboard/assets/js/bootstrap.bundle.min.js';
import 'jquery';
import 'pace-js';
import '../css/dashboard/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css';
import '../css/dashboard/assets/plugins/metismenu/metisMenu.min.css';
import 'metismenu';

// import '../css/login.css';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

$(function () {
    $("#show_hide_password a").on("click", function (event) {
        event.preventDefault();
        const input = $('#show_hide_password input');
        const icon = $('#show_hide_password i');
        if (input.attr("type") === "text") {
            input.attr('type', 'password');
            icon.addClass("bi-eye-slash-fill").removeClass("bi-eye-fill");
        } else {
            input.attr('type', 'text');
            icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
        }
    });
});
