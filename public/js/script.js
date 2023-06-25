function load() {
    $('.loading').removeClass('d-none');
}

function passwordChange() {
    $("#btn-save").removeClass("d-none");
    $("#btn-save").attr("type", "submit");

    if($("#password").val() == "") {
        $("#btn-save").addClass("d-none");
        $("#btn-save").attr("type", "button");
    }
}

// $(window).load(function () {
//     $(".img-fluid").addClass("placeholder w-100 h-200");    
// });

window.addEventListener("load", event => {
    var image = document.querySelector('img');
    var isLoaded = image.complete && image.naturalHeight !== 0;
    if(isLoaded){
        $(".img-fluid").removeClass("placeholder w-100 h-200"); 
    }
});

$("input[name=search]").keyup(function () { 
    if($(this).val() == ''){
        $("#keyword").addClass("d-none");
        $("#load-search").addClass("d-none");
        $("#search-view").addClass("d-none");
        $(".list-view").removeClass("d-none");
        $("#keyword").addClass("d-none");
        $(".search-list").addClass("d-none");
    }
});

$("input[name=search]").change(function (e) { 
    $value = $(this).val();
    if($value != ''){
        $("#search-view").removeClass("d-none");
        $("#load-search").removeClass("d-none");
        $(".list-view").addClass("d-none");
    }

    $.ajax({
        type: "get",
        url: window.location.origin + "/search",
        data: { 
            "search":$value,
            "genre": $('#filterByGenre').find(":selected").data().id 
        },
        success: function (response) {
            if($value != '') {
                $("#keyword").removeClass("d-none");
                $("#keyword").html("search : " + response.search);

                $("#load-search").addClass("d-none");
                $(".list-view").addClass("d-none");
                $(".search-list").removeClass("d-none");

                if(response.data != ''){
                    $(".search-list").html(response.data);
                } else {
                    $(".search-list").html("<div class='fs-6 fw-bold text-center text-gray mb-5 pb-5'>No Result</div>");
                }
            } else {
                $("#keyword").addClass("d-none");
                $("#load-search").addClass("d-none");
                $("#search-view").addClass("d-none");
                $(".list-view").removeClass("d-none");
                $("#keyword").addClass("d-none");
                $(".search-list").addClass("d-none");
            }
        },error: function(error){
            $("#keyword").addClass("d-none");
            $("#load-search").addClass("d-none");
            $("#search-view").addClass("d-none");
            $(".list-view").removeClass("d-none");
            $("#keyword").addClass("d-none");
            $(".search-list").addClass("d-none");
        }
    });
});