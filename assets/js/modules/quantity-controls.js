document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll(".add-to-cart-form");

  forms.forEach((form) => {
    const minusBtn = form.querySelector(".qty-btn.minus");
    const plusBtn = form.querySelector(".qty-btn.plus");
    const qtyInput = form.querySelector(".qty-input");

    minusBtn.addEventListener("click", function () {
      let current = parseInt(qtyInput.value) || 1;
      if (current > 1) qtyInput.value = current - 1;
    });

    plusBtn.addEventListener("click", function () {
      let current = parseInt(qtyInput.value) || 1;
      qtyInput.value = current + 1;
    });
  });
});
