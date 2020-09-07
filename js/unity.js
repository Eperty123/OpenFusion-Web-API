function OnResize() {
    var unity = document.getElementById('Unity_embed');
    unity.style.width = window.innerWidth + 'px';
    unity.style.height = window.innerHeight + 'px';
}

// Unity invoked MarkProgress method.
function MarkProgress(param) {
}

//allows us to skip the login screen
function authDoCallback(param) {
    var cookie = readCookie("FFLogin");
    var account = JSON.parse(cookie);

    var unity = document.getElementById('Unity_embed');
    unity.SendMessage("GlobalManager", "SetTEGid", account["username"]);
    unity.SendMessage("GlobalManager", "SetAuthid", account["password"]);
    unity.SendMessage("GlobalManager", "DoAuth", 0);
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