$(document).ready(() => {
    $("input[type='file']").on('change', (event) => {
        $('#preview').css("display", "initial");
        let file = event.target.files[0];
        let url = URL.createObjectURL(file);
        $('#preview').attr('src', url);
    });

    let foodIndex = 1;
    $("#add-btn").click((event) => {
        event.preventDefault();
        if (foodIndex === 7) {
            $("#add-btn").prop("disabled",true);
            return false;
        }
        $("#food-append").append(`
            <tr>
                <td>${foodIndex+1+"."}</td>
                <td><input maxlength='50' type='text' name='food[${foodIndex}][name]' placeholder=' Enter Food Name '/></td>
                <td><input type='number' name='food[${foodIndex}][amount]' placeholder=' Enter Amount '/></td>
            </tr>
        `);
        foodIndex++;
    });

    let addrIndex = 1;
    $("#add-btn2").click((event) => {
        event.preventDefault();
        if (addrIndex === 5) {
            $("#add-btn2").prop("disabled",true);
            return false;
        }
        $("#addr-append").append(`
            <tr class="tr-2">
                <td>${addrIndex+1+"."}</td>
                <td><input maxlength='100' type='text' name='dropoff[${addrIndex}]' placeholder=' Enter Drop-Off Address '/></td>
            </tr>
        `);
        addrIndex++;
    });

    if($("input[name='partnership']").is(":checked")) {
        $(".partnership-display").show();
    } else {
        $(".partnership-display").hide();
    }
    $("input[name='partnership']").on('change', ()=>{
        if($("input[name='partnership']").is(":checked")) {
            $(".partnership-display").show();
        } else {
            $(".partnership-display").hide();
        }
    });

    $(".view-request").on("click", ()=>{
        $(".display-request").slideToggle();
    });


    $(".accordion").accordion({ header: ".accordion-header", collapsible: true, active: true, heightStyle: "content" });

    $(".accordion-header").on("click", function() {
        $(".accordion-header > img").not($(this).children("img")).removeClass('rotate180');
        $(this).children("img").toggleClass('rotate180'); 
      });
});