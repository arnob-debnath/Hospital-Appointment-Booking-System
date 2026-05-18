function toggleDoctor(id, isActive) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("doc_response").innerHTML = this.responseText;
            loadDoctors();
        }
    };

    xhttp.open("POST", "../Controller/DoctorHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=toggleStatus&id=" + id + "&is_active=" + isActive);
}
