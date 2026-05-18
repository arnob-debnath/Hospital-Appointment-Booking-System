function loadDoctors() {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("doctorTableBody").innerHTML = this.responseText;
            loadDoctorStats();
        }
    };

    xhttp.open("POST", "../Controller/DoctorHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=fetch");
}


function loadSpecializationDropdown(selectId, selectedId) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(selectId).innerHTML = this.responseText;

            if (selectedId) {
                document.getElementById(selectId).value = selectedId;
            }
        }
    };

    xhttp.open("POST", "../Controller/DoctorHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=fetchSpecializations");
}


function loadDoctorStats() {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let stats = JSON.parse(this.responseText);

            stats.forEach(function (doc) {
                let cells = document.querySelectorAll(".appt-count[data-id='" + doc.id + "']");

                cells.forEach(function (cell) {
                    cell.innerHTML = doc.appointment_count;
                });
            });
        }
    };

    xhttp.open("POST", "../Controller/DoctorHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=fetchStats");
}
