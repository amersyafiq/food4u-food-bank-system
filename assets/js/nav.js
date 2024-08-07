$(document).ready(() => {
    $(".nav-2 > button").click((event) => {
        $(".nav-2 > button").removeClass("clicked");
        $(event.currentTarget).addClass("clicked");
    });

    $("#nav-btn").click(()=>{
        $(".nav-1 > p").toggle();
        $(".nav-2 > button > p").toggle();
        $("nav").toggleClass("nav-toggle");
    });
});

function gotoURL(url) {
    window.location.href = url;
}
