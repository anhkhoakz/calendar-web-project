function editProfile() {
    var button = document.getElementById("editButton");
    var currentEmailElement = document.getElementById("currentEmail");
    var emailInput = document.getElementById("emailInput");

    if (button.innerText === "Edit") {
        button.innerText = "Save";

        currentEmailElement.style.display = "none";
        emailInput.style.display = "inline";
    } else {
        document.getElementById("editForm").submit();
        button.innerText = "Edit";

        currentEmailElement.style.display = "inline";
        emailInput.style.display = "none";
    }
}

function submitHiddenForm() {
    let form = document.getElementById("hidden-form");

    if (form) {
        form.submit();
    }
}

window.addEventListener("DOMContentLoaded", () => {
    checkAndSubmitForm();

    setInterval(checkAndSubmitForm, 1000);
});

function checkAndSubmitForm() {
    let currentUrl = window.location.href;

    if (currentUrl.endsWith("/profile.php")) {
        submitHiddenForm();
    }
}
