// Hide all lazy load elements
$(".lz-load").hide();

new SimpleMDE({element: $("#comment-area#editor")[0]});
$(".toggle-co-area").click(function () {
    $("#comment-area, #leave-comment").toggle();
});

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

                let options = { year: 'numeric', month: 'long', day: 'numeric' };
                let post_date  = new Date(data.created_at);

                $(".post-date").text(post_date.toLocaleDateString("en-US", options));

                // Set post title
                $(".post-title").text(data.title);
                // Set board name
                $(".post-board").text(data.board.name).attr("href", data.board.url);

                if (data.status) {
                    // Display status
                    $("#post-status").text(data.status.name).attr({
                        style: "color:" + data.status.color,
                        href: data.status.slug
                    });
                }

                let otherUpvotes = (data.upvotes - 10);

                if(otherUpvotes > 0) {
                    $(".other-upvotes").text('+' + otherUpvotes);
                } else {
                    $(".other-upvotes").hide();
                }

                $(".post-content").html(data.content);

                $("#post-wrapper .ph-item").hide();
                $(".lz-load").show();


                $.ajax({
                    url: site_url + "/api.php",
                    method: "GET",
                    data: {
                        type: "getVoters",
                        csrf_token: csrf_token,
                        post_id: data.post_id,
                        limit: 10
                    },
                    success: (data) => {
                        if(data.length) {
                            // Loop through all voters
                            for (let i = 0; i < data.length; i++) {
                                // Append voter to voter list
                                $("#voterList").append(`<img src="${data[i].avatar}" class="rounded-circle me-2" style="width:30px;height:30px">`);
                            }
                        } else {
                            $("#voterList").append(`<p class="small text-muted">No one has voted yet!</p>`);
                        }
                    }
                });

            }

        }

    });

});