$(document).ready(() => {
    getBoards();
    getStatuses();
})

function getBoards() {
    $.ajax({
        url: site_url + "/api.php",
        method: "GET",
        data: {
            type: "getBoards",
            csrf_token: csrf_token
        },
        success: (data) => {

            if(!data.length) {
                $("#boards-container").append(`
                <div class="col-md-12">
                 <p class="text-muted">` + "No boards here, yet." + `</p>
                    </div>`);
            } else {

                for (let i = 0; i < data.length; i++) {

                    if (feed_type === 1) {
                        $("#boards-container").append(`
                        <div class="col-12 col-md-3 col-xl-3 mb-3">
                        <a href="${data[i].url}" class="text-reset text-decoration-none">
            <div class="card" style="background:#efefef">
                <div class="card-body text-center">
                    <i class="fas fa-${data[i].icon} fa-2x d-block mb-2 text-accent"></i>
                    <p class="mb-0 clamp-1" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].name}</p>
                    <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">${data[i].posts} ${terms.posts}</small>
                </div>
            </div>
            </a>
        </div>`);
                    } else if (feed_type === 2) {

                        $("#boards-container").append(`
                        <div class="col-12 col-md-4 col-xl-3 mb-3">
                        <a href="${data[i].url}" class="text-reset text-decoration-none">
                <div class="card" style="background:#efefef">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="my-auto">
                                <i class="fas fa-${data[i].icon} fa-2x d-block mb-2 text-accent"></i>
                            </div>
                            <div class="ps-3">
                                <p class="mb-0 clamp-1" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].name}</p>
                                <small
                                    style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">${data[i].posts} ${terms.posts}</small>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>`);
                    } else if (feed_type === 3) {

                        $("#boards-container").append(`
                        <div class="col-12 col-md-4 col-xl-3 mb-3">
            <div class="card" style="background:#efefef">
            <a href="${data[i].url}" class="text-reset text-decoration-none">
                <div class="card-body py-2">
                    <div class="d-flex mt-1">
      
                        <div class="my-auto">
                            <i class="fas fa-${data[i].icon} fa-2x d-block mb-2 text-accent" style="font-size:20px"></i>
                        </div>
                        <div class="ps-4">
                            <p class="mb-0 clamp-1" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].name}</p>
                        </div>
                        <div class="ms-auto">
                            <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase" class="float-end mt-1">${data[i].posts}</small>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>`);

                    }

                }

            }

        }
    })

}

function getStatuses() {
    $.ajax({
        url: site_url + "/api.php",
        method: "GET",
        data: {
            type: "getStatuses",
            csrf_token: csrf_token
        },
        success: (data) => {

            // Loop through the statuses
            for (let i = 0; i < data.length; i++) {

                $("#feed-container").append(`<div class="col-md-4 mb-3 statusGroup" id="statusGroup-${data[i].status_id}">
                <div class="card h-100">
                    <div class="card-header py-3">
                        <i class="fas fa-circle me-2" style="color:${data[i].color}"></i> ${data[i].name}
                    </div><div class="card-body p-0">
                        <ul class="list-group list-group-flush"></ul>
                    </div></div>
            </div>`);


                $.ajax({
                    url: site_url + "/api.php",
                    method: "GET",
                    data: {
                        type: "getPostsByStatus",
                        csrf_token: csrf_token,
                        status_id: data[i].status_id
                    },
                    success: (posts) => {

                        if (!posts.code) {

                            // Loop through the posts
                            for (let j = 0; j < posts.length; j++) {
                                $("#statusGroup-" + data[i].status_id + " .list-group").append(`
                        <li class="list-group-item">
                        <div class="d-flex">
                                <div class="me-4 upvote mt-1" data-id="${posts[j].post_id}" data-voted="${posts[j].hasUpvoted}">
                                    <button class="btn ${posts[j].hasUpvoted ? "btn-accent" : "btn-light"} border px-3">
                                        <i class="fas fa-caret-up d-block"></i>
                                        <p class="mb-0">${posts[j].upvotes}</p>
                                    </button>
                                </div>
                            <a href="${posts[j].url}" class="text-reset text-decoration-none">
                                <p class="mb-0 clamp-2" style="font-weight: 600; font-size: 15px; line-height: 22px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word">${posts[j].title}</p>
                                <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">${posts[j].board.name}</small>
                            </a>
                        </div>
                    </li>`);

                            }

                        } else {
                            $("#statusGroup-" + data[i].status_id + " .card-body").append(`<div class="card-body pt-1"><p class="ms-4 my-auto noPosts">` + terms.nothing_here + `</p></div>`)
                        }

                    }

                });


            }

        }
    })

}

$("#searchPage").autocomplete({
    source: site_url + "/api.php?type=getResults",
    appendTo: '#searchPageContainer'
}).autocomplete("instance")._renderItem = (ul, item) => {
    if (item.code && item.code === 204) {
        return $(`
    <div class="card rounded-0 border-0 px-4 py-3 text-dark"> 
        No results found
    </div>
`).appendTo(ul);
    } else {
        let orig = item.name;
        let term = $(".search").val();
        return $(`
<a href="${item.url}" class="text-dark text-decoration-none">
    <div class="card rounded-0 border-0"> 
        <div class="border-bottom py-3 px-3">
            <i class="fas ${(item.type === "post" ? `fa-copy` : ``)} ${(item.type === "user" ? `fa-user` : ``)} ${(item.type === "board" ? `fa-columns-3` : ``)} me-2 text-muted align-middle"></i> <span class="d-inline-block align-middle" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:80%">${boldString(orig, term)}</span>
            <span class="float-end"><i class="far fa-arrow-right"></i></span>
    </div>
</a>
`).appendTo(ul);
    }
};