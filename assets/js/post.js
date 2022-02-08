// Hide all lazy load elements
$(".lz-load").hide();

$(".toggle-co-area").click(function () {
    $("#comment-area, #leave-comment").toggle();
});


const simplemde = new SimpleMDE({element: $("#comment-area#editor")[0]});


$(document).ready(() => {

    $.ajax({
        url: site_url + "/api.php",
        method: "GET",
        data: {
            type: "getPost",
            csrf_token: csrf_token,
            post_slug: post_slug,
        },
        success: (data) => {

            // If post is not found
            if (data.code && data.code === 204) {

                // Remove post holder
                $("#post-holder").remove();

                $("#post-container").append(`<div class="row">
            <div class="col"></div>
            <div class="col-xl-6">
                <div class="card p-4">
                    <div class="card-body">
                        <h5>Post Not Found</h5>
                        <p>Sorry, we couldn't find a post located at the specified URL.</p>
                        <p class="fw-bold">It may have been moved, deleted, or may have never existed.</p>
                        <a href="${site_url}" class="btn btn-accent">Go back home</a>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>`);

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