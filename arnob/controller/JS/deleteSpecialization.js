function deleteSpecialization(id) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("spec_response").innerHTML = this.responseText;
            loadSpecializations();
        }
    };

    xhttp.open("POST", "../Controller/SpecializationHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=delete&id=" + id);
}
