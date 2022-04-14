$("#msg").hide();

let isValid = true;

$("#register").submit((event) => {
    event.preventDefault();

    if (!isValid) {
        return false;
    } else {

        $("#register button").addClass("disabled");

        $("#msg").hide();

        $.ajax({
            url: site_url + "/api.php",
            method: "POST",
            data: {
                type: "createUser",
                csrf_token: csrf_token,
                firstName: $("#firstName").val(),
                lastName: $("#lastName").val(),
                username: $("#username").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                confirm_password: $("#confirm_password").val()
            },
            success: (data) => {

                if (data.code && data.code === 406) {
                    isValid = false;
                    $("#msg").show().text(data.message);
                } else if (data.code && data.code === 200) {
                    isValid = true;
                    $("#msg").hide();
                    window.location = window.location;
                }

            }
        })

    }

    $("input").on("input", () => {
        isValid = true;
        $("#msg").hide();
        $("#register button").removeClass("disabled");
    });

});