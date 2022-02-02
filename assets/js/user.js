// Hide all lazy load elements
//$(".lz-load").hide();
$(".ph-item").hide();

function getUser() {

    $.ajax({
        url: "http://localhost/feedback/api.php",
        method: "GET",
        data: {
            type: "getUser",
            csrf_token: csrf_token,
            user_slug: userSlug
        },
        success: (data) => {


            // If board is not found
            if (data.code && data.code === 204) {
                // Show 404 holder
                $("#404-holder").show();
                // Remove board holder
                $("#board-holder").remove();
            } else {

                // Set the user ID
                window.user_id = data.user_id;

                // Remove 404 holder
                $("#404-holder").remove();

                //Get user posts
                    getPosts();
                    $(".no-posts-holder").remove();

                // Set board information
                document.title = data.name + " | " + site_name;
                // $(".board-name").text(data.name);
                // $(".board-desc").text(data.description);
                $(".user-name").text(data.name);
                $(".user-avatar").attr("src", data.avatar);
                $(".user-username").text("@" + data.username);
                $(".board-posts").text(data.posts + (data.posts === 1 ? " post" : " posts"));
                $(".board-subscribers").text(data.subscribers + (data.subscribers === 1 ? " subscriber" : " subscribers"));
                $(".board-upvotes").text(data.upvotes + (data.upvotes === 1 ? " upvote" : " upvotes"));

                // Hide placeholders
                $(".ph-item").hide();
                // Show lazy load elements
                $(".lz-load").show();

            }

        }
    })
}

function getPosts(offset = 0, loadMore = false) {
    $.ajax({
        url: "http://localhost/feedback/api.php",
        method: "GET",
        data: {
            csrf_token: csrf_token,
            type: "getPostsByUser",
            user_id: user_id,
            limit: 10,
            offset: offset
        },
        success: (data) => {

            $(document).ready(() => {

                if (loadMore) {
                    $(".loadMore").removeClass("disabled");
                    $(".loadMore i").removeClass("fa-spin").toggleClass("fa-plus fa-spinner-third");

                    if (data.code && data.code === 204) {
                        $(".btm-hold button").hide();
                        $(".btm-hold p").show();
                    }

                }

                if (data.length === 10) {
                    $(".btm-hold .loadMore").show();
                    $(".btm-hold p").hide();
                } else {
                    $(".btm-hold .loadMore").hide();
                    $(".btm-hold p").show();
                }

                for (let i = 0; i < data.length; i++) {

                    $(".posts-list").append(`<li class="list-group-item post-listing">
                            <div class="d-flex">
                                <div class="upvote" data-id="${data[i].post_id}" data-voted="${data[i].hasUpvoted}">
                                    <button class="btn ${data[i].hasUpvoted ? "btn-primary" : "btn-light"} border px-3">
                                        <i class="fas fa-caret-up d-block"></i>
                                        <p class="mb-0">${data[i].upvotes}</p>
                                    </button>
                                </div>
                                <a href="${data[i].url}" class="text-reset text-decoration-none w-100">
                                    <p class="title">${data[i].title}</p>
                                    <span class="float-end small">
                                        <i class="far fa-message me-1 text-muted"></i> ${data[i].comments}
                                    </span>
                                    <div class="clearfix"></div>
                    ${data[i].status ? `<p class="status small mt-2 mb-0">
                                        <span class="text-uppercase">
                                            <i class="fas fa-circle me-1" style="color:${data[i].status.color}"></i> ${data[i].status.name}
                                        </span>
                                    </p>` : ''}
                                    <p class="content small text-muted mt-2">${data[i].content}</p>
                                </a>
                            </div>
                        </li>`);
                }


            })

        }


    });
}

$(document).on("click", ".upvote", function () {

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
                    $(".board-upvotes").text((parseInt($(".board-upvotes").text()) - 1) + " upvotes");
                } else {
                    $(this).data("voted", true);
                    $(this).find("p").text(parseInt($(this).find("p").text()) + 1)
                    $(".board-upvotes").text((parseInt($(".board-upvotes").text()) + 1) + " upvotes");

                }

                $(this).find("button").toggleClass("btn-primary btn-light");

            }

        }
    })


})


$(document).ready(() => {
    getUser();
});

let offset = 10;
$(".loadMore").on("click", function () {
    $(this).addClass("disabled");
    $(".loadMore i").addClass("fa-spin").toggleClass("fa-plus fa-spinner-third");
    getPosts(offset, true);
    offset += 10;
});