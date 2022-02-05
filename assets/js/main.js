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

function boldString(str, find) {
    let reg = new RegExp('('+find+')', 'gi');
    return str.replace(reg, '<strong>$1</strong>');
}

$("#searchInModal input").autocomplete({
    source: "http://localhost/feedback/api.php?type=getResults",
    appendTo: '#searchInModal'
}).autocomplete("instance")._renderItem = (ul, item) => {
    if (item.code && item.code === 204) {
        return $(`
    <div class="card rounded-0 border-0 px-4 py-3 text-dark"> 
        No results found
    </div>
`).appendTo(ul);
    } else {
        let orig = item.name;
        let term = $("#searchInModal input").val();
        return $(`
<a href="${item.url}" class="text-dark text-decoration-none">
    <div class="card rounded-0 border-0"> 
        <div class="border-bottom py-3 px-3">
            <i class="fas ${(item.type === "post" ? `fa-copy` : ``)} ${(item.type === "user" ? `fa-user` : ``)} ${(item.type === "board" ? `fa-columns-3` : ``)} me-2 text-muted align-middle"></i> <span class="d-inline-block align-middle" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:80%">${boldString(orig, term)}</span>
            <span class="float-end"><i class="far fa-arrow-right"></i></span>
    </div>
</a>
`).appendTo(ul);
    }
};

$("#openSearchModal").on("click", () => {
    $("#searchModal").modal("show");
    $("#searchInModal input").trigger("focus");
});

$('#searchModal input').on('blur', function () {
    var blurEl = $(this);
    setTimeout(function () {
        blurEl.focus()
    }, .5);
});

$(".input-icons input").on("focus", function () {
    $(this).prev("i").toggleClass("text-white text-dark");
});
$(".input-icons input").on("blur", function () {
    $(this).prev("i").toggleClass("text-white text-dark");
});