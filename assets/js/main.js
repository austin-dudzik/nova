String.prototype.trunc =
    function (n) {
        return this.substr(0, n - 1) + (this.length > n ? '&hellip;' : '');
    };

$(document).on("click", ".logout", logOut);
$(document).on("click", ".upvote", votePost);

function logOut() {
    $.ajax({
        url: site_url + "/api.php",
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

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('body').tooltip({
        selector: '.a-tooltip'
    });
    $(".timeago").timeago();
})

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function votePost() {

    $(this).find("button").addClass("disabled");

    $.ajax({
        url: site_url + "/api.php",
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

                $(this).find("button").toggleClass("btn-accent btn-light");

            }

        }
    })


}

function boldString(str, find) {
    let reg = new RegExp('(' + find + ')', 'gi');
    return str.replace(reg, '<strong>$1</strong>');
}

$("#searchInModal input").autocomplete({
    source: site_url + "/api.php?type=getResults",
    appendTo: '#searchInModal',
    select: (e, ui) => {
        e.preventDefault();
        if (!ui.item.code) {
            window.location.href = ui.item.url;
        }
    },
    focus: (e) => {
        e.preventDefault();
    }
}).autocomplete("instance")._renderItem = (ul, item) => {
    if (item.code && item.code === 204) {
        return $(`<div class="card rounded-0 border-0 px-4 py-3 text-dark">No results found</div>`).appendTo(ul);
    } else {
        let orig = item.name;
        let term = $("#searchInModal input").val();
        return $(`
    <div class="card text-dark rounded-0 border-0" role="button"> 
        <div class="border-bottom py-3 px-3">
            <i class="fas ${(item.type === "post" ? `fa-copy` : ``)} ${(item.type === "user" ? `fa-user` : ``)} ${(item.type === "board" ? `fa-columns-3` : ``)} me-2 text-muted align-middle"></i> <span class="d-inline-block align-middle" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:80%">${boldString(orig, term)}</span>
            <span class="float-end"><i class="far fa-arrow-right"></i></span>
    </div>
`).appendTo(ul);
    }
}

$("#toggleSearch").on("click", function () {
    $("#searchHolder").slideToggle();
    $("#searchPage").focus();
});

$("#openSearch").on("click", () => {
    $("#searchModal").modal("show");
    $("#searchInModal input").trigger("focus");
});

$('#searchModal input').on('blur', function () {
    var blurEl = $(this);
    setTimeout(function () {
        blurEl.focus()
    }, .5);
});


$("#searchPage").autocomplete({
    source: site_url + "/api.php?type=getResults",
    appendTo: '#searchPageContainer',
    select: (e, ui) => {
        e.preventDefault();
        if (!ui.item.code) {
            window.location.href = ui.item.url;
        }
    },
    focus: (e) => {
        e.preventDefault();
    }
}).autocomplete("instance")._renderItem = (ul, item) => {
    if (item.code && item.code === 204) {
        return $(`<div class="card rounded-0 border-0 px-4 py-3 text-dark">No results found</div>`).appendTo(ul);
    } else {
        let orig = item.name;
        let term = $(".search").val();
        return $(`
    <div class="card text-dark rounded-0 border-0" role="button"> 
        <div class="border-bottom py-3 px-3">
            <i class="fas ${(item.type === "post" ? `fa-copy` : ``)} ${(item.type === "user" ? `fa-user` : ``)} ${(item.type === "board" ? `fa-columns-3` : ``)} me-2 text-muted align-middle"></i> <span class="d-inline-block align-middle" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:80%">${boldString(orig, term)}</span>
            <span class="float-end"><i class="far fa-arrow-right"></i></span>
    </div>
`).appendTo(ul);
    }
}

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}