$(document).ready(function() {
    $("#search_icon").click(function() {
        $(".search_div").slideToggle();
    });

    // post_data();
    // get_all_post_and_categories();
});

function post_data() {
    var url = window.location.pathname.split('/');
    var slug = url[2];
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: '/get_all_posts',
        type: 'GET',
        dataType: 'json',
        data: {
            slug: slug
        },
        success: function(data) {
            var cat = data.categories[0];
            console.log(data, 'api call');

            $('#category_name').html(cat.category_name);
            $('#category_desc').html(cat.cat_desc);
            $('#post_count').html(data.post_count + " Posts");

            var post = ``;
            for (var i = 0; i < data.posts.length; i++) {

                post += `
                <div class="col-md-6 p-2">
                    <a href="/single/` + data.posts[i].slug + `">
                        <div class="__lastest_post __hover m-2">
                            <div class="__post_img mb-2" style="position:relative;">
                                <img src="{{asset('images/` + data.posts[i].image + `')}}" class="img-fluid" alt="">
                                <span style="position:absolute;left:8px;bottom:8px;"
                                    class="__cat_bg text-white __radius">` + (data.posts[i].cat_id == cat.id ? cat
                    .category_name : '-') + `</span>
                            </div>
                            <div class="">
                                <h2 class="mt-2 mb-0">` + data.posts[i].title + `</h2>
                                <span style="font-size:0.675rem" class="small m-0 p-0 text-muted">
                                ` + moment(data.posts[i].created_at).format('MMMM DD, YYYY') + `</span>
                            </div>
                        </div>
                    </a>
                </div>
                `;
            }
            $('#__category_post_content').html(post);
        },
        error: function(error) {
            console.log(error)
        },
    });
}

function get_all_post_and_categories() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: '/get_all_post_and_categories',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var cat_obj = data.categories;
            var post_obj = data.posts;
            var row = ``;
            var recent_post = ``;
            for (var i = 0; i < cat_obj.length; i++) {
                row += `
                <a href="/category/` + cat_obj[i].cat_slug +
                    `" class="badge __category_badge __badge_hover text-dark mt-2">` + cat_obj[i]
                    .category_name + `</a>
                `;
            }
            for (var i = 0; i < post_obj.length; i++) {
                recent_post += `
                <div class="__recent_post mt-4 __hover">
                    <h5><a href="/single/` + post_obj[i].slug + `">` + post_obj[i].title + `</a></h5>
                    <span class="small text-muted">` + moment(post_obj[i].created_at).format('MMMM DD, YYYY') + `</span>
                </div>
                <hr>
                `;
            }
            $('#__categories').html(row);
            $('#__recent_post').html(recent_post);
            console.log(data, 'all api call');
        },
        error: function(error) {
            console.log(error)
        },
    });
}