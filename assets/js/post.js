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
                $(".upvote button").addClass(data.hasUpvoted ? "btn-accent" : "btn-light");
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