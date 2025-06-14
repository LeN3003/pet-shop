console.log("quantity.js loaded");

document.addEventListener("DOMContentLoaded", function () {
  const qtyControls = document.querySelectorAll(".quantity-control");

  qtyControls.forEach((control) => {
    const minusBtn = control.querySelector(".minus");
    const plusBtn = control.querySelector(".plus");
    const input = control.querySelector(".qty-input");
    const productId = control
      .closest("form")
      .querySelector('input[name="product_id"]').value;

    // Load saved quantity from localStorage
    // const savedQty = localStorage.getItem("qty_" + productId);
    // if (savedQty) {
    //   input.value = savedQty;
    // }

    // Load quantity from serverCartQuantities if available, else from localStorage
    let savedQty = null;
    if (
      typeof serverCartQuantities !== "undefined" &&
      serverCartQuantities[productId]
    ) {
      savedQty = serverCartQuantities[productId];
      localStorage.setItem("qty_" + productId, savedQty); // Optional: sync to localStorage
    } else {
      savedQty = localStorage.getItem("qty_" + productId);
    }

    if (savedQty) {
      input.value = savedQty;
    }

    //---
    const updateLocalStorage = () => {
      localStorage.setItem("qty_" + productId, input.value);
    };

    minusBtn.addEventListener("click", () => {
      let value = parseInt(input.value);
      if (value > 1) {
        input.value = value - 1;
        updateLocalStorage();
      }
    });

    plusBtn.addEventListener("click", () => {
      let value = parseInt(input.value);
      input.value = value + 1;
      updateLocalStorage();
    });

    input.addEventListener("input", updateLocalStorage);
  });

  // Handle Add to Cart form submission using AJAX
  const forms = document.querySelectorAll(".add-to-cart-form");

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(form);
      const productId = formData.get("product_id");
      const input = form.querySelector(".qty-input");

      let messageDiv = form.querySelector(".message");
      if (!messageDiv) {
        messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.style.marginTop = "8px";
        form.appendChild(messageDiv);
      }

      fetch(form.action, {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            messageDiv.style.color = "green";
            messageDiv.textContent = "✅ Added to cart!";
            // Keep the quantity, do not reset
          } else {
            messageDiv.style.color = "red";
            messageDiv.textContent = "❌ Failed to add to cart.";
          }
        })
        .catch((error) => {
          messageDiv.style.color = "red";
          messageDiv.textContent = "❌ An error occurred.";
          console.error("Error:", error);
        });
    });
  });
});
