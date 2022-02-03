String.prototype.trunc =
    function (n) {
        return this.substr(0, n - 1) + (this.length > n ? '&hellip;' : '');
    };

$(document).on("click", ".logout", logOut);

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