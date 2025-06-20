document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll(".add-to-cart-form");

  forms.forEach((form) => {
    const qtyControl = form.querySelector(".quantity-control");
    const input = qtyControl.querySelector(".qty-input");
    const minusBtn = qtyControl.querySelector(".minus");
    const plusBtn = qtyControl.querySelector(".plus");
    const productId = form.querySelector('input[name="product_id"]').value;
    const submitBtn = form.querySelector('button[type="submit"]');

    // Load cart quantities from server and store cart in localstorage as well for ui
    let serverQty = 0;
    if (
      typeof serverCartQuantities !== "undefined" &&
      serverCartQuantities[productId]
    ) {
      serverQty = serverCartQuantities[productId];
    }

    const showQuantityUI = (inCart, forceReset = false) => {
      const addBtn = form.querySelector(".add-btn");
      const removeBtn = form.querySelector(".remove-btn");

      qtyControl.style.display = inCart ? "flex" : "none";

      if (inCart) {
        addBtn.style.display = "none";
        removeBtn.style.display = "inline-block";
        if (forceReset) {
          input.value = 1;
        } else {
          const savedQty =
            serverCartQuantities[productId] ||
            localStorage.getItem("qty_" + productId) ||
            1;
          input.value = savedQty;
        }
      } else {
        addBtn.style.display = "inline-block";
        removeBtn.style.display = "none";
      }
    };

    showQuantityUI(serverQty > 0);

    const updateCart = (quantity, remove = false) => {
      const formData = new FormData();
      formData.append("product_id", productId);
      formData.append("quantity", quantity);
      if (remove) formData.append("remove", "1");

      fetch(form.action, {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            if (remove) {
              localStorage.removeItem("qty_" + productId);
              serverCartQuantities[productId] = 0;
              showQuantityUI(false, true); // reset when product is removed
            } else {
              localStorage.setItem("qty_" + productId, quantity);
              serverCartQuantities[productId] = quantity;
              showQuantityUI(true); // show updated quantity
            }
          } else {
            console.error("Failed:", data.message);
          }
        })
        .catch((err) => {
          console.error("Request error:", err);
        });
    };

    // Add to cart / Remove button handler
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (submitBtn.textContent === "Add to Cart") {
        updateCart(1);
        showQuantityUI(true);
      } else {
        updateCart(0, true);
      }
    });

    minusBtn.addEventListener("click", () => {
      let val = parseInt(input.value);
      if (val > 1) {
        val -= 1;
        input.value = val;
        updateCart(val);
      }
    });

    plusBtn.addEventListener("click", () => {
      let val = parseInt(input.value);
      val += 1;
      input.value = val;
      updateCart(val);
    });

    input.addEventListener("input", () => {
      let val = parseInt(input.value);
      if (!isNaN(val) && val >= 1) {
        updateCart(val);
      }
    });

    // Attach remove button handler for returning visitors
    const removeBtn = form.querySelector(".remove-btn");
    if (removeBtn) {
      removeBtn.addEventListener("click", () => {
        updateCart(0, true);
      });
    }
  });
});
