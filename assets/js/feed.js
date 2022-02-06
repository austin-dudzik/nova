$(document).ready(() => {
    getStatuses();
})

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

                $("#feed-container").append(`<div class="col-md-4 statusGroup">
                <div class="card h-100">
                    <div class="card-header py-3">
                        <i class="fas fa-circle me-2" style="color:${data[i].color}"></i> ${data[i].name}
                    </div>` + (data[i].posts ? `<div class="card-body p-0">
                        <ul class="list-group list-group-flush" id="status-${data[i].status_id}-posts"></ul>
                    </div>` : `<div class="card-body pt-1"><p class="ms-4 my-auto noPosts">` + terms.nothing_here + `</p></div>`) + `</div>
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
                                $("#status-" + data[i].status_id + "-posts").append(`
                        <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 my-auto">
                                <div class="upvote" data-id="${posts[j].post_id}" data-voted="${posts[j].hasUpvoted}">
                                    <button class="btn ${posts[j].hasUpvoted ? "btn-accent" : "btn-light"} border px-3">
                                        <i class="fas fa-caret-up d-block"></i>
                                        <p class="mb-0">${posts[j].upvotes}</p>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <p class="mb-0 mt-1" style="font-weight: 600; font-size: 15px; line-height: 22px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word">${posts[j].title}</p>
                                <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">FEATURE REQUESTS</small>
                            </div>
                        </div>
                    </li>`);

                            }

                        }

                    }

                });


            }

        }
    })

}


$.ajax({
    url: site_url + "/api.php",
    method: "GET",
    data: {
        type: "getBoards",
        csrf_token: csrf_token
    },
    success: (data) => {

        for (let i = 0; i < data.length; i++) {

            if (feed_type === 1) {
                $("#boards-container").append(`
                        <div class="col-md-3 mb-4">
                        <a href="${data[i].url}" class="text-reset text-decoration-none">
            <div class="card" style="background:#efefef">
                <div class="card-body text-center">
                    <i class="fas fa-${data[i].icon} fa-2x d-block mb-2 text-accent"></i>
                    <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].name}</p>
                    <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">${data[i].posts} ${terms.posts}</small>
                </div>
            </div>
            </a>
        </div>`);
            } else if (feed_type === 2) {

                $("#boards-container").append(`
                        <div class="col-md-3">
                        <a href="${data[i].url}" class="text-reset text-decoration-none">
                <div class="card" style="background:#efefef">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 my-auto">
                                <i class="fas fa-${data[i].icon} fa-2x d-block mb-2 text-accent"></i>
                            </div>
                            <div class="col-md-10 ps-3">
                                <p class="mb-0"
                                   style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].name}</p>
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
                        <div class="col-md-3">
            <div class="card" style="background:#efefef">
            <a href="${data[i].url}" class="text-reset text-decoration-none">
                <div class="card-body py-2">
                    <div class="row mt-1">
                        <div class="col-md-1 my-auto">
                            <i class="fas fa-${data[i].icon} fa-2x d-block mb-2 text-accent" style="font-size:20px"></i>
                        </div>
                        <div class="col-md-8 ps-4">
                            <p class="mb-0" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].name}</p>
                        </div>
                        <div class="col float-end">
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
})

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