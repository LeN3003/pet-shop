// document.addEventListener("DOMContentLoaded", function () {
//   // This block syncs quantity input for each product with localStorage.
//   // - Loads quantity from server or localStorage on page load
//   // - Updates localStorage when user clicks +/− or edits the input directly
//   // - Helps retain quantity values across page reloads before form submission
//   //this only help in updating ui ,actual quantity is updated on server using add to cart code block below
//   const qtyControls = document.querySelectorAll(".quantity-control"); //qtyControls is nodelist

//   //looping on each DOM node , control represnt each node, specifically div element with class as : <div class="quantity-control" >
//   qtyControls.forEach((control) => {
//     const minusBtn = control.querySelector(".minus");
//     const plusBtn = control.querySelector(".plus");
//     const input = control.querySelector(".qty-input");

//     const productId = control
//       .closest("form")
//       .querySelector('input[name="product_id"]').value;

//     //store new quantity in localstorage
//     let savedQty = null;
//     if (
//       typeof serverCartQuantities !== "undefined" &&
//       serverCartQuantities[productId]
//     ) {
//       savedQty = serverCartQuantities[productId];
//       localStorage.setItem("qty_" + productId, savedQty); //store in local storage
//     } else {
//       savedQty = localStorage.getItem("qty_" + productId); //retrieve prev saved quantity from local storage
//     }

//     // load saved quantity from server/localStorage and update input field
//     if (savedQty) {
//       input.value = savedQty;
//     }

//     const updateLocalStorage = () => {
//       localStorage.setItem("qty_" + productId, input.value);
//     };

//     minusBtn.addEventListener("click", () => {
//       let value = parseInt(input.value); //HTML input elements store values as strings, see products.php, we convert to number
//       if (value > 1) {
//         input.value = value - 1;
//         updateLocalStorage();
//       }
//     });

//     plusBtn.addEventListener("click", () => {
//       let value = parseInt(input.value);
//       input.value = value + 1;
//       updateLocalStorage();
//     });
//     //if user directly updates value in input field instead of using +/- btns
//     input.addEventListener("input", updateLocalStorage);
//   });

//   // Handle Add to Cart form submission using AJAX
//   const forms = document.querySelectorAll(".add-to-cart-form");

//   forms.forEach((form) => {
//     form.addEventListener("submit", function (e) {
//       e.preventDefault(); // prevent the default page reload so we can handle the action with JavaScript (using AJAX)

//       const input = form.querySelector(".qty-input");

//       const formData = new FormData(form);
//       const productId = formData.get("product_id");

//       // Find existing or create a new div with class "message" inside the form for showing messages
//       let messageDiv = form.querySelector(".message");
//       if (!messageDiv) {
//         messageDiv = document.createElement("div");
//         messageDiv.classList.add("message");
//         messageDiv.style.marginTop = "8px";
//         form.appendChild(messageDiv);
//       }
//       //ajax
//       fetch(form.action, {
//         method: "POST",
//         headers: {
//           "X-Requested-With": "XMLHttpRequest",
//         },
//         body: formData,
//       })
//         .then((response) => response.json())
//         // .then((data) => {
//         //   if (data.success) {
//         //     messageDiv.style.color = "green";
//         //     messageDiv.textContent = "Added to cart!";
//         //   } else {
//         //     messageDiv.style.color = "red";
//         //     messageDiv.textContent = "Failed to add to cart.";
//         //   }
//         // })

//         .then((data) => {
//           if (data.success) {
//             messageDiv.style.color = "green";
//             messageDiv.textContent = data.message;
//             const button = form.querySelector("button[type=submit]");
//             if (form.querySelector("input[name=remove]")) {
//               button.textContent = "Add to Cart";
//               form.removeChild(form.querySelector("input[name=remove]"));
//             } else {
//               button.textContent = "Remove";
//               const removeInput = document.createElement("input");
//               removeInput.type = "hidden";
//               removeInput.name = "remove";
//               form.appendChild(removeInput);
//             }
//           } else {
//             messageDiv.style.color = "red";
//             messageDiv.textContent = "Failed to update cart.";
//           }
//         })
//         .catch((error) => {
//           messageDiv.style.color = "red";
//           messageDiv.textContent = "An error occurred.";
//           console.error("Error:", error);
//         });
//     });
//   });
// });

document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll(".add-to-cart-form");

  forms.forEach((form) => {
    const qtyControl = form.querySelector(".quantity-control");
    const input = qtyControl.querySelector(".qty-input");
    const minusBtn = qtyControl.querySelector(".minus");
    const plusBtn = qtyControl.querySelector(".plus");
    const productId = form.querySelector('input[name="product_id"]').value;
    const submitBtn = form.querySelector('button[type="submit"]');

    // Load cart quantities from server
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
              showQuantityUI(false, true); // reset when hidden
            } else {
              localStorage.setItem("qty_" + productId, quantity);
              serverCartQuantities[productId] = quantity;
              showQuantityUI(true); // show with correct quantity
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
