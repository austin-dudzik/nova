$(document).ready(() => {
    getBoards();
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

            if (!data.length) {
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