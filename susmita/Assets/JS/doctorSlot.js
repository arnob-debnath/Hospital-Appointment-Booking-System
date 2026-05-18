var dateButtons = document.getElementsByClassName("date-btn");

for (var i = 0; i < dateButtons.length; i++) {

    dateButtons[i].addEventListener("click", function () {

        var selectedDate = this.getAttribute("data-date");
        var doctorId = this.getAttribute("data-doctor");

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse(this.responseText);

                var output = "";

                if (response.slots.length > 0) {

                    for (var i = 0; i < response.slots.length; i++) {

                        output += `
                            <a class="slot-btn"
                            href="../controller/bookAppointmentController.php?doctor_id=${doctorId}&date=${selectedDate}&time=${response.slots[i]}">
                                ${response.slots[i]}
                            </a>
                        `;
                    }

                } else {

                    output = "<p class='no-slot'>No slots available for this date.</p>";
                }

                document.getElementById("slotContainer").innerHTML = output;
            }
        };

        xhttp.open(
            "GET",
            "../controller/doctorSlotController.php?doctor_id=" + doctorId + "&date=" + selectedDate,
            true
        );

        xhttp.send();
    });
}