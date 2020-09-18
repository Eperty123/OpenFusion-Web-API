var ipc = require("ipc")

function OnResize() {
    var unity = document.getElementById('Unity_embed');
    unity.style.width = window.innerWidth + 'px';
    unity.style.height = window.innerHeight + 'px';
}

// Unity invoked MarkProgress method.
function MarkProgress(param) {
}

// Unity invoked MarkProgress method.
function MarkProgress(param) {}

function redirect(html) {
    ipc.send("exit", 0);
}

function HomePage(param) {
    ipc.send("exit", 0);
}

function PageOut(param) {
    ipc.send("exit", 0);
}

function updateSocialOptions(param) {
    ipc.send("exit", 0);
}

function PayPage(param) {
    ipc.send("exit", 0);
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}