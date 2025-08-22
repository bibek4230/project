let cart = [];
let filteredProducts = [];
let str;
let tc = 1;
datafetch();
updateCartCount(); // Initialize cart count on page load

function login() {
  setTimeout(() => {
    document.getElementById("welcome").style.display = "none";
    document.getElementById("pra4").style.display = "block";
    document.getElementById("pra5").style.display = "none";
    document.getElementById("pra10").style.display = "none";
  }, 2000);
}
function signup() {
  setTimeout(() => {
    document.getElementById("welcome").style.display = "none";
    document.getElementById("pra4").style.display = "none";
    document.getElementById("pra5").style.display = "block";
    document.getElementById("pra10").style.display = "none";
  }, 2000);
}
function admin() {
  setTimeout(() => {
    document.getElementById("welcome").style.display = "none";
    document.getElementById("pra4").style.display = "none";
    document.getElementById("pra5").style.display = "none";
    document.getElementById("pra10").style.display = "block";
  }, 2000);
}
function home() {
  window.location.href = "prabin.php";
}
function home1() {
  window.location.href = "adminmain.php";
}
function mainpage() {
  window.location.href = "logout.php";
}
function esewa(pid) {
  window.location.href = "esewa.php?pid=" + pid;
}
function esewa1(pid) {
  window.location.href = "esewa1.php?pid=" + pid;
}

function display() {
  document.getElementById("pra18").style.display = "block";
  document.getElementById("pra20").style.display = "none";
}

function second() {
  var current = document.getElementById("pra25").value;
  if (current === "high") {
    document.getElementById("pra26").value = "low1";
  } else {
    document.getElementById("pra26").value = "high1";
  }
}
function filter() {
  document.getElementById("pra24").style.display = "block";
  document.getElementById("pra29").style.display = "none";
}
function filter1() {
  document.getElementById("pra29").style.display = "flex";
  document.getElementById("pra24").style.display = "none";
}
function addToCart1() {
  document.getElementById("pra35").style.display = "block";
}
function addToCart(productId) {
  // Add visual feedback
  const button = event.target;
  const originalText = button.innerHTML;
  button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
  button.disabled = true;

  $.ajax({
    url: "cart.php",
    method: "POST",
    data: { pid: productId },
    dataType: "json",
    success: function (res) {
      // Show success message
      showNotification(`${res[0].name} added to cart!`, "success");

      // Update cart count and show cart
      updateCartCount();
      showCartSidebar();

      // Reset button
      button.innerHTML = originalText;
      button.disabled = false;
    },
    error: function (xhr, status, error) {
      console.error("Cart error:", error);
      showNotification("Error adding product to cart", "error");

      // Reset button
      button.innerHTML = originalText;
      button.disabled = false;
    },
  });
}
function second1() {
  var current = document.getElementById("pra26").value;
  if (current === "high1") {
    document.getElementById("pra25").value = "low";
  } else {
    document.getElementById("pra25").value = "high";
  }
}

function fa() {
  $(document).ready(function () {
    let pn = $("#pra19").val();
    $.ajax({
      url: "search.php",
      method: "POST",
      data: { pname: pn },
      dataType: "json",
      success: function (data) {
        $("#pra18").css("z-index", 6);
        $("#pra31").css("display", "block");
        $("#pra23").css("display", "none");
        $("#pra28").css("display", "none");
        $("#pra32").css("display", "block");
        $("#pra32").html("");
        for (let i = 0; i < data.length; i++) {
          $("#pra32").append(
            '<a href="#" onclick="pra(\'' +
              data[i] +
              "')\">" +
              data[i] +
              "</a><br>"
          );
        }
        $("#pra32").css("font-size", "35px");
        $("#pra32").css("color", "green");
        if (data.length === 0) {
          $("#pra29").css("display", "flex");
          $("#pra32").css("display", "none");
          $("#pra23").css("display", "flex");
          $("#pra28").css("display", "flex");
        }
      },
    });
  });
}
//search anchor logic starts here

//search andchor logic ends here

function upload(type) {
  if (type === "home") {
    window.location.href = "upload.php";
  }
  if (type === "admin") {
    window.location.href = "upload.php";
  }
}

function hideUnhide() {
  document.getElementById("pra24").style.display = "none";
  document.getElementById("pra32").style.display = "none";
  document.getElementById("pra29").style.display = "flex";
  document.getElementById("pra23").style.display = "flex";
  document.getElementById("pra28").style.display = "flex";
}
function pra(data) {
  document.getElementById("pra32").style.display = "none";
  document.getElementById("pra20").style.display = "flex";
  document.getElementById("pra29").style.display = "flex";
  document.getElementById("pra23").style.display = "flex";
  document.getElementById("pra28").style.display = "flex";
  document.getElementById("pra19").value = "";

  let pn = data;
  $(document).ready(function () {
    $.ajax({
      url: "display.php",
      method: "POST",
      data: { pname: pn },
      dataType: "text",
      success: function (data) {
        console.log(data);
        $("#pra18").css("z-index", 6);
        $("#pra31").css("display", "block");
        $("#pra23").css("display", "flex");
        $("#pra28").css("display", "flex");
        $("#pra29").css("display", "flex");
        $("#pra32").css("display", "none");
        $("#pra34").html("");
        $("#pra34").html(data);
        $("#pra32").css("font-size", "35px");
        $("#pra32").css("color", "green");
      },
    });
  });
}
const products = [];
function datafetch() {
  $(document).ready(function () {
    $.ajax({
      url: "display1.php",
      method: "POST",
      dataType: "json",
      success: function (res) {
        res.forEach((element) => {
          products.push(element);
        });

        filteredProducts = [...products];
        init();
      },
    });
  });
}
// Initialize the page
function init() {
  displayProducts(filteredProducts);
  updateCartCount();
  starrating();
  recommendation();
}

// Display products in grid
function displayProducts(productsToShow) {
  const grid = document.getElementById("productsGrid");

  // Check if the grid element exists
  if (!grid) {
    console.error("Products grid element not found");
    return;
  }

  // Check if productsToShow is valid
  if (!productsToShow || !Array.isArray(productsToShow)) {
    console.error("Invalid products data:", productsToShow);
    grid.innerHTML = '<div class="no-products">No products to display</div>';
    return;
  }

  grid.innerHTML = "";

  productsToShow.forEach((product) => {
    const productCard = createProductCard(product);
    if (productCard) {
      grid.appendChild(productCard);
    }
  });
}
//Star rating function starts here

function rating(productId, number, username) {
  $.ajax({
    url: "star.php",
    method: "POST",
    data: {
      pid: productId,
      qty: number,
      uname: username,
    },
    dataType: "json",
    success: function (res) {
      let num = res.cstar;
      let pid = res.pid;
      if (num === null) {
        exit(0);
      }
      if (num == 1) {
        document.getElementById(`star1${pid}`).style.color = "gold";
        document.getElementById(`star2${pid}`).style.color = "lightgray";
        document.getElementById(`star3${pid}`).style.color = "lightgray";
        document.getElementById(`star4${pid}`).style.color = "lightgray";
        document.getElementById(`star5${pid}`).style.color = "lightgray";
      }
      if (num == 2) {
        document.getElementById(`star1${pid}`).style.color = "gold";
        document.getElementById(`star2${pid}`).style.color = "gold";
        document.getElementById(`star3${pid}`).style.color = "lightgray";
        document.getElementById(`star4${pid}`).style.color = "lightgray";
        document.getElementById(`star5${pid}`).style.color = "lightgray";
      }
      if (num == 3) {
        document.getElementById(`star1${pid}`).style.color = "gold";
        document.getElementById(`star2${pid}`).style.color = "gold";
        document.getElementById(`star3${pid}`).style.color = "gold";
        document.getElementById(`star4${pid}`).style.color = "lightgray";
        document.getElementById(`star5${pid}`).style.color = "lightgray";
      }
      if (num == 4) {
        document.getElementById(`star1${pid}`).style.color = "gold";
        document.getElementById(`star2${pid}`).style.color = "gold";
        document.getElementById(`star3${pid}`).style.color = "gold";
        document.getElementById(`star4${pid}`).style.color = "gold";
        document.getElementById(`star5${pid}`).style.color = "lightgray";
      }
      if (num == 5) {
        document.getElementById(`star1${pid}`).style.color = "gold";
        document.getElementById(`star2${pid}`).style.color = "gold";
        document.getElementById(`star3${pid}`).style.color = "gold";
        document.getElementById(`star4${pid}`).style.color = "gold";
        document.getElementById(`star5${pid}`).style.color = "gold";
      }
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}

//star rating function ends here
//star rating initialization function starts here
function starrating() {
  $.ajax({
    url: "star1.php",
    method: "GET",
    dataType: "json",
    success: function (res) {
      res.forEach((item, i) => {
        let k = parseInt(item.cstar);
        console.log(item.pid);
        if (k == 1) {
          document.getElementById(`star1${item.pid}`).style.color = "gold";
          document.getElementById(`star2${item.pid}`).style.color = "lightgray";
          document.getElementById(`star3${item.pid}`).style.color = "lightgray";
          document.getElementById(`star4${item.pid}`).style.color = "lightgray";
          document.getElementById(`star5${item.pid}`).style.color = "lightgray";
        }
        if (k == 2) {
          document.getElementById(`star1${item.pid}`).style.color = "gold";
          document.getElementById(`star2${item.pid}`).style.color = "gold";
          document.getElementById(`star3${item.pid}`).style.color = "lightgray";
          document.getElementById(`star4${item.pid}`).style.color = "lightgray";
          document.getElementById(`star5${item.pid}`).style.color = "lightgray";
        }
        if (k == 3) {
          document.getElementById(`star1${item.pid}`).style.color = "gold";
          document.getElementById(`star2${item.pid}`).style.color = "gold";
          document.getElementById(`star3${item.pid}`).style.color = "gold";
          document.getElementById(`star4${item.pid}`).style.color = "lightgray";
          document.getElementById(`star5${item.pid}`).style.color = "lightgray";
        }
        if (k == 4) {
          document.getElementById(`star1${item.pid}`).style.color = "gold";
          document.getElementById(`star2${item.pid}`).style.color = "gold";
          document.getElementById(`star3${item.pid}`).style.color = "gold";
          document.getElementById(`star4${item.pid}`).style.color = "gold";
          document.getElementById(`star5${item.pid}`).style.color = "lightgray";
        }
        if (k == 5) {
          document.getElementById(`star1${item.pid}`).style.color = "gold";
          document.getElementById(`star2${item.pid}`).style.color = "gold";
          document.getElementById(`star3${item.pid}`).style.color = "gold";
          document.getElementById(`star4${item.pid}`).style.color = "gold";
          document.getElementById(`star5${item.pid}`).style.color = "gold";
        }
      });
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}

// Enhanced cart and notification functions
function showNotification(message, type = "info") {
  // Remove existing notifications
  const existingNotif = document.querySelector(".notification");
  if (existingNotif) existingNotif.remove();

  const notification = document.createElement("div");
  notification.className = `notification notification-${type}`;
  notification.innerHTML = `
    <div class="notification-content">
      <i class="fas ${
        type === "success"
          ? "fa-check-circle"
          : type === "error"
          ? "fa-exclamation-triangle"
          : "fa-info-circle"
      }"></i>
      <span>${message}</span>
      <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
        <i class="fas fa-times"></i>
      </button>
    </div>
  `;

  document.body.appendChild(notification);

  // Auto remove after 3 seconds
  setTimeout(() => {
    if (notification.parentNode) {
      notification.remove();
    }
  }, 3000);
}

function showCartSidebar() {
  const cartOverlay = document.getElementById("cartOverlay");
  const cartSidebar = document.getElementById("cartSidebar");

  if (cartOverlay && cartSidebar) {
    cartOverlay.classList.add("active");
    cartSidebar.classList.add("active");
    loadCartItems();
  }
}

function loadCartItems() {
  $.ajax({
    url: "cart1.php",
    method: "POST",
    dataType: "json",
    success: function (res) {
      const cartBody = document.getElementById("cartBody");
      if (!cartBody) return;

      if (res.length === 0) {
        cartBody.innerHTML = `
          <div class="cart-empty">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Add some products to get started!</p>
            <button class="continue-shopping-btn" onclick="toggleCart()">
              <i class="fas fa-arrow-left"></i>
              Continue Shopping
            </button>
          </div>
        `;
        document.getElementById("cartFooter").style.display = "none";
      } else {
        let cartHTML = '<div class="cart-items">';
        let total = 0;

        res.forEach((item) => {
          const itemTotal = item.price * item.qty;
          total += itemTotal;

          cartHTML += `
            <div class="cart-item" data-id="${item.id}">
              <img src="${item.image}" alt="${
            item.name
          }" class="cart-item-image">
              <div class="cart-item-content">
                <h4 class="cart-item-name">${item.name}</h4>
                <p class="cart-item-category">${item.category}</p>
                <div class="cart-item-price">Rs. ${item.price}</div>
                <div class="cart-item-controls">
                  <button class="quantity-btn" onclick="updateQuantity(${
                    item.id
                  }, ${item.qty - 1})">
                    <i class="fas fa-minus"></i>
                  </button>
                  <span class="quantity-display">${item.qty}</span>
                  <button class="quantity-btn" onclick="updateQuantity(${
                    item.id
                  }, ${item.qty + 1})">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button class="remove-btn" onclick="removeFromCart(${
                    item.id
                  })">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          `;
        });

        cartHTML += "</div>";
        cartBody.innerHTML = cartHTML;

        // Update footer
        const cartFooter = document.getElementById("cartFooter");
        if (cartFooter) {
          cartFooter.style.display = "block";
          document.getElementById(
            "cartSubtotal"
          ).textContent = `Rs. ${total.toFixed(2)}`;
          document.getElementById("cartTax").textContent = `Rs. ${(
            total * 0.13
          ).toFixed(2)}`;
          document.getElementById("cartTotal").textContent = `Rs. ${(
            total * 1.13
          ).toFixed(2)}`;
        }
      }

      updateCartCount();
    },
    error: function () {
      showNotification("Error loading cart items", "error");
    },
  });
}

function updateQuantity(productId, newQty) {
  if (newQty <= 0) {
    removeFromCart(productId);
    return;
  }

  $.ajax({
    url: "update_cart_qty.php",
    method: "POST",
    data: { pid: productId, qty: newQty },
    dataType: "json",
    success: function (res) {
      if (res.success) {
        loadCartItems();
        showNotification("Quantity updated", "success");
      } else {
        showNotification("Error updating quantity", "error");
      }
    },
    error: function () {
      showNotification("Error updating quantity", "error");
    },
  });
}

function removeFromCart(productId) {
  if (confirm("Remove this item from cart?")) {
    $.ajax({
      url: "del.php", // Using existing del.php file
      method: "POST",
      data: { pid: productId },
      success: function () {
        loadCartItems();
        showNotification("Item removed from cart", "success");
      },
      error: function () {
        showNotification("Error removing item", "error");
      },
    });
  }
}

//star rating initialization function ends here
// Create product card element
function createProductCard(product) {
  // Validate product data
  if (!product || typeof product !== "object") {
    console.error("Invalid product data:", product);
    return null;
  }

  const card = document.createElement("div");
  card.className = "product-card";

  const stockStatus = getStockStatus(product.stock || 0);
  if (pageType == 2) {
    card.innerHTML = `
                <div class="product-image">
                    <img src="${
                      product.image || "images/placeholder.jpg"
                    }" alt="${product.name || "Product"}">
                    <div class="product-badge ${stockStatus.class}">
                        ${stockStatus.text}
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">${
                      product.name || "Unnamed Product"
                    }</h3>
                    <p class="product-description">${
                      product.description || ""
                    }</p>
                    <div class="product-price">Rs. ${product.price || 0}</div>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart(${
                          product.id || 0
                        })" ${(product.stock || 0) === 0 ? "disabled" : ""}>
                            <i class="fas fa-shopping-cart"></i>
                            ${
                              (product.stock || 0) === 0
                                ? "Out of Stock"
                                : "Add to Cart"
                            }
                        </button>
                        <button class="esewa-btn" onclick="esewa(${
                          product.id
                        })" ${product.stock === 0 ? "disabled" : ""}>
                            <i class="fas fa-credit-card"></i>
                            ${
                              product.stock === 0 ? "Out of Stock" : "eSewa Pay"
                            }
                        </button>
                    </div>
                    <div class="product-rating">
                        <h6>Rate this product</h6>
                        <div class="stars">
                            <span class="star" id="star1${
                              product.id
                            }" onclick="rating('${
      product.id
    }',1,'${uname}')">&#9733;</span>
                            <span class="star" id="star2${
                              product.id
                            }" onclick="rating('${
      product.id
    }',2,'${uname}')">&#9733;</span>
                            <span class="star" id="star3${
                              product.id
                            }" onclick="rating('${
      product.id
    }',3,'${uname}')">&#9733;</span>
                            <span class="star" id="star4${
                              product.id
                            }" onclick="rating('${
      product.id
    }',4,'${uname}')">&#9733;</span>
                            <span class="star" id="star5${
                              product.id
                            }" onclick="rating('${
      product.id
    }',5,'${uname}')">&#9733;</span>
                        </div>
                    </div>
                </div>
            `;
  }
  if (pageType == 1) {
    card.innerHTML = `
                <div class="product-image">
                    <img src="${product.image}" alt="${product.name}">
                    <div class="product-badge ${stockStatus.class}">
                        ${stockStatus.text}
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">${product.name}</h3>
                    <p class="product-description">${product.description}</p>
                    <div class="product-price">Rs. ${product.price}</div>
                    <div class="product-actions">
                        <button class="delete-btn" onclick="adminDel(${product.id})">
                            <i class="fas fa-trash"></i>
                            Delete Product
                        </button>
                    </div>
                    <div class="product-rating">
                        <h6>Product Rating</h6>
                        <div class="stars">
                            <span class="star" id="star1${product.id}" onclick="rating('${product.id}',1,'${uname}')">&#9733;</span>
                            <span class="star" id="star2${product.id}" onclick="rating('${product.id}',2,'${uname}')">&#9733;</span>
                            <span class="star" id="star3${product.id}" onclick="rating('${product.id}',3,'${uname}')">&#9733;</span>
                            <span class="star" id="star4${product.id}" onclick="rating('${product.id}',4,'${uname}')">&#9733;</span>
                            <span class="star" id="star5${product.id}" onclick="rating('${product.id}',5,'${uname}')">&#9733;</span>
                        </div>
                    </div>
                </div>
            `;
  }

  return card;
}
function adminDel(dat) {
  let productId = dat;
  $.ajax({
    url: "admindel.php",
    method: "POST",
    data: {
      pid: productId,
    },
    dataType: "json",
    success: function (res) {
      alert(res);
      window.location.href = "adminmain.php";
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}

// Get stock status
function getStockStatus(stock) {
  if (stock === 0) {
    return { class: "out-of-stock", text: "Out of Stock" };
  } else if (stock < 10) {
    return { class: "low-stock", text: `Low Stock (${stock} left)` };
  } else {
    return { class: "in-stock", text: `In Stock (${stock} available)` };
  }
}
// Update cart count
function updateCartCount() {
  $.ajax({
    url: "cart1.php",
    method: "POST",
    dataType: "json",
    success: function (res) {
      const cartCount = document.getElementById("cartCount");
      if (cartCount) {
        const totalItems = res.reduce((total, item) => total + item.qty, 0);
        cartCount.textContent = totalItems;

        // Show/hide cart count badge
        if (totalItems > 0) {
          cartCount.style.display = "flex";
        } else {
          cartCount.style.display = "none";
        }
      }
    },
    error: function () {
      console.error("Error updating cart count");
    },
  });
}
//Recommendation div logic starts here
function recommendation() {
  $.ajax({
    url: "recommendation.php",
    method: "POST",
    dataType: "json",
    success: function (res) {
      const recommendationDiv =
        document.getElementsByClassName("recommendation-div")[0];

      if (res.length > 0) {
        recommendationDiv.innerHTML = "";

        const recommendationContainer = document.createElement("div");
        recommendationContainer.className = "recommendation-container";
        recommendationContainer.innerHTML = `
                    <div style="
                        display: flex; 
                        justify-content: space-between; 
                        align-items: center; 
                        padding: 10px 20px; 
                        background-color: inherit;
                        color: #333;
                    ">
                        <h3 style="margin: 0;">Recommended Products</h3>
                        <div 
                            onclick="document.getElementsByClassName('recommendation-div')[0].style.display='none'" 
                            style="
                                height: 50px; 
                                width: 50px; 
                                border-radius: 50%; 
                                overflow: hidden; 
                                cursor: pointer;
                                background-color: #eee;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                            <img src="../images/close.jpg" style="height: 100%; width: 100%; object-fit: cover;" />
                        </div>
                    </div>
                `;

        const recommendationGrid = document.createElement("div");
        recommendationGrid.style.display = "flex";
        recommendationGrid.style.justifyContent = "space-between";
        recommendationGrid.style.gap = "10px";
        recommendationGrid.style.padding = "20px";

        res.slice(0, 3).forEach((product) => {
          const productCard = createProductCard(product);
          productCard.style.flex = "0 0 32%"; // Make each card occupy 32% of container
          recommendationGrid.appendChild(productCard);
        });

        recommendationContainer.appendChild(recommendationGrid);
        recommendationDiv.appendChild(recommendationContainer);
        recommendationDiv.style.display = "flex";

        setTimeout(() => {
          starrating();
        }, 100);
      }
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}

//Recommendation div logic ends here
// Toggle cart (enhanced function)
function toggleCart() {
  const cartOverlay = document.getElementById("cartOverlay");
  const cartSidebar = document.getElementById("cartSidebar");

  if (cartOverlay && cartSidebar) {
    cartOverlay.classList.toggle("active");
    cartSidebar.classList.toggle("active");

    if (cartSidebar.classList.contains("active")) {
      loadCartItems();
    }
  }
}
function cHideUnhide() {
  if (tc % 2 == 0) {
    document.getElementsByClassName("cart-div")[0].style.display = "none";
    tc = 0;
  } else {
    document.getElementsByClassName("cart-div")[0].style.display = "block";
    document.getElementsByClassName("cart-div")[0].innerHTML = str;
    str = "";
  }
  tc++;
}
//cart to add the qty by one unit per click
function increase(pid) {
  let productId = pid;
  $.ajax({
    url: "qtyinc.php",
    method: "POST",
    data: {
      pid: productId,
    },
    dataType: "json",
    success: function (res) {
      if (res == "exit") {
        alert(`Exceeds the stock limit`);
      } else {
        document.getElementById(`qtyspan-${pid}`).innerText = res;
      }
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}
function decrease(pid) {
  let productId = pid;
  $.ajax({
    url: "qtydec.php",
    method: "POST",
    data: {
      pid: productId,
    },
    dataType: "json",
    success: function (res) {
      if (res == "exit") {
        alert("Low on stock");
      } else {
        document.getElementById(`qtyspan-${pid}`).innerText = res;
      }
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}
function del(pid) {
  let productId = pid;
  $.ajax({
    url: "del.php",
    method: "POST",
    data: {
      pid: productId,
    },
    dataType: "json",
    success: function (res) {
      cHideUnhide();
      toggleCart();
      updateCartCount();
      alert("Item removed from cart");
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}

// Search functionality
document.getElementById("searchInput").addEventListener("input", function (e) {
  const searchTerm = e.target.value.toLowerCase();
  filterProducts();
});

// Category filter
document
  .getElementById("categoryFilter")
  .addEventListener("change", function (e) {
    filterProducts();
  });

// Filter products based on search and category
function filterProducts() {
  const searchTerm = document.getElementById("searchInput").value.toLowerCase();
  const selectedCategory = document.getElementById("categoryFilter").value;

  filteredProducts = products.filter((product) => {
    const matchesSearch =
      product.name.toLowerCase().includes(searchTerm) ||
      product.description.toLowerCase().includes(searchTerm);
    const matchesCategory =
      selectedCategory === "" || product.category === selectedCategory;

    return matchesSearch && matchesCategory;
  });

  displayProducts(filteredProducts);
}

document.addEventListener("DOMContentLoaded", function () {
  // Add ripple effect to buttons
  const buttons = document.querySelectorAll(".submit-btn, .newbtnstyle");
  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const ripple = document.createElement("span");
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;

      ripple.style.width = ripple.style.height = size + "px";
      ripple.style.left = x + "px";
      ripple.style.top = y + "px";
      ripple.classList.add("ripple");

      this.appendChild(ripple);

      setTimeout(() => {
        ripple.remove();
      }, 600);
    });
  });
});

function mainpage() {
  let result = confirm("Confirm Logout?");

  if (result) {
    window.location.href = "index.php";
  } else {
    exit(0);
  }
}
let j = 0;
function dispfilter() {
  if (j % 2 == 0) {
    j = 0;
    document.getElementsByClassName("filter-div")[0].style.display = "block";
  } else {
    document.getElementsByClassName("filter-div")[0].style.display = "none";
  }

  j++;
}
function change() {
  let sv = document.getElementById("sliderRange").value;
  document.getElementById("demo").innerHTML = sv;
}
function sortFilter(sortType = null) {
  document.getElementsByClassName("filter-div")[0].style.display = "none";
  let name = document.getElementById("pname").value;
  let category = document.getElementById("cfilter").value;
  let price = document.getElementById("pra25").value;
  let range = document.getElementById("sliderRange").value;

  // Clear form values
  document.getElementById("pname").value = "";
  document.getElementById("cfilter").value = "";
  document.getElementById("pra25").value = "";
  document.getElementById("sliderRange").value = 1;
  document.getElementById("demo").innerHTML = "1";

  // Use sort endpoint if sorting is requested
  const endpoint = sortType ? "sort_products.php" : "filter.php";
  const data = sortType
    ? {
        sort: sortType,
        search: name,
        category: category,
        minPrice: 0,
        maxPrice: range,
      }
    : {
        pname: name,
        price: price,
        cfilter: category,
        range: range,
      };

  $.ajax({
    url: endpoint,
    method: "POST",
    data: data,
    dataType: "json",
    success: function (res) {
      if (sortType && res.status === "success") {
        displayProducts(res.products);
      } else if (!sortType) {
        displayProducts(res);
      } else {
        console.error("Filter/Sort error:", res.message);
      }
    },
  });
}

function validation() {
  for (let i = 1; i <= 9; i++) {
    let msgElement = document.getElementById("msg" + i);
    if (msgElement) {
      msgElement.style.display = "none";
    }
  }
  let a = document.getElementsByName("sfname")[0].value;
  let j = document.getElementsByName("smname")[0].value;
  let b = document.getElementsByName("slname")[0].value;
  let d = document.getElementsByName("smobile")[0].value;
  let e = document.getElementsByName("saddress")[0].value;
  let fa = document.getElementsByName("suname")[0].value;
  let fb = document.getElementsByName("semail")[0].value;
  let rval = document.querySelector('input[name="sgender"]:checked');
  let g = document.getElementsByName("spwd")[0].value;
  let h = document.getElementsByName("spwd1")[0]
    ? document.getElementsByName("spwd")[0].value
    : g;
  let i = document.querySelector('input[name="sterms"]:checked');
  //firstname Validation logic
  if (a === "") {
    document.getElementById("msg1").innerText =
      "First name must be more than 2 character consisting only alphabets";
    document.getElementById("msg1").style.color = "red";
    document.getElementById("msg1").style.display = "block";
    return false;
  }
  if (!a.match(/^[a-zA-Z]{3,}$/)) {
    document.getElementById("msg1").innerText =
      "First name must be more than 2 character consisting only alphabets";
    document.getElementById("msg1").style.color = "red";
    document.getElementById("msg1").style.display = "block";
    return false;
  }
  //middle name validation
  if (j !== "" && !j.match(/^[a-zA-Z]{3,}$/)) {
    document.getElementById("msg2").innerText =
      "Middle name must be more than 2 character consisting only alphabets";
    document.getElementById("msg2").style.color = "red";
    document.getElementById("msg2").style.display = "block";
    return false;
  }
  //last name validation
  if (b === "") {
    document.getElementById("msg3").innerText =
      "Last name must be more than 2 character consisting only alphabets";
    document.getElementById("msg3").style.color = "red";
    document.getElementById("msg3").style.display = "block";
    return false;
  }
  if (!b.match(/^[a-zA-Z]{3,}$/)) {
    document.getElementById("msg3").innerText =
      "Last name must be more than 2 character consisting only alphabets";
    document.getElementById("msg3").style.color = "red";
    document.getElementById("msg3").style.display = "block";
    return false;
  }
  //gender Validation
  if (rval == null) {
    alert("Please select the gender");
    return false;
  }
  //mobile no validation
  if (d === "") {
    document.getElementById("msg4").innerText =
      "This field cannot be empty please enter your valid phone number";
    document.getElementById("msg4").style.color = "red";
    document.getElementById("msg4").style.display = "block";
    return false;
  }
  if (isNaN(d)) {
    document.getElementById("msg4").innerText =
      "Mobile number cannot contain other characters than digits.";
    document.getElementById("msg4").style.color = "red";
    document.getElementById("msg4").style.display = "block";
    return false;
  }
  if (!(d.startsWith("98") || d.startsWith("97"))) {
    document.getElementById("msg4").innerText =
      "Mobile number always should start with 98 or 97";
    document.getElementById("msg4").style.color = "red";
    document.getElementById("msg4").style.display = "block";
    return false;
  }
  if (d.length !== 10) {
    document.getElementById("msg4").innerText =
      "Mobile number must be of length of 10 digits.";
    document.getElementById("msg4").style.color = "red";
    document.getElementById("msg4").style.display = "block";
    return false;
  }
  //Address validation
  if (e === "") {
    document.getElementById("msg5").innerText =
      "This field cannot be empty please enter your valid address";
    document.getElementById("msg5").style.color = "red";
    document.getElementById("msg5").style.display = "block";
    return false;
  }
  if (!e.match(/^[A-Za-z]{4,15}-\d{1,2} [A-Za-z]{2,15},[ ]?[nN]epal$/)) {
    document.getElementById("msg5").innerText =
      "please match the pattern [chainpur-1 chitwan,nepal]";
    document.getElementById("msg5").style.color = "red";
    document.getElementById("msg5").style.display = "block";
    return false;
  }
  //Username Validation
  if (fa == "") {
    document.getElementById("msg6").innerText =
      "This field cannot be empty please enter your username";
    document.getElementById("msg6").style.color = "red";
    document.getElementById("msg6").style.display = "block";
    return false;
  }
  if (fa.length <= 4) {
    document.getElementById("msg6").innerText =
      "Username must be of more than 4 character.";
    document.getElementById("msg6").style.color = "red";
    document.getElementById("msg6").style.display = "block";
    return false;
  }
  //Email Validation
  if (fb === "") {
    document.getElementById("msg7").innerText =
      "This field cannot be empty please enter your valid email";
    document.getElementById("msg7").style.color = "red";
    document.getElementById("msg7").style.display = "block";
    return false;
  }
  if (!fb.match(/^[\w.%+-]+@[\w.-]+\.[A-Za-z]{2,}$/)) {
    document.getElementById("msg7").innerHTML =
      "Your email couldn't validate. Please enter the valid Email.";
    document.getElementById("msg7").style.color = "red";
    document.getElementById("msg7").style.display = "block";
    return false;
  }
  // Password validation
  if (g === "") {
    document.getElementById("msg8").innerHTML =
      "This field cannot be empty please enter your password";
    document.getElementById("msg8").style.color = "red";
    document.getElementById("msg8").style.display = "block";
    return false;
  }
  if (g.length <= 5) {
    document.getElementById("msg8").innerHTML =
      "Password must be minimum of 6 characters.";
    document.getElementById("msg8").style.color = "red";
    document.getElementById("msg8").style.display = "block";
    return false;
  }
  // Check confirm password if it exists
  if (document.getElementsByName("spwd")[0] && h === "") {
    document.getElementById("msg9").innerHTML =
      "This field cannot be empty please repeat the password you entered above";
    document.getElementById("msg9").style.color = "red";
    document.getElementById("msg9").style.display = "block";
    return false;
  }
  // Password match validation if confirm password exists
  if (document.getElementsByName("spwd1")[0] && g !== h) {
    document.getElementById("msg8").innerHTML = "Your password didn't match.";
    document.getElementById("msg9").innerHTML = "Your password didn't match.";
    document.getElementById("msg8").style.color = "red";
    document.getElementById("msg9").style.color = "red";
    document.getElementById("msg8").style.display = "block";
    document.getElementById("msg9").style.display = "block";
    return false;
  }
  // Terms validation if it exists
  if (document.querySelector('input[name="sterms"]') && !i) {
    alert("Please agree to our terms and conditions.");
    return false;
  }

  // If we reach here, all validations passed
  console.log("Validation passed - form will be submitted");
  return true;
}
function validation1() {
  for (let i = 1; i <= 9; i++) {
    let msgElement = document.getElementById("msg1" + i);
    if (msgElement) {
      msgElement.style.display = "none";
    }
  }

  let a = document.getElementsByName("afname")[0].value;
  let j = document.getElementsByName("amname")[0].value;
  let b = document.getElementsByName("alname")[0].value;
  let d = document.getElementsByName("amobile")[0].value;
  let e = document.getElementsByName("aaddress")[0].value;
  let fa = document.getElementsByName("auname")[0].value;
  let fb = document.getElementsByName("aemail")[0].value;
  let rval = document.querySelector('input[name="agender"]:checked');
  let g = document.getElementsByName("apwd")[0].value;
  let h = document.getElementsByName("apwd1")[0]
    ? document.getElementsByName("apwd1")[0].value
    : g;
  let i = document.querySelector('input[name="aterms"]:checked');
  //firstname Validation logic
  if (a === "") {
    document.getElementById("msg11").innerText =
      "First name must be more than 2 character consisting only alphabets";
    document.getElementById("msg11").style.color = "red";
    document.getElementById("msg11").style.display = "block";
    return false;
  }
  if (!a.match(/^[a-zA-Z]{3,}$/)) {
    document.getElementById("msg11").innerText =
      "First name must be more than 2 character consisting only alphabets";
    document.getElementById("msg11").style.color = "red";
    document.getElementById("msg11").style.display = "block";
    return false;
  }
  //middle name validation
  if (j !== "" && !j.match(/^[a-zA-Z]{3,}$/)) {
    document.getElementById("msg12").innerText =
      "Middle name must be more than 2 character consisting only alphabets";
    document.getElementById("msg12").style.color = "red";
    document.getElementById("msg12").style.display = "block";
    return false;
  }
  //last name validation
  if (b === "") {
    document.getElementById("msg13").innerText =
      "Last name must be more than 2 character consisting only alphabets";
    document.getElementById("msg13").style.color = "red";
    document.getElementById("msg13").style.display = "block";
    return false;
  }
  if (!b.match(/^[a-zA-Z]{3,}$/)) {
    document.getElementById("msg13").innerText =
      "Last name must be more than 2 character consisting only alphabets";
    document.getElementById("msg13").style.color = "red";
    document.getElementById("msg13").style.display = "block";
    return false;
  }
  //gender Validation
  if (rval == null) {
    alert("Please select the gender");
    return false;
  }
  //mobile no validation
  if (d === "") {
    document.getElementById("msg14").innerText =
      "This field cannot be empty please enter your valid phone number";
    document.getElementById("msg14").style.color = "red";
    document.getElementById("msg14").style.display = "block";
    return false;
  }
  if (isNaN(d)) {
    document.getElementById("msg14").innerText =
      "Mobile number cannot contain other characters than digits.";
    document.getElementById("msg14").style.color = "red";
    document.getElementById("msg14").style.display = "block";
    return false;
  }
  if (!(d.startsWith("98") || d.startsWith("97"))) {
    document.getElementById("msg14").innerText =
      "Mobile number always should start with 98 or 97";
    document.getElementById("msg14").style.color = "red";
    document.getElementById("msg14").style.display = "block";
    return false;
  }
  if (d.length !== 10) {
    document.getElementById("msg14").innerText =
      "Mobile number must be of length of 10 digits.";
    document.getElementById("msg14").style.color = "red";
    document.getElementById("msg14").style.display = "block";
    return false;
  }
  //Address validation
  if (e === "") {
    document.getElementById("msg15").innerText =
      "This field cannot be empty please enter your valid address";
    document.getElementById("msg15").style.color = "red";
    document.getElementById("msg15").style.display = "block";
    return false;
  }
  if (!e.match(/^[A-Za-z]{4,15}-\d{1,2} [A-Za-z]{2,15},[ ]?[nN]epal$/)) {
    document.getElementById("msg15").innerText =
      "please match the pattern [chainpur-1 chitwan,nepal]";
    document.getElementById("msg15").style.color = "red";
    document.getElementById("msg15").style.display = "block";
    return false;
  }
  //Username Validation
  if (fa === "") {
    document.getElementById("msg16").innerText =
      "This field cannot be empty please enter your username";
    document.getElementById("msg16").style.color = "red";
    document.getElementById("msg16").style.display = "block";
    return false;
  }
  if (fa.length <= 4) {
    document.getElementById("msg16").innerText =
      "Username must be of more than 4 character.";
    document.getElementById("msg16").style.color = "red";
    document.getElementById("msg16").style.display = "block";
    return false;
  }
  //Email Validation
  if (fb === "") {
    document.getElementById("msg17").innerText =
      "This field cannot be empty please enter your valid email";
    document.getElementById("msg17").style.color = "red";
    document.getElementById("msg17").style.display = "block";
    return false;
  }
  if (!fb.match(/^[\w.%+-]+@[\w.-]+\.[A-Za-z]{2,}$/)) {
    document.getElementById("msg17").innerHTML =
      "Your email couldn't validate. Please enter the valid Email.";
    document.getElementById("msg17").style.color = "red";
    document.getElementById("msg17").style.display = "block";
    return false;
  }
  // Password validation
  if (g === "") {
    document.getElementById("msg18").innerHTML =
      "This field cannot be empty please enter your password";
    document.getElementById("msg18").style.color = "red";
    document.getElementById("msg18").style.display = "block";
    return false;
  }
  if (g.length <= 5) {
    document.getElementById("msg18").innerHTML =
      "Password must be minimum of 6 characters.";
    document.getElementById("msg18").style.color = "red";
    document.getElementById("msg18").style.display = "block";
    return false;
  }
  // Check confirm password if it exists
  if (document.getElementsByName("cpassword1")[0] && h === "") {
    document.getElementById("msg19").innerHTML =
      "This field cannot be empty please repeat the password you entered above";
    document.getElementById("msg19").style.color = "red";
    document.getElementById("msg19").style.display = "block";
    return false;
  }
  // Password match validation if confirm password exists
  if (document.getElementsByName("cpassword1")[0] && g !== h) {
    document.getElementById("msg18").innerHTML = "Your password didn't match.";
    document.getElementById("msg19").innerHTML = "Your password didn't match.";
    document.getElementById("msg18").style.color = "red";
    document.getElementById("msg19").style.color = "red";
    document.getElementById("msg18").style.display = "block";
    document.getElementById("msg19").style.display = "block";
    return false;
  }
  // Terms validation if it exists
  if (document.querySelector('input[name="terms"]') && !i) {
    alert("Please agree to our terms and conditions.");
    return false;
  }

  // If we reach here, all validations passed
  console.log("Validation passed - form will be submitted");
  return true;
}

function adminpage() {
  window.location.href = "adminpanel.php";
}
function adminHome() {
  window.location.href = "adminmain.php";
}
function mofo() {
  alert("i fucking reached here");
}

function udisplay(target) {
  const sections = document.querySelectorAll(".section");
  sections.forEach((section) => {
    section.classList.remove("active");
  });

  // Remove active class from all buttons
  const buttons = document.querySelectorAll(".nav-btn");
  buttons.forEach((button) => {
    button.classList.remove("active");
  });

  // Show selected section
  document.getElementById("credentials").classList.add("active");

  // Add active class to clicked button
  target.classList.add("active");
}
function udisplay1(target) {
  const sections = document.querySelectorAll(".section");
  sections.forEach((section) => {
    section.classList.remove("active");
  });

  // Remove active class from all buttons
  const buttons = document.querySelectorAll(".nav-btn");
  buttons.forEach((button) => {
    button.classList.remove("active");
  });

  // Show selected section
  document.getElementById("stocks").classList.add("active");

  // Add active class to clicked button
  target.classList.add("active");
}
function udisplay2(target) {
  const sections = document.querySelectorAll(".section");
  sections.forEach((section) => {
    section.classList.remove("active");
  });

  // Remove active class from all buttons
  const buttons = document.querySelectorAll(".nav-btn");
  buttons.forEach((button) => {
    button.classList.remove("active");
  });

  // Show selected section
  document.getElementById("sales").classList.add("active");

  // Add active class to clicked button
  target.classList.add("active");
}

function userdel(uname) {
  let usernam = uname;

  $.ajax({
    url: "userdelete.php",
    method: "POST",
    data: {
      uname: usernam,
    },
    success: function () {
      window.location.reload();
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}
function sapprove(uname) {
  let usernam = uname;

  $.ajax({
    url: "sapprove.php",
    method: "POST",
    data: {
      uname: usernam,
    },
    success: function () {
      window.location.reload();
    },
    error: function () {
      alert("Error fetching product data.");
    },
  });
}
