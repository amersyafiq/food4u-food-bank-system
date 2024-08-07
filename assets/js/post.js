$(document).ready(()=>{

    $(".food-type").click(function() {
        $(".food-donation").addClass("popup-show");
        $(".dropoff-address > div > input[type='radio']:first-child").prop("checked", true);

        let foodName = $(this).data('food-name');
        let foodId = $(this).data('food-id');
        let foodGoal = $(this).data('food-goal');
        let foodAmount = $(this).data('food-amount');
        $(".donation-qty > p").text(foodName);
        $("input[name='foodId']").prop("value",foodId);
        $("input[name='foodGoal']").prop("value",foodGoal);
        $("input[name='foodAmount']").prop("value",foodAmount);
    });

    $(".popup-close").click(function() {
        $(this).closest(".popup").removeClass("popup-show");
        $("input[name='donateAddr'], input[name='donateAmount'], input[name='donateAmount1']").val('');
    });

    $(".money-type").click(function() {
        $(".money-donation").addClass("popup-show");
    });

    $(".bulk-type").click(function() {
        $(".bulk-donation").addClass("popup-show");
    });

    $("select[name='option']").on('change', function() {
        if ($(this).val() === "dropoff") {
            $("#sponsor-method-text").text("Select drop-off location");
            $(".dropoff-method").show();
            $(".pickup-method").hide();
        } else if ($(this).val() === "pickup") {
            $("#sponsor-method-text").text("Enter the address where you want us to pick-up from");
            $(".pickup-method").show();
            $(".dropoff-method").hide();
        } else {
            $("#sponsor-method-text").text("");
            $(".dropoff-method").hide();
            $(".pickup-method").hide();
        }
    });

    $(".vol-card").click(function() {
        $(".vol-popup").addClass("popup-show");
        $vol_name = $(this).data("vol-name");
        $vol_email = $(this).data("vol-email");
        $vol_image = $(this).data("vol-image");
        $vol_phone = $(this).data("vol-phone");
        $(".vol-image > img").attr('src', $vol_image);
        $(".vol-name > p").text($vol_name);
        $(".vol-email > p").text($vol_email);
        $(".vol-phone > p").text($vol_phone);
    });
});