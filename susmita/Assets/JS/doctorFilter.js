document.getElementById("specialization_id").addEventListener("change", function () {

    var specializationId = this.value;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            var doctors = JSON.parse(this.responseText);

            var output = "";

            if (doctors.length > 0) {

                for (var i = 0; i < doctors.length; i++) {

                    var availableDays = doctors[i].available_days.replaceAll(",", ", ");

                    var fee = parseInt(doctors[i].consultation_fee);

                    output += `
                        <div class="doctor-card">
                    `;

                    if (doctors[i].photo_path != "") {
                        output += `
                            <img src="../${doctors[i].photo_path}">
                        `;
                    } else {
                        output += `
                            <div class="no-image">No Image</div>
                        `;
                    }

                    output += `
                            <h3>${doctors[i].doctor_name}</h3>

                            <p>
                                <strong>Specialization:</strong>
                                ${doctors[i].specialization_name}
                            </p>

                            <p>
                                <strong>Fee:</strong>
                                ${fee} Tk
                            </p>

                            <p>
                                <strong>Available:</strong>
                                ${availableDays}
                            </p>

                            <a class="profile-btn"
                            href="../controller/doctorProfileController.php?doctor_id=${doctors[i].doctor_id}">
                                View Profile
                            </a>
                        </div>
                    `;
                }

            } else {

                output = "<p class='no-doctor'>No doctors found.</p>";
            }

            document.getElementById("doctorContainer").innerHTML = output;
        }
    };

    xhttp.open(
        "GET",
        "../controller/doctorFilterController.php?specialization_id=" + specializationId,
        true
    );

    xhttp.send();
});