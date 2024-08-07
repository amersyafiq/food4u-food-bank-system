$(document).ready(()=>{
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

    $(".sponsor-table").hide();
    $(".download-sponsor").hide();
    $(".donation-selection > h3:nth-child(2)").on("click", function() {
        $(".donation-selection > h3:nth-child(1)").removeClass("donation-selection-text");
        $(".donation-selection > h3:nth-child(2)").addClass("donation-selection-text");
        $(".donation-filter").hide();
        $(".donation-table").hide();
        $(".download-donation").hide();
        $(".sponsor-table").show();
        $(".download-sponsor").show();

    });

    $(".donation-selection > h3:nth-child(1)").on("click", function() {
        $(".donation-selection > h3:nth-child(1)").addClass("donation-selection-text");
        $(".donation-selection > h3:nth-child(2)").removeClass("donation-selection-text");
        $(".donation-filter").show();
        $(".donation-table").show();
        $(".download-donation").show();
        $(".sponsor-table").hide();
        $(".download-sponsor").hide();

    });

    $("input[name='searchEvent']").on("keyup", function() {
        let getSearch = $(this).val();
        let getType = $("select[name='eventType']").val();
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data:{search_event: getSearch, search_type: getType},
            success:function(response) {
                if (!$.trim(response)) {  
                    $(".events-response").html(`<tr><td class="empty" colspan="4">No results can be found.</td></tr>`);
                } else {
                    $(".events-response").html(response);
                }
            }
        });
    });

    $("select[name='eventType']").on("change", function() {
        let getType = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data: {search_type: getType},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".events-response").html(`<tr><td class="empty" colspan="4">No results can be found.</td></tr>`);
                } else {
                    $(".events-response").html(response);
                }
            }
        });
    });

    $(document).on( "click",".donate-btn", function( event ) {
        $(".donate-card").addClass("popup-show");
        event_id = $(this).data('donate-id');
        $(".donation-event-id").html(event_id);
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data:{donate_id: event_id},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".donation-response").html(`<tr><td class="empty" colspan="7">No results can be found.</td></tr>`);
                } else {
                    $(".donation-response").html(response);
                }
            }
        });
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data:{sponsor_id: event_id},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".sponsor-response").html(`<tr><td class="empty" colspan="5">No results can be found.</td></tr>`);
                } else {
                    $(".sponsor-response").html(response);
                }
            }
        });
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data:{count_donation: event_id},
            success: function(response) {
                $(".donation-selection > h3:nth-child(1) > p").html(response);
            }
        });
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data:{count_sponsor: event_id},
            success: function(response) {
                $(".donation-selection > h3:nth-child(2) > p").html(response);
            }
        });
    });

    $("input[name='searchDonation']").on("keyup", function() {
        let getEventId = $(".donation-event-id").html();
        let getSearch = $(this).val();
        let getType = $("select[name='donationType']").val();
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data:{donate_id: getEventId, search_donation: getSearch, search_type2: getType},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".donation-response").html(`<tr><td class="empty" colspan="7">No results can be found.</td></tr>`);
                } else {
                    $(".donation-response").html(response);
                }
            }
        });
    });

    $("select[name='donationType']").on("change", function() {
        let getType = $(this).val();
        let getEventId = $(".donation-event-id").html();
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data: {donate_id: getEventId, search_type2: getType},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".donation-response").html(`<tr><td class="empty" colspan="7">No results can be found.</td></tr>`);
                } else {
                    $(".donation-response").html(response);
                }
            }
        });
    });

    $(document).on("click", ".acceptDonation", function() {
        let getEventId = $(".donation-event-id").html();
        let getDonationId = $(this).data("donation-id");
        let getFoodId = $(this).data("food-id");
        let getQty = $(this).data("donate-qty");
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data: {donate_id: getEventId, accept_id: getDonationId, food_id: getFoodId, donation_qty: getQty},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".donation-response").html(`<tr><td class="empty" colspan="7">No results can be found.</td></tr>`);
                } else {
                    $(".donation-response").html(response);
                }
            }
        })
    });

    $(document).on("click", ".deleteDonation", function() {
        let getEventId = $(".donation-event-id").html();
        let getDonationId = $(this).data("donation-id");
        let getMoneyQr = $(this).data("money-qr");
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data: {donate_id: getEventId, delete_id: getDonationId, money_qr: getMoneyQr},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".donation-response").html(`<tr><td class="empty" colspan="7">No results can be found.</td></tr>`);
                } else {
                    $(".donation-response").html(response);
                }
            }
        })
    });

    $(document).on("click", ".undoDonation", function() {
        let getEventId = $(".donation-event-id").html();
        let getDonationId = $(this).data("donation-id");
        let getFoodId = $(this).data("food-id");
        let getQty = $(this).data("donate-qty");
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data: {donate_id: getEventId, undo_id: getDonationId, food_id: getFoodId, donation_qty: getQty},
            success: function(response) {
                if (!$.trim(response)) {  
                    $(".donation-response").html(`<tr><td class="empty" colspan="7">No results can be found.</td></tr>`);
                } else {
                    $(".donation-response").html(response);
                }
            }
        });
    });

    $(document).on("click", ".emailSponsor", function(){
        let getEventId = $(".donation-event-id").html();
        let getId = $(this).data("sponsor-id");
        let getOrg = $(this).data("sponsor-name");
        let getEmail = $(this).data("sponsor-email");
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data: {sponsor_id: getEventId, sponsor_notify: getId, sponsor_name: getOrg, sponsor_email: getEmail},
            success: function(response) {
                $(".sponsor-response").html(response);
            }
        });
    });

    $(document).on("click", ".acceptSponsor", function(){
        let getEventId = $(".donation-event-id").html();
        let getId = $(this).data("sponsor-id");
        $.ajax({
            method: 'POST',
            url: 'dashboard.php',
            data: {sponsor_id: getEventId, sponsor_accept: getId},
            success: function(response) {
                $(".sponsor-response").html(response);
            }
        });
    });

    $(".download-events").on("click", function(){
        const pageTitle = 'Print Event List';
        const stylesheet = 'assets/css/dashboard.css';
        const win = window.open('/', pageTitle, 'width=1200,height=1500');
        const content = $('table')[0].outerHTML;

        win.document.write(`
            <html>
                <head>
                    <title>${pageTitle}</title>
                    <link rel="stylesheet" href="${stylesheet}">
                    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
                    <style>
                        table > thead > tr > th, table > tbody > tr > td { overflow: visible; white-space: wrap; }
                        table > thead > tr > th:nth-child(1), table > tbody > tr > td:nth-child(1) { width: 6vw; }
                        table > thead > tr > th:nth-child(2), table > tbody > tr > td:nth-child(2) { width: 45vw; }
                        table > thead > tr > th:nth-child(3), table > tbody > tr > td:nth-child(3) { width: 15vw; }
                        table > thead > tr > th:nth-child(4), table > tbody > tr > td:nth-child(4) { width: 15vw; }
                        table > thead > tr > th:nth-child(5), table > tbody > tr > td:nth-child(5) { width: 20vw; }
                        table > thead > tr > th:nth-child(6), table > tbody > tr > td:nth-child(6) { display: none; }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
            </html>
        `);
        win.document.close();      
        
        win.onload = function () {
            this.print();
        };
    });

    $(".download-donation").on("click", function(){
        const pageTitle = 'Print Donation List';
        const stylesheet = 'assets/css/dashboard.css';
        const win = window.open('/', pageTitle, 'width=1200,height=1500');
        
        const rows = $('.donation-table > tbody > tr');
        
        let foodTableContent = `
            <table class="donation-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DONOR NAME</th>
                        <th>DATE</th>
                        <th>DONATION NAME</th>
                        <th>QUANTITY (PAX)</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        let moneyTableContent = `
            <table class="donation-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DONOR NAME</th>
                        <th>DATE</th>
                        <th>DONATION NAME</th>
                        <th>QUANTITY (RM)</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        rows.each(function(){
            const row = $(this).clone();
            const donationName = row.find('td').eq(3).text().trim();
            
            if (donationName.includes('Money')) {
                moneyTableContent += `<tr>${row.html()}</tr>`;
            } else {
                foodTableContent += `<tr>${row.html()}</tr>`;
            }
        });
        
        foodTableContent += `</tbody></table>`;
        moneyTableContent += `</tbody></table>`;
        
        const content = `
            <center><h3 style="margin-bottom: 0.5rem;" >Food Donations</h3></center>
            ${foodTableContent}
            <br><br>
            <center><h3 style="margin-bottom: 0.5rem;" >Money Donations</h3></center>
            ${moneyTableContent}
        `;
        
        win.document.write(`
            <html>
                <head>
                    <title>${pageTitle}</title>
                    <link rel="stylesheet" href="${stylesheet}">
                    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
                    <style type="text/css">
                        .donation-table > thead > tr > th:nth-child(1), .donation-table > tbody > tr > td:nth-child(1) { width: 6vw; }
                        .donation-table > thead > tr > th:nth-child(2), .donation-table > tbody > tr > td:nth-child(2) { width: 35vw; }
                        .donation-table > thead > tr > th:nth-child(3), .donation-table > tbody > tr > td:nth-child(3) { width: 15vw; }
                        .donation-table > thead > tr > th:nth-child(4), .donation-table > tbody > tr > td:nth-child(4) { width: 19vw; }
                        .donation-table > thead > tr > th:nth-child(5), .donation-table > tbody > tr > td:nth-child(5) { width: 13vw; }
                        .donation-table > thead > tr > th:nth-child(6), .donation-table > tbody > tr > td:nth-child(6) { width: 20vw; }
                        .donation-table > thead > tr > th:nth-child(7), .donation-table > tbody > tr > td:nth-child(7) { display: none; }

                        .donation-table { page-break-inside:auto !important; }
                        .donation-table > thead > tr    { page-break-inside:avoid !important; page-break-after:auto !important; }
                        .donation-table > thead { display:table-header-group !important; }
                    </style>    
                </head>
                <body>
                    ${content}
                </body>
            </html>
        `);
        win.document.close();      
        
        win.onload = function () {
            this.print();
        };
    });

    $(".download-sponsor").on("click", function(){
        const pageTitle = 'Print Sponsor List';
        const stylesheet = 'assets/css/dashboard.css';
        const win = window.open('/', pageTitle, 'width=1200,height=1500');
        const content = $('.donation-table').css('display') === "none" ? $('.sponsor-table')[0].outerHTML : $('.donation-table')[0].outerHTML;

        win.document.write(`
            <html>
                <head>
                    <title>${pageTitle}</title>
                    <link rel="stylesheet" href="${stylesheet}">
                    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
                    <style>
                        .sponsor-table > thead > tr > th:nth-child(1), .sponsor-table > tbody > tr > td:nth-child(1) { width: 6vw; }
                        .sponsor-table > thead > tr > th:nth-child(2), .sponsor-table > tbody > tr > td:nth-child(2) { width: 50vw; }
                        .sponsor-table > thead > tr > th:nth-child(3), .sponsor-table > tbody > tr > td:nth-child(3) { width: 30vw; }
                        .sponsor-table > thead > tr > th:nth-child(4), .sponsor-table > tbody > tr > td:nth-child(4) { width: 14vw; }
                        .sponsor-table > thead > tr > th:nth-child(5), .sponsor-table > tbody > tr > td:nth-child(5) { display: none; }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
            </html>
        `);
        win.document.close();      
        
        win.onload = function () {
            this.print();
        };
    });

});
