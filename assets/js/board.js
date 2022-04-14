let currentFilter = [];
let currentSort = "";

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
                $("#loading").remove();
                $("#page").remove();
                $("#board-not-found").show();
            } else {

                // Set the board ID
                window.boardId = data.board_id;

                // Get board posts
                if (data.posts !== 0) {
                    getPosts(currentFilter, currentSort);
                } else {
                    // Remove elements
                    $(".btm-hold, #sidebar, #toggle-sidebar").remove();

                    // Show no posts card
                    $("#posts-wrapper").append(`
                        <div class="p-4">
                        <i class="far fa-comments fa-2x text-muted mb-3"></i>
                            <h6>Looks like there's no feedback yet</h6>
                            <p>Once someone offers a suggestion, it'll appear here.</p>
                        </div>
                    `);


                }

                // Set board information
                document.title = data.name + " | " + site_name;
                $(".board-name").text(data.name);
                $(".board-desc").text(data.description);
                $(".board-icon").addClass("fa-" + data.icon);
                $(".board-visibility").html((data.visibility === 2 ? '<i class="fas fa-lock me-1"></i> Private' : '') + (data.visibility === 0 ? '<i class="fas fa-eye-slash me-1"></i> Unlisted' : ''));

                // Set edit board details
                $("#board_name").val(data.name);
                $("#board_icon").val(data.icon);
                $("#board_slug").val(data.slug);
                $("#board_desc").val(data.description);

                $("#loading").hide();
                $("#page").show();

            }

        }
    })
}

function getPosts(filter, sort, offset = 0, loadMore = false) {


    if ($("input[name=filter]:checked")) {
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

$("#visibility input").on("change", function () {
    if ($("#private").is(":checked")) {
        $("#rules-section").show();
    } else {
        $("#rules-section").hide();
    }
});