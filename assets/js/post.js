// Hide all lazy load elements
$(".lz-load").hide();

$(".toggle-co-area").click(function () {
    $("#comment-area, #leave-comment").toggle();
});


const simplemde = new SimpleMDE({element: $("#comment-area#editor")[0]});


$(document).ready(() => {

    $.ajax({
        url: "http://localhost/feedback/api.php",
        method: "GET",
        data: {
            type: "getPost",
            csrf_token: csrf_token,
            post_slug: post_slug,
        },
        success: (data) => {

            // If post is not found
            if (data.code && data.code === 204) {
                $("#404-holder").show();
                $("#post-holder").remove();
            } else {

                $(".upvote").data("id", data.post_id).data("voted", data.hasUpvoted);
                $(".upvote button").addClass(data.hasUpvoted ? "btn-primary" : "btn-light");
                $(".upvote p").text(data.upvotes);

                window.post_id = data.post_id;

                // Set page title
                document.title = data.title;

                // Set post title
                $(".post-title").text(data.title);
                // Set board name
                $(".post-board").text(data.board.name).attr("href", data.board.url);

                if (status) {
                    // Display status
                    $("#post-status").text(status.name).attr({
                        style: "color:" + status.color,
                        href: status.slug
                    });
                }

                $(".post-content").html(data.content);

                $("#post-wrapper .ph-item").hide();
                $(".lz-load").show();

            }

        }

    });

});

$(document).on("click", ".upvote", function () {

    $(this).find("button").addClass("disabled");

    $.ajax({
        url: "http://localhost/feedback/api.php",
        method: "POST",
        data: {
            type: "votePost",
            csrf_token: csrf_token,
            post_id: post_id,
        },
        success: (data) => {

            // Remove disabled state
            $(this).find("button").removeClass("disabled");

            if (data.code && data.code === 401) {
                //$("#mustSignInModal").modal("show");
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


})