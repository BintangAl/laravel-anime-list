$(document).ready(function () {
    if(window.matchMedia('(max-width: 991px)').matches) {
        $(window).scrollTop(192);
    } else{
        if(window.location.href == window.location.origin+'/profile/setting' || window.location.href == window.location.origin+'/profile/setting/account'){
            $(window).scrollTop(192);
        }
    }

    function navbarClass(add, remove) {
        $(".navbar").addClass(add);
        $(".navbar").removeClass(remove);
    }

    if($("#banner-url").val() != ""){
        if(window.location.pathname.split('/')[1] == 'profile'){
            $(".navbar").removeClass("sticky-top");
            $(".navbar").addClass("fixed-top");
    
            if($(window).scrollTop() == 0) {
                navbarClass("bg-nav", "bg-main");
            }

            $(window).scroll(function () { 
                if($(window).scrollTop() == 0){
                    navbarClass("bg-nav", "bg-main");
                } else {
                    navbarClass("bg-main", "bg-nav");
                }
            });
        }
    }

    if(window.location.pathname.split('/')[3] == $("#genre").val()){
        $("#genre span").html($("#genre").val().replace("_", " "));
        
        $("#genre-list-"+$("#genre").val()).removeClass("bg-hover-white50");
        $("#genre-list-"+$("#genre").val()).addClass("bg-gray");

        $("#genre-name-"+$("#genre").val()).removeClass("text-gray text-hover-black");
        $("#genre-name-"+$("#genre").val()).addClass("fw-bold");
    }
});

function nameChange(name) {
    $("#username").html(name);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: window.location.href+"/name-update",
        data: {"name" : name},
        dataType: "json",
        success: function (response) {
            if(response.status == 200){
                $("#name").addClass("border-0");
                $("#name-invalid").html("");
                $("#name").removeClass("is-invalid");
                $("#name").removeClass("border border-danger");
            } else {
                $("#name").removeClass("border-0");
                $("#name-invalid").html(response.message.name);
                $("#name").addClass("is-invalid");
                $("#name").addClass("border border-danger");
            }
        }
    });
}

function aboutChange(about) {
    $("#about-text").html('"' + about + '"');
    if(about == ''){
        $("#about-text").html('');
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: window.location.href+"/about-update",
        data: {"about" : about},
        dataType: "json",
        success: function (response) {
            if(response.status == 200){
                $("#about").addClass("border-0");
                $("#about-invalid").html("");
                $("#about").removeClass("is-invalid");
                $("#about").removeClass("border border-danger");
            } else {
                $("#about").removeClass("border-0");
                $("#about-invalid").html(response.message.about);
                $("#about").addClass("is-invalid");
                $("#about").addClass("border border-danger");
            }
        }
    });
}

$("input[name=search-list]").keyup(function (e) { 
    $value = $(this).val();
    $status = window.location.pathname.split( '/' )[3];

    $.ajax({
        type: "get",
        url: window.location.origin+"/search-list",
        data: {"search":$value, "status":$status},
        success: function (response) {
            $("#profile-list-view").html(response);
        }
    });
});

$("input[name=search-fav]").keyup(function (e) { 
    $value = $(this).val();
    $genre = window.location.pathname.split( '/' )[3];

    $.ajax({
        type: "get",
        url: window.location.origin+"/search-fav",
        data: {"search":$value, "genre":$genre},
        success: function (response) {
            $("#profile-fav-view").html(response);
        }
    });
});

function addList(value) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: window.location.origin+"/anime/add-to-list",
        data: {"status" : value},
        dataType: "json",
        success: function (response) {
            if(response.status != "Dropped"){
                $("#"+value.split("#")[1]).html(response.data + response.status);
            } else {
                load();
                window.location.href=window.location.href;
            }
        },error:function(){ 
            alert("Terjadi Kesalahan!");
        }
    });
}
