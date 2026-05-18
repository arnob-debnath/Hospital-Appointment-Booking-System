let buttons = document.querySelectorAll(".toggle-btn");

buttons.forEach(function(button){

    button.addEventListener("click", function(){

        let userId =
        this.getAttribute("data-user-id");

        let currentButton = this;

        let xhttp = new XMLHttpRequest();

        xhttp.open(
            "POST",
            "../controller/toggleUserStatusController.php",
            true
        );

        xhttp.setRequestHeader(
            "Content-type",
            "application/x-www-form-urlencoded"
        );

        xhttp.onload = function(){

            let data =
            JSON.parse(this.responseText);

            if(data.success){

                let statusText =
                document.getElementById(
                    "status-" + userId
                );

                if(data.new_status == 1){

                    statusText.innerHTML =
                    "Active";

                    currentButton.innerHTML =
                    "Deactivate";

                } else {

                    statusText.innerHTML =
                    "Inactive";

                    currentButton.innerHTML =
                    "Activate";
                }

            } else {

                alert(data.message);
            }
        };

        xhttp.send(
            "user_id=" + userId
        );

    });

});