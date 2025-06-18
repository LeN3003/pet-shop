// console.log("quantity.js loaded");

document.addEventListener("DOMContentLoaded", function () {
  // This block syncs quantity input for each product with localStorage.
  // - Loads quantity from server or localStorage on page load
  // - Updates localStorage when user clicks +/− or edits the input directly
  // - Helps retain quantity values across page reloads before form submission
  //this only help in updating ui ,actual quantity is updated on server using add to cart code block below
  const qtyControls = document.querySelectorAll(".quantity-control"); //qtyControls is nodelist

  //looping on each DOM node , control represnt each node, specifically div element with class as : <div class="quantity-control" >
  qtyControls.forEach((control) => {
    const minusBtn = control.querySelector(".minus");
    const plusBtn = control.querySelector(".plus");
    const input = control.querySelector(".qty-input");

    const productId = control
      .closest("form")
      .querySelector('input[name="product_id"]').value;

    //store new quantity in localstorage
    let savedQty = null;
    if (
      typeof serverCartQuantities !== "undefined" &&
      serverCartQuantities[productId]
    ) {
      savedQty = serverCartQuantities[productId];
      localStorage.setItem("qty_" + productId, savedQty); //store in local storage
    } else {
      savedQty = localStorage.getItem("qty_" + productId); //retrieve prev saved quantity from local storage
    }

    // load saved quantity from server/localStorage and update input field
    if (savedQty) {
      input.value = savedQty;
    }

    const updateLocalStorage = () => {
      localStorage.setItem("qty_" + productId, input.value);
    };

    minusBtn.addEventListener("click", () => {
      let value = parseInt(input.value); //HTML input elements store values as strings, see products.php, we convert to number
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
    //if user directly updates value in input field instead of using +/- btns
    input.addEventListener("input", updateLocalStorage);
  });

  // Handle Add to Cart form submission using AJAX
  const forms = document.querySelectorAll(".add-to-cart-form");

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // prevent the default page reload so we can handle the action with JavaScript (using AJAX)

      const input = form.querySelector(".qty-input");

      const formData = new FormData(form);
      const productId = formData.get("product_id");

      // Find existing or create a new div with class "message" inside the form for showing messages
      let messageDiv = form.querySelector(".message");
      if (!messageDiv) {
        messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        messageDiv.style.marginTop = "8px";
        form.appendChild(messageDiv);
      }
      //ajax
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
            messageDiv.textContent = "Added to cart!";
          } else {
            messageDiv.style.color = "red";
            messageDiv.textContent = "Failed to add to cart.";
          }
        })
        .catch((error) => {
          messageDiv.style.color = "red";
          messageDiv.textContent = "An error occurred.";
          console.error("Error:", error);
        });
    });
  });
});
