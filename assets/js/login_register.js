$(document).ready(()=>{
    $("#vol").prop("checked",true);

    $("input[type='radio']").click(()=>{
        if($('#vol').is(':checked')) {
            $(".org-view").css("display","none");
        }
        else {
            $(".org-view").css("display","initial");
        }
    });

    $("input[type='file']").on('change', (event)=>{
        let file = event.target.files[0];
        let url = URL.createObjectURL(file);
        $('#preview').attr('src', url);
    });

    $("#check").click(()=>{
        if($('#check').is(':checked')) {
            $(".register-form > button").prop("disabled", false);
            $(".register-form > button").css({"background-color": "#26CA68", "cursor": "pointer"});
        }
        else {
            $(".register-form > button").prop("disabled", true);
            $(".register-form > button").css({"background-color": "rgba(41, 184, 98, 0.658)", "cursor": "default"});
        }
    });

    $("#sh-pwd").click(() => {
        if ($(".pwd").prop("type") === "password") {
            $(".pwd").prop("type", "text");
            $("#sh-pwd").removeClass("fa-eye-slash").addClass("fa-eye");
            $("#sh-pwd > p").text("Hide password");
        } else if ($(".pwd").prop("type") === "text") {
            $(".pwd").prop("type", "password");
            $("#sh-pwd").removeClass("fa-eye").addClass("fa-eye-slash");
            $("#sh-pwd > p").text("Show password");
        }

    });


});