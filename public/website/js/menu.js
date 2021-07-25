
$(document).ready(function() {
    
    $('.dropdown_menu').css('display','none');

 

    $("#custom_search").keyup(function() {
        
        let search_value = $(this).val();
        if( search_value.length >= 3 ) {

            search_posts(search_value);
        }

        if(search_value == '') {
            $(".show_custom_results").hide();
        }

    })

});


$(".search_icon").click(function() {
    $(".search_div").slideToggle();
});

$(".drpdown").click(function() {
    $(this).toggleClass("fas fas fa-angle-up");
    $(".dropdown_menu").slideToggle();
})

function showSidebar() {
    $('.mobile_sidebar').attr('style','width:320px');
    $('.cs-site-overlay').removeAttr('style');
    $('.mobile_sidebar').addClass('animate__animated animate__slideInLeft animate__faster');
}


function closeSidebar() {
    $('.mobile_sidebar').attr('style','width:0%');
    $('.cs-site-overlay').attr('style','display:none');
    $('.mobile_sidebar').removeClass('animate__animated animate__slideInLeft animate__faster');
}

function search_posts(value) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: '/search_post',
        type: 'POST',
        dataType: 'json',
        data: {data:value},
        success: function(data) {
            var html =``;

            $(".show_custom_results").show();

            console.log( data.length );

            if(data.length > 0) {
                for(var i = 0; i < data.length; i ++) {
                    html+= `
                        <li>
                            <a href="/post/`+data[i].slug+`">
                                <div class="row">
                                    <div class="col-1">
                                        <img src="/images/`+data[i].image+`" width="80" height="50" class="shadow-sm rounded">
                                    </div>
    
                                    <div class="col-11">`+data[i].title+` <br>
                                        <span class="small text-muted">`+ moment(data[i].created_at).format("DD-MM-YYYY") +`</span>
                                    </div>
                                </div>
                            </a>                        
                        </li>
                    `;
                }
            }else{
                html+= ` <li> <a> No Record Found </a> </li> `;
            }

            $('.show_custom_results').html(html);
        },
        error: function(error) {
            console.log(error)
        },
    });
}
