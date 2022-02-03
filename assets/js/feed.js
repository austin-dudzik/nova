isLoading = true;

$.ajax({
    url: "http://localhost/feedback/api.php",
    method: "GET",
    data: {
        type: "getStatuses",
        csrf_token: csrf_token
    },
    success: (data) => {

        for (let i = 0; i < data.length; i++) {

            $("#feed-container").append(`
                        <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header py-3" style="border:0;background:#efefef;font-weight:700;font-size:15px">
                <i class="fas fa-circle me-2" style="font-size:10px;vertical-align:middle;color:${data[i].color}"></i> ${data[i].name}
            </div>` +
                ((data[i].posts) ?

                    `<div class="card-body p-0" style="background:#efefef;height:250px;overflow-y:auto">
                <ul class="list-group list-group-flush" id="status-${data[i].status_id}-posts"></ul>
            </div>` : `<div class="card-body pt-1" style="background:#efefef;height:250px;overflow-y:auto"><p style="font-weight:500;color:#999" class="ms-4 my-auto">Nothing here, yet. Check back soon!</p></div>`) +

                `</div>
    </div>`);


            for (let j = 0; j < data[i].posts.length; j++) {
                $("#status-" + data[i].status_id + "-posts").append(`
                        <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 my-auto">
                                <button class="btn ${data[i].posts[j].hasUpvoted ? "btn-primary" : "btn-light"} border px-2 w-100">
                                    <i class="fas fa-caret-up d-block"></i>
                                    <p class="mb-0">${data[i].posts[j].upvotes}</p>
                                </button>
                            </div>
                            <div class="col-md-10">
                                <p class="mb-0 mt-1" style="font-weight: 600; font-size: 15px; line-height: 22px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word">${data[i].posts[j].title}</p>
                                <small style="color: #999; font-size: 11px; font-weight: 700; letter-spacing: .05em; line-height: 17px; text-transform: uppercase">FEATURE REQUESTS</small>
                            </div>
                        </div>
                    </li>`);

            }



        }

    }
})