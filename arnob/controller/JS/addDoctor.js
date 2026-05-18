function addDoctor() {
    let name             = document.getElementById("doc_name").value;
    let email            = document.getElementById("doc_email").value;
    let password         = document.getElementById("doc_password").value;
    let specializationId = document.getElementById("doc_specialization_id").value;
    let bio              = document.getElementById("doc_bio").value;
    let fee              = document.getElementById("doc_fee").value;
    let photo            = document.getElementById("doc_photo").files[0];

    let days = [];
    document.querySelectorAll(".day-checkbox:checked").forEach(function (cb) {
        days.push(cb.value);
    });

    let formData = new FormData();

    formData.append("action",            "add");
    formData.append("name",              name);
    formData.append("email",             email);
    formData.append("password",          password);
    formData.append("specialization_id", specializationId);
    formData.append("bio",               bio);
    formData.append("fee",               fee);

    days.forEach(function (day) {
        formData.append("available_days[]", day);
    });

    if (photo) {
        formData.append("photo", photo);
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("doc_response").innerHTML = this.responseText;
            loadDoctors();
        }
    };

    xhttp.open("POST", "../Controller/DoctorHandler.php", true);
    xhttp.send(formData);
}
