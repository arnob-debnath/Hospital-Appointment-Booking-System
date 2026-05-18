function openEditDoctor(id) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let doc = JSON.parse(this.responseText);

            if (!doc) {
                alert("Doctor not found");
                return;
            }

            document.getElementById("edit_doctor_id").value    = doc.id;
            document.getElementById("edit_user_id").value      = doc.user_id;
            document.getElementById("edit_doc_name").value     = doc.name;
            document.getElementById("edit_doc_email").value    = doc.email;
            document.getElementById("edit_doc_password").value = "";
            document.getElementById("edit_doc_bio").value      = doc.bio      || "";
            document.getElementById("edit_doc_fee").value      = doc.consultation_fee || "";

            loadSpecializationDropdown("edit_doc_specialization_id", doc.specialization_id);

            let checkedDays = doc.available_days ? doc.available_days.split(",") : [];

            document.querySelectorAll(".edit-day-checkbox").forEach(function (cb) {
                cb.checked = checkedDays.includes(cb.value);
            });

            document.getElementById("editDoctorSection").style.display = "block";
        }
    };

    xhttp.open("POST", "../Controller/DoctorHandler.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=fetchOne&id=" + id);
}


function updateDoctor() {
    let doctorId         = document.getElementById("edit_doctor_id").value;
    let userId           = document.getElementById("edit_user_id").value;
    let name             = document.getElementById("edit_doc_name").value;
    let email            = document.getElementById("edit_doc_email").value;
    let password         = document.getElementById("edit_doc_password").value;
    let specializationId = document.getElementById("edit_doc_specialization_id").value;
    let bio              = document.getElementById("edit_doc_bio").value;
    let fee              = document.getElementById("edit_doc_fee").value;
    let photo            = document.getElementById("edit_doc_photo").files[0];

    let days = [];
    document.querySelectorAll(".edit-day-checkbox:checked").forEach(function (cb) {
        days.push(cb.value);
    });

    let formData = new FormData();

    formData.append("action",            "update");
    formData.append("doctor_id",         doctorId);
    formData.append("user_id",           userId);
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
            document.getElementById("editDoctorSection").style.display = "none";
            loadDoctors();
        }
    };

    xhttp.open("POST", "../Controller/DoctorHandler.php", true);
    xhttp.send(formData);
}


function cancelEditDoctor() {
    document.getElementById("editDoctorSection").style.display = "none";
}
