$(document).ready(function() {

    $('.dropdown_menu').css('display','none');

    $("#search_icon").click(function() {
        $(".search_div").slideToggle();
    });

    // post comment
    $('#post_comment').submit(function(e) {
        e.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var comment = $('#comment').val();
        var post_id = $('#post_id').val();

        var formData = {
            name: name,
            email: email,
            comment: comment,
            post_id: post_id
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '{{url("post_comment")}}',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(data) {
                console.log(data, 'api call');

                $(".success_msg").show();

                setTimeout(() => {
                    $(".success_msg").hide();
                },3500);

            },
            error: function(error) {
                console.log(error)
            },
        });

    });

});


function commentReply(caller, id) {
    console.log(caller , "caller");
    console.log(id , "id");
    $('.replyComment').insertAfter($(caller));
    $('.replyComment').show();

    $('#post_comment_reply').submit(function(e) {
        e.preventDefault();
        var name = $('#replyname').val();
        var email = $('#replyemail').val();
        var comment = $('#replycomment').val();
        var post_id = $('#post_id').val();

        var formData = {
            name: name,
            email: email,
            comment: comment,
            post_id: post_id,
            comment_id: id
        }
        console.log(formData, "form data");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '{{url("comment_reply")}}',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(data) {
                console.log(data, 'api call');

                $(".reply_success_msg").show();

                setTimeout(() => {
                    $(".reply_success_msg").hide();
                },3500);


            },
            error: function(error) {
                console.log(error)
            },
        });

    });

}