function getUser() {
    $.ajax({
        url: site_url + "/api.php",
        method: "GET",
        data: {
            type: "getUser",
            csrf_token: csrf_token,
            user_slug: userSlug
        },
        success: (data) => {
            // If user is not found
            if (data.code && data.code === 204) {
                document.title = "User Not Found | " + site_name;
                // Remove holders
                $("#user-holder, .no-posts-holder, #loading").remove();
                // Show 404 holder
                $("#404-holder").show();
            } else {
                // Set the user ID
                window.user_id = data.user_id;
                // Remove holders
                $("#404-holder, #loading").remove();
                //Get user posts
                getPosts();
                // Set board information
                document.title = data.name + " | " + site_name;
                $(".user-name").text(data.name);
                $(".user-avatar").attr("src", data.avatar);
                $(".user-username").text("@" + data.username);
            }

        }
    })
}

function getPosts(offset = 0, loadMore = false) {
    $.ajax({
        url: site_url + "/api.php",
        method: "GET",
        data: {
            csrf_token: csrf_token,
            type: "getPostsByUser",
            user_id: window.user_id,
            limit: 10,
            offset: offset
        },
        success: (data) => {

            $(document).ready(() => {

                if (data.code && data.code === 204) {
                    $(".no-posts-holder").show();
                } else {
                    $(".no-posts-holder").remove();
                }

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
                                    <button class="btn ${data[i].hasUpvoted ? "btn-accent" : "btn-light"} border px-3">
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
                                    <p class="content small text-muted mt-2">${htmlEntities(data[i].content)}</p>
                                </a>
                            </div>
                        </li>`);
                }


            })

        }


    });
}

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