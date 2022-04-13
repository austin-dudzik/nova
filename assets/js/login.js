$("#login").on("submit", function (e) {

    $(this).find("button[type=submit]").prop("disabled", true).html("<i class='fa fa-spinner-third fa-spin'></i>");

    e.preventDefault();

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
                $(this).find("button[type=submit]").prop("disabled", false).html("Log in");
                if (data.code === 204) {
                    $("#msg").show().text("Sorry, the login details you entered are incorrect. Please try again.");
                } else {
                    $("#msg").hide();
                    window.location = site_url;
                }
            }
        })
    } else {
        $(this).find("button[type=submit]").prop("disabled", false).html("Log in");
        $("#msg").show().text("Both email and password are required fields.");
    }

    $("input").keypress(() => {
        $("#msg").hide();
    });

});