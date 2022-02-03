String.prototype.trunc =
    function (n) {
        return this.substr(0, n - 1) + (this.length > n ? '&hellip;' : '');
    };

$(document).on("click", ".logout", logOut);
$(document).on("click", ".upvote", votePost);

function logOut() {
    $.ajax({
        url: "http://localhost/feedback/api.php",
        method: "GET",
        data: {
            type: "revokeSession",
            csrf_token: csrf_token
        },
        success: () => {
            window.location = site_url;
        }
    })
}


function votePost() {

    $(this).find("button").addClass("disabled");

    $.ajax({
        url: "http://localhost/feedback/api.php",
        method: "POST",
        data: {
            type: "votePost",
            csrf_token: csrf_token,
            post_id: $(this).data("id")
        },
        success: (data) => {

            // Remove disabled state
            $(this).find("button").removeClass("disabled");

            if (data.code && data.code === 401) {
                $("#mustSignInModal").modal("show");
            } else {

                // Toggle appearance
                if ($(this).data("voted")) {
                    $(this).data("voted", false);
                    $(this).find("p").text(parseInt($(this).find("p").text()) - 1)
                } else {
                    $(this).data("voted", true);
                    $(this).find("p").text(parseInt($(this).find("p").text()) + 1)

                }

                $(this).find("button").toggleClass("btn-primary btn-light");

            }

        }
    })


}