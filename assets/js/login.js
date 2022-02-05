$("#msg").hide();

$("#submitLogin").on("click", function () {

    if ($("#email").val() || $("#password").val()) {

        $("#msg").hide();

        $.ajax({
            url: site_url + "/api.php",
            method: "POST",
            data: {
                type: "authenticateUser",
                csrf_token: csrf_token,
                email: $("#email").val(),
                password: $("#password").val()
            },
            success: (data) => {
                if (data.code === 204) {
                    $("#msg").show().text("Sorry, the login details you entered are incorrect. Please try again.");
                } else {
                    $("#msg").hide();
                    window.location = site_url;
                }
            }
        })
    } else {
        $("#msg").show().text("Both email and password are required fields.");
    }

    $("input").keypress(() => {
        $("#msg").hide();
    });

});