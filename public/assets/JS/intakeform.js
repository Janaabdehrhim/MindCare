let swiper = new Swiper(".swiper", {
    spaceBetween: 30,
    speed: 1000,
    allowTouchMove: false,
    autoHeight: true,
});
$(".next").click(function () {
    let activeSlide = $(swiper.slides[swiper.activeIndex]),
        selectedChoice = activeSlide.find(".choice.selected");

    if(selectedChoice.length == 0){
        $(".next").attr("disabled", true);
    } else{
        $(".next").attr("disabled", false);
    }

    swiper.slideNext();
});
$(".prev").click(function () {
    swiper.slidePrev();
});

let totalQuestions = $(".swiper-slide").length;

function updateUI() {
    let current = swiper.activeIndex + 1,
        activeSlide = $(swiper.slides[swiper.activeIndex]),
        category = activeSlide.data("category"),
        categoryIndex = activeSlide.data("category-index"),
        categoryTotal = activeSlide.data("category-total"),
        progress = (current / totalQuestions) * 100;

    $(".questionCount").text(`Question (${current}/${totalQuestions})`);
    $(".progress").css("width",progress + "%");
    $(".categoryCount").text(`${category}(${categoryIndex}/${categoryTotal})`);
    if(swiper.activeIndex == 0){
        $(".prev").attr("disabled", true);
    }else{
        $(".prev").attr("disabled", false);
    }
    if(activeSlide.find(".choice.selected").length > 0){
        $(".next").attr("disabled", false);
    } else{
        $(".next").attr("disabled", true);
    }
    if(swiper.activeIndex == totalQuestions - 1){
        $(".next").text("Submit");
    }else{
        $(".next").text("Next");
    }
}

updateUI();

swiper.on("slideChange", function () {
    updateUI();
});
$(".choice").click(function () {
    $(this).siblings().removeClass("selected");
    $(this).addClass("selected");
    updateUI();
});