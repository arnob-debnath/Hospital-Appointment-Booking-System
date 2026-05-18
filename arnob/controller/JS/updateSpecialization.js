function openEditSpecialization(id, currentName) {
    document.getElementById("spec_edit_id").value   = id;
    document.getElementById("spec_edit_name").value = currentName;
    document.getElementById("editSpecSection").style.display = "block";
}

function updateSpecialization() {
    let id   = document.getElementById("spec_edit_id").value;
    let name = document.getElementById("spec_edit_name").value;

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("spec_response").innerHTML = this.responseText;
            document.getElementById("editSpecSection").style.display = "none";
            loadSpecializations();
        }
    };

    xhttp.open("POST", "../Controller/SpecializationHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=update&id=" + id + "&name=" + encodeURIComponent(name));
}

function cancelEditSpec() {
    document.getElementById("editSpecSection").style.display = "none";
}
