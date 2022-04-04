$("#toggle-sidebar").on("click", () => {
    $("#sidebar").toggle();
    $("#toggle-sidebar i").toggleClass("fa-right-from-line fa-left-from-line");
});

let currentFilter = [];
let currentSort = "";

// Hide all lazy load elements
$(".lz-load").hide();

function getBoard() {


    $.ajax({
        url: site_url + "/api.php",
        method: "GET",
        data: {
            type: "getBoard",
            csrf_token: csrf_token,
            board_slug: boardSlug,
        },
        success: (data) => {

            // If board is not found
            if (data.code && data.code === 204) {

                // Remove board holder
                $("#board-holder").remove();

                // Show 404 screen
                $(".container-fluid").append(`
                    <div class="card w-50 mx-auto p-4">
                        <div class="card-body">
                            <h5>${terms.board_not_found}</h5>
                            <p>${terms.board_not_found_msg}</p>
                            <p class="fw-bold">${terms.not_found_reason}</p>
                            <a href="${site_url}" class="btn btn-accent">${terms.return_home}</a>
                        </div>
                    </div>`);

            } else {

                // Set the board ID
                window.boardId = data.board_id;

                // Get board posts
                if (data.posts !== 0) {
                    getPosts(currentFilter, currentSort);
                } else {
                    // Remove elements
                    $(".btm-hold, #sidebar, #toggle-sidebar .ph-item").remove();

                    // Show no posts card
                    $("#posts-wrapper").append(`<div class="card mt-3">
                        <div class="card-body p-5">
                            <h1>🦄</h1>
                            <h5>No posts to be found here...</h5>
                            <p>It appears no posts have been published to this board yet.</p>
                            <button type="button" class="btn btn-accent btn-sm px-4 me-2">
                                <i class="far fa-plus"></i>
                                New post
                            </button>
                            <button type="button" class="btn btn-light border btn-sm px-4">
                                Go back
                            </button>
                        </div>
                    </div>`);


                }

                // Set board information
                document.title = data.name + " | " + site_name;
                $(".board-name").text(data.name);
                $(".board-desc").text(data.description);
                $(".board-icon").addClass("fa-" + data.icon);
                $(".board-posts").text(data.posts + (data.posts === 1 ? " " + terms.post : " " + terms.posts));
                $(".board-subscribers").text(data.subscribers + (data.subscribers === 1 ? " " + terms.subscriber : " " + terms.subscribers));
                $(".board-upvotes").text(data.upvotes + (data.upvotes === 1 ? " " + terms.upvote : " " + terms.upvotes));

                // Hide placeholders
                $(".ph-item").not("#post-wrapper .ph-item").hide();
                // Show lazy load elements
                $(".lz-load").show();

            }

        }
    })
}

function getPosts(filter, sort, offset = 0, loadMore = false) {


    if($("input[name=filter]:checked")) {
        filter = $("input[name=filter]:checked").map(function () {
            return this.value;
        }).get();
        console.log(filter);
    } else {
        filter = [];
        console.log("No filter selected");
    }

    $.ajax({
        url: site_url + "/api.php",
        method: "GET",
        data: {
            type: "getPostsByBoard",
            csrf_token: csrf_token,
            board_id: boardId,
            filter: filter,
            sort: sort,
            limit: 10,
            offset: offset
        },
        success: (data) => {

            $(document).ready(() => {

                // Hide placeholders
                $(".ph-item").hide();

                if (loadMore) {
                    // Remove disabled class
                    $(".loadMore").removeClass("disabled");
                    // Remove loading class
                    $(".loadMore i").removeClass("fa-spin").toggleClass("fa-plus fa-spinner-third");

                    // If no more posts
                    if (data.code && data.code === 204) {
                        // Hide load more btn
                        $(".btm-hold button").hide();
                        // Show no more posts message
                        $(".btm-hold p").show();
                    }

                }

                // If another full page available
                if (data.length === 10) {
                    // Show load more btn
                    $(".btm-hold .loadMore").show();
                    // Hide no more posts message
                    $(".btm-hold p").hide();
                } else {
                    // Hide load more btn
                    $(".btm-hold .loadMore").hide();
                    // Show no more posts message
                    $(".btm-hold p").show();
                }

                // Loop through all posts
                for (let i = 0; i < data.length; i++) {

                    // Append post to posts list
                    $(".posts-list").append(`<li class="list-group-item post-listing px-2 px-md-0">
                            <div class="d-flex">
                                <div class="upvote" data-id="${data[i].post_id}" data-voted="${data[i].hasUpvoted}">
                                    <button class="btn ${data[i].hasUpvoted ? "btn-accent" : "btn-light"} border px-3">
                                        <i class="fas fa-caret-up d-block"></i>
                                        <p class="mb-0">${data[i].upvotes}</p>
                                    </button>
                                </div>
                                <a href="${data[i].url}" class="text-reset text-decoration-none w-100">
                                    <p class="title clamp-1" style="width:90%">${data[i].title}</p>
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

$(document).on("change", "input[name='sort'], input[name='filter']", function () {
    currentSort = $(this).val();
    offset = 0;
    $(".posts-list").html("");
    getPosts(currentFilter, currentSort);


});

$(document).ready(() => {
    getBoard();
});

// Set initial offset
let offset = 10;
$(".loadMore").on("click", function () {
    // Add disabled class
    $(this).addClass("disabled");
    // Add loading class
    $(".loadMore i").addClass("fa-spin").toggleClass("fa-plus fa-spinner-third");
    // Get posts
    getPosts(currentFilter, currentSort, offset, true);
    // Increase offset
    offset += 10;
});