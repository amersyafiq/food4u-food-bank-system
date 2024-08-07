$(document).ready(() => {

    let foodIndex = 0;
    $("#add-btn").click((event) => {
        event.preventDefault();
        if (foodIndex === 7) {
            $("#add-btn").prop("disabled",true);
            return false;
        }
        $("#food-append").append(`
            <tr>
                <td>${foodIndex+1+"."}</td>
                <td><input maxlength='50' type='text' name='newFood[${foodIndex}][name]' placeholder=' Enter Food Name '/></td>
                <td><input type='number' name='newFood[${foodIndex}][amount]' placeholder=' Enter Amount '/></td>
            </tr>
        `);
        foodIndex++;
    });

    let addrIndex = 0;
    $("#add-btn2").click((event) => {
        event.preventDefault();
        if (addrIndex === 5) {
            $("#add-btn2").prop("disabled",true);
            return false;
        }
        $("#addr-append").append(`
            <tr class="tr-2">
                <td>${addrIndex+1+"."}</td>
                <td><input maxlength='100' type='text' name='newDropoff[${addrIndex}]' placeholder=' Enter Drop-Off Address '/></td>
            </tr>
        `);
        addrIndex++;
    });


});