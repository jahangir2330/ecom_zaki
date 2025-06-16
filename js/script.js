function loadCaptcha(id, type) {
    fetch(`captcha.php?type=${type}`)
        .then(res => res.text())
        .then(text => document.getElementById(id).innerText = text);
}

document.addEventListener("DOMContentLoaded", () => {
    loadCaptcha("captcha-login-text", "captcha_login");
    loadCaptcha("captcha-signup-text", "captcha_signup");
});