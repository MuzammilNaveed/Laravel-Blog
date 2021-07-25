$(document).ready(function() {
    $('.dropdown_menu').css('display','none');
});


$("#search_icon").click(function() {
    $(".search_div").slideToggle();
});

$(".drpdown").click(function() {
    $(this).toggleClass("fas fas fa-angle-up");
    $(".dropdown_menu").slideToggle();
})