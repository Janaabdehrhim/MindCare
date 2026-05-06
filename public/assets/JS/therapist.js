function openPopUp(popUpName){
    $(`.popUp.${popUpName}`).fadeIn(200).delay().css("display","flex");
}
function closePopUp(){
    $(`.popUp`).fadeOut(200);
}