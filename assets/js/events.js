$(document).ready(()=>{
    $("input[name='searchEvent']").on("keyup", function() {
        let getSearch = $(this).val();
        let getType = $("select[name='eventType']").val();
        $.ajax({
            method: 'POST',
            url: 'events.php',
            data:{search_event: getSearch, search_type: getType},
            success:function(response) {
                if (!$.trim(response)){   
                    $("#search-empty").show();
                    $(".event-container").hide();
                } else {
                    $("#search-empty").hide();
                    $(".event-container").show();
                    $(".event-container").html(response);
                }
            }
        });
    });

    $("select[name='eventType']").on("change", function() {
        let getType = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'events.php',
            data: {search_type: getType},
            success: function(response) {
                if (!$.trim(response)){   
                    $("#search-empty").show();
                    $(".event-container").hide();
                } else {
                    $("#search-empty").hide();
                    $(".event-container").show();
                    $(".event-container").html(response);
                }
            }
        });
    });

    $(document).on( "click",".delete-btn", function( event ) {
        event.preventDefault();
        event.stopPropagation();
        $(".delete-card").addClass("popup-show");
        $delete_name = $(this).data('delete-name');
        $delete_id = $(this).data('delete-id');
        $delete_partnership = $(this).data('delete-partnership');
        $delete_image = $(this).data('delete-image');
        $delete_vol = $(this).data('delete-vol');
        $delete_food = $(this).data('delete-food');
        $delete_moneu = $(this).data('delete-money');
        $(".name-container > p").text($delete_name);
        $(".vol-amt").text($delete_vol);
        $("input[name='DELETE_ID']").prop("value",$delete_id);
        $("input[name='isPARTNERSHIP']").prop("value",$delete_partnership);
        $("input[name='DELETE_IMAGE']").prop("value",$delete_image);
    });

    $(".popup-close").click(function() {
        $(this).closest(".popup").removeClass("popup-show");
        $("select").prop("selectedIndex", 0);
        $("input").val('');
    });
});