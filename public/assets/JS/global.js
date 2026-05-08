// LoadingPage
$(document).ready(function () {
    setTimeout(function () {
        $(".loadingPage").fadeOut(1000, function () {
            $(this).addClass("d-none");
        });
    }, 1000);
});


function openPopUp(popUpName){
    $(`.popUp.${popUpName}`).fadeIn(200).delay().css("display","flex");
}
function closePopUp(){
    $(`.popUp`).fadeOut(200);
}

$(".popUp .box").click(function (e) { 
    e.stopPropagation();
});