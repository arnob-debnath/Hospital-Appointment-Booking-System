var cancelButtons = document.getElementsByClassName("cancel-btn");

for (var i = 0; i < cancelButtons.length; i++) {

    cancelButtons[i].addEventListener("click", function () {

        var appointmentId = this.getAttribute("data-id");

        var confirmCancel = confirm("Are you sure you want to cancel this appointment?");

        if (!confirmCancel) {
            return;
        }

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse(this.responseText);

                var messageBox = document.getElementById("messageBox");

                if (response.success) {

                    messageBox.innerHTML =
                        "<p class='success-message'>" + response.message + "</p>";

                    var card =
                        document.getElementById("appointment-" + appointmentId);

                    var badge =
                        card.getElementsByClassName("status-badge")[0];

                    badge.innerHTML = "Cancelled";
                    badge.className = "status-badge cancelled";

                    var button =
                        card.getElementsByClassName("cancel-btn")[0];

                    button.remove();

                } else {

                    messageBox.innerHTML =
                        "<p class='error-message'>" + response.message + "</p>";
                }
            }
        };

        xhttp.open(
            "POST",
            "../controller/cancelAppointmentController.php",
            true
        );

        xhttp.setRequestHeader(
            "Content-type",
            "application/x-www-form-urlencoded"
        );

        xhttp.send(
            "appointment_id=" + appointmentId
        );
    });
}