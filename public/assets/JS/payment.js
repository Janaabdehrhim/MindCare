let methodsItems = document.querySelectorAll(".methods .item"),
    cardMethod = document.getElementById("card-method"),
    cashMethod = document.getElementById("cash-method"),
    cardDetails = document.getElementById("cardDetails"),
    fullNameInput = document.getElementById("fullName"),
    emailInput = document.getElementById("email"),
    payBtn = document.querySelector(".pay-btn"),
    successPopup = document.getElementById("successPopup"),
    closePopupBtn = document.getElementById("closePopupBtn");

cardMethod.addEventListener("click", function () {
    selectMethod("card", this);
});

cashMethod.addEventListener("click", function () {
    selectMethod("cash", this);
});


payBtn.addEventListener("click", handlePay);

closePopupBtn.addEventListener("click", function () {
    successPopup.classList.remove("active");
});

function selectMethod(type, element) {
    methodsItems.forEach(function (item) {
        item.classList.remove("selected");
    });
    element.classList.add("selected");
    if (type === "card") {
        cardDetails.classList.add("active");
    }
    else {
        cardDetails.classList.remove("active");
    }
}


function handlePay() {
    let fullName =
        fullNameInput.value.trim();
    let email =
        emailInput.value.trim();
    if (!fullName || !email) {
        alert("Please fill all fields.");
        return;
    }
    successPopup.classList.add("active");
}