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

                $("#loading").hide();
                $("#post-not-found").show();
                $("#page").remove();


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

                        // If there are voters...
                        if(data.length) {
                            // Loop through all voters...
                            for (let i = 0; i < data.length; i++) {
                                // Append voter to voter list...
                                $("#voterList").append(`<a href="${data[i].url}" class="a-tooltip" data-toggle="tooltip" data-bs-placement="top" title="${data[i].name}"><img src="${data[i].avatar}" class="rounded-circle me-2" style="width:30px;height:30px" alt="${data[i].name}"></a>`);
                            }
                        } else {
                            $("#voterList").append(`<p class="small text-muted">No one has voted yet!</p>`);
                        }

                        $("#loading").hide();
                        $("#post-not-found").hide();
                        $("#page").show();

                    }
                });

            }

        }

    });

});