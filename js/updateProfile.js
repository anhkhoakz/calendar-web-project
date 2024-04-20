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
