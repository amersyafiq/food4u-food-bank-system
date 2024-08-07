$(document).ready(()=>{
    $(".hamburger").click(()=>{
        $("header").toggleClass("expanded-header");
        $(".buttons").toggle().toggleClass("expanded-btns");

        //nav
        var navbtn = $(".nav-2").detach();
        $(".header-2").append(navbtn);
        $(".nav-2").toggleClass("nav-header");

        var element = $(".buttons").detach();
        $(".header-2").append(element);
    });


    $(window).resize(() => {
        if ($(window).width() > 800) {
            $("header").removeClass("expanded-header");
            $(".buttons").removeClass("expanded-btns");
            var element = $(".buttons").detach();
            $(".header-1").append(element);

            var navbtn = $(".nav-2").detach();
            $("nav").append(navbtn);
            $(".nav-2").removeClass("nav-header");
        }
    });

    $(".user-profile").tooltip();
});

