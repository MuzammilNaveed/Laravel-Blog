$(document).ready(function() {



    $(".new_letter_form").submit(function(event) {
        event.preventDefault();
        
        let id = $(this).data('wid');
        let email = $("#newsletter_email_"+id).val();

        if( $.trim( email ) == '' || $.trim( email ) == null) {

            var msg = `<span class="text-danger small"> Please enter your email address </span>`;
            $("#show_message_"+id).html(msg);

        }else{
            $("#show_message_"+id).html(" ");
            $.ajax({
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                type: "POST",
                url: '/newsletter-subscription',
                data: { email:email },
                dataType: "json",
                beforeSend:function(data) {
                    $("#save_btn_"+id).hide();
                    $("#loader_"+id).show();
                },
                success: function(data) {
                    if(data.status == 200 && data.success == true) {
                        $("#show_message_"+id).html(
                            `<span class='text-success small'> `+data.message+` </span>`
                        );
                        $("#newsletter_email_"+id).val("");
                    }else{
                        $("#show_message_"+id).html(
                            `<span class='text-danger small'> `+data.message+` </span>`
                        )
                    }

                    setTimeout(() => {
                        $("#show_message_"+id).html("").fadeOut();
                    }, 2500);
                },
                complete:function(data) {
                    $("#save_btn_"+id).show();
                    $("#loader_"+id).hide();
                },
                error: function(e) {
                    console.log(e);
                    $("#save_btn_"+id).show();
                    $("#loader_"+id).hide();
                    if(e.responseJSON) {
                        let error = e.responseJSON.errors.email[0];
                        $("#show_message_"+id).html(`<span class="text-danger small">`+error+`</span>`);
                    }
                }
            });
        }

    });



});