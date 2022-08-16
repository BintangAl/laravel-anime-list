if($("#synopsis").text().length > 300){
    $("#synopsis").addClass("box-over");
    $("#read-more").removeClass("d-none");
} else {
    $("#synopsis").addClass("mb-3");
}

$(document).ready(function () {
    if(window.location.pathname.split( '/' )[4] != undefined){
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#overview").offset().top
        }, "fast");
    }

    $("#read-more").click(function () { 
        $("#synopsis").removeClass("box-over");
        $("#read-more").addClass("d-none");
        $("#read-less").removeClass("d-none");
    });
    
    $("#read-less").click(function () { 
        $("#synopsis").addClass("box-over");
        $("#read-more").removeClass("d-none");
        $("#read-less").addClass("d-none");
    });

    var ids = $('.relation-image').map(function () {
        return this.id;
    }).get().join();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: window.location.origin+"/rel-image",
        data: {"id" : window.location.pathname.split('/')[2]},
        dataType: "json",
        success: function (response) {
            $('#relations').html('<div class="d-flex overpass" style="overflow: auto">'+response.data+'</div>');
        },error:function(error){
            console.log(error);
            alert(error);
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
                $("#"+value.split("#")[1]).html(response.status + ' <i class="fa-solid fa-caret-down ms-2"></i>');
            } else {
                $("#"+value.split("#")[1]).html('<i class="fa-solid fa-circle-plus"></i> Add to List');
            }
        },error:function(error){
            console.log(error);
            if(error.status == 401){
                window.location.href=window.location.origin+'/login';
            } else {
                alert(error.responseJSON.message);
            }
        }
    });
}

function addFavorite(value) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: window.location.origin+"/anime/add-to-favorite",
        data: {"data" : value},
        dataType: "json",
        success: function (response) {
            if(response.status == 200){
                $("#add-fav").removeClass("text-white");
                $("#add-fav").addClass("text-pink-light");
            } else {
                $("#add-fav").addClass("text-white");
                $("#add-fav").removeClass("text-pink-light");
            }
        },error:function(error){
            console.log(error);
            if(error.status == 401){
                window.location.href=window.location.origin+'/login';
            } else {
                alert(error.responseJSON.message);
            }
        }
    });
}