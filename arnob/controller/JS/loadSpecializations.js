function loadSpecializations() {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("specializationTableBody").innerHTML = this.responseText;
        }
    };

    xhttp.open("POST", "../Controller/SpecializationHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=fetch");
}
