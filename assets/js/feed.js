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

            // If no boards
            if (!data.length) {
                $("#boards-container").append(`<div class="px-5 py-3 text-center">
                         <svg xmlns="http://www.w3.org/2000/svg"
                                 class="mb-2"
                                 style="height:50px;width:50px"
                                 viewBox="0 0 20 20"
                                 fill="#6c757d">
                                <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"/>
                            </svg>
                            <h6>No boards here, yet.</h6>
                            <p>Once a new board is opened, you'll be able to provide feedback.</p>
                        </div>
`);
            } else {

                // Loop through boards
                for (let i = 0; i < data.length; i++) {

                    if (feed_type === 1) {
                        $("#boards-container").append(`
                        <div class="col-12 col-md-3 col-xl-4 mb-3">
                        <a href="${data[i].url}" class="text-reset text-decoration-none">
            <div class="card round" style="background:#f8f8f8">
                <div class="card-body text-center">
                <span class="fa-stack mb-2">
                        <i class="fas fa-circle fa-stack-2x text-accent"></i>
                        <i class="fas fa-${data[i].icon} fa-stack-1x text-white"></i>
                      </span>
                    <p class="mb-0 clamp-1" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].visibility === 2 ? '<i class="fas fa-lock me-1 a-tooltip" data-bs-placement="top" title="Private"></i>' : ''} ${data[i].visibility === 0 ? '<i class="fas fa-eye-slash me-1 a-tooltip" data-bs-placement="top" title="Unlisted"></i>' : ''} ${data[i].name}</p>
                    <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">${data[i].posts} ${terms.posts}</small>
                </div>
            </div>
            </a>
        </div>`);
                    } else if (feed_type === 2) {

                        $("#boards-container").append(`
                        <div class="col-12 col-md-4 col-xl-4 mb-3">
                        <a href="${data[i].url}" class="text-reset text-decoration-none">
                <div class="card round" style="background:#efefef">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="my-auto">
                                 <span class="fa-stack">
                        <i class="fas fa-circle fa-stack-2x text-accent"></i>
                        <i class="fas fa-${data[i].icon} fa-stack-1x text-white"></i>
                      </span>
                            </div>
                            <div class="ps-3">
                                <p class="mb-0 clamp-1" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].visibility === 2 ? '<i class="fas fa-lock me-1 a-tooltip" data-bs-placement="top" title="Private"></i>' : ''} ${data[i].visibility === 0 ? '<i class="fas fa-eye-slash me-1 a-tooltip" data-bs-placement="top" title="Unlisted"></i>' : ''} ${data[i].name}</p>
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
                        <div class="col-12 col-md-6 col-xl-4 mb-3">
            <div class="card" style="background:#efefef">
            <a href="${data[i].url}" class="text-reset text-decoration-none">
                <div class="card-body py-2">
                    <div class="d-flex mt-1">
      
                        <div class="my-auto">
                            <span class="fa-stack" style="font-size:14px">
                        <i class="fas fa-circle fa-stack-2x text-accent"></i>
                        <i class="fas fa-${data[i].icon} fa-stack-1x text-white"></i>
                      </span>
                        </div>
                        <div class="ps-3">
                            <p class="mb-0 clamp-1" style="font-weight: 600;font-size: 15px;line-height: 22px">${data[i].visibility === 2 ? '<i class="fas fa-lock me-1 a-tooltip" data-bs-placement="top" title="Private"></i>' : ''} ${data[i].visibility === 0 ? '<i class="fas fa-eye-slash me-1 a-tooltip" data-bs-placement="top" title="Unlisted"></i>' : ''} ${data[i].name}</p>
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

                $("#feed-container").append(`<div class="col-md-12 mb-3" id="statusGroup-${data[i].status_id}">
                <div class="card border-0">
                    <div class="card-header bg-white py-3 px-0 pt-0 border-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="fas fa-circle me-2" style="color:${data[i].color}"></i> ${data[i].name}
                        </div>
                        <div>
                            <i class="fas fa-pencil me-2 a-tooltip" data-bs-toggle="modal" data-bs-target="#editStatus${data[i].status_id}" data-bs-placement="top" title="Edit status" role="button"></i>
                            
                            <div class="modal fade" id="editStatus${data[i].status_id}">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-accent"></i>
                                <i class="far fa-pencil fa-stack-1x text-white"></i>
                              </span>
                                <h5>Edit Status</h5>
                                <div class="mb-4">
                                    <form method="post">
                                        <label for="name-${data[i].status_id}">Name</label>
                                        <input type="text" class="form-control mb-2" name="name" id="name-${data[i].status_id}"
                                               value="${data[i].name}">
                                               <p class="small text-danger" id="nameError${data[i].status_id}" style="display:none">Status name is required</p>
                                               <label for="color-${data[i].status_id}">Color</label>
                                        <input type="color" class="form-control mb-3" name="color" id="color-${data[i].status_id}"
                                               value="${data[i].color}">
                                               <input type="hidden" name="id" value="${data[i].status_id}">
                                        <button type="submit" name="updateStatus" class="btn bg-accent text-white round border">Save changes
                                        </button>
                                        <button type="button" class="btn btn-white border round" data-bs-dismiss="modal">Cancel
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                            <i class="fas fa-trash-alt text-danger a-tooltip" role="button" data-bs-toggle="modal" data-bs-target="#deleteStatus${data[i].status_id}" data-bs-placement="top" title="Delete status"></i>
                            
                            <div class="modal fade" id="deleteStatus${data[i].status_id}">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                                <span class="fa-stack h6">
                                <i class="fa-solid fa-circle fa-stack-2x text-danger"></i>
                                <i class="far fa-trash-alt fa-stack-1x text-white"></i>
                              </span>
                                <h5>Delete Status</h5>
                                <div class="mb-4">
                                    <form method="post">
                                    <p>Are you sure you want to delete this status?</p>
                                        <input type="hidden" name="id" value="${data[i].status_id}">
                                        <button type="submit" name="deleteStatus" class="btn btn-danger round border">Delete status
                                        </button>
                                        <button type="button" class="btn btn-white border round" data-bs-dismiss="modal">Cancel
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                        </div>
                    </div>
                    </div>
                    <div class="card-body p-0 border-0">
                        <ul class="list-group list-group-flush"></ul>
                    </div>
                </div>
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
                        <li class="list-group-item bg-white px-0">
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
                            $("#statusGroup-" + data[i].status_id + " .card-body").append(`<div class="card-body pt-1"><p class="ms-4 my-auto noPosts text-muted">` + terms.nothing_here + `</p></div>`)
                        }

                    }

                });


            }

        }
    })

}

$(document).ajaxStop(function () {
    $("#loading").hide();
    $("#page").show();
});


$("#visibility input").on("change", function () {
    if ($("#private").is(":checked")) {
        $("#rules-section").show();
    } else {
        $("#rules-section").hide();
    }
});