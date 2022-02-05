$("#toggle-sidebar").on("click", () => {
    $("#sidebar").toggle();
    $("#toggle-sidebar i").toggleClass("fa-right-from-line fa-left-from-line");
});

// Hide all lazy load elements
$(".lz-load").hide();

function getBoard() {

    $.ajax({
        url: "http://localhost/feedback/api.php",
        method: "GET",
        data: {
            type: "getBoard",
            csrf_token: csrf_token,
            board_slug: boardSlug
        },
        success: (data) => {

            // If board is not found
            if (data.code && data.code === 204) {
                // Show 404 holder
                $("#404-holder").show();
                // Remove board holder
                $("#board-holder").remove();
            } else {

                // Set the board ID
                window.boardId = data.board_id;

                // Remove 404 holder
                $("#404-holder").remove();

                // Get board posts
                if (data.posts !== 0) {
                    getPosts();
                    $(".no-posts-holder").remove();
                } else {
                    // Show no posts holder
                    $(".btm-hold, #sidebar, #toggle-sidebar").remove();
                }

                // Set board information
                document.title = data.name + " | " + site_name;
                $(".board-name").text(data.name);
                $(".board-desc").text(data.description);
                $(".board-icon").addClass("fa-" + data.icon);
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
            type: "getPostsByBoard",
            csrf_token: csrf_token,
            board_id: boardId,
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
                                    <p class="content small text-muted mt-2">${data[i].content}</p>
                                </a>
                            </div>
                        </li>`);
                }


            })

        }


    });
}


$(document).ready(() => {
    getBoard();
});

let offset = 10;
$(".loadMore").on("click", function () {
    $(this).addClass("disabled");
    $(".loadMore i").addClass("fa-spin").toggleClass("fa-plus fa-spinner-third");
    getPosts(offset, true);
    offset += 10;
});