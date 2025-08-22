<?php
session_start();

// Check if user is logged in and has appropriate access
if (!isset($_SESSION['uname']) || !isset($_SESSION['acc']) || $_SESSION['acc'] != 2) {
    header("Location: index.php");
    exit();
}

$uname = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="../bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Modern Custom CSS Files -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/products.css">
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/filters.css">
    <link rel="stylesheet" href="../css/recommendations.css">
    <!-- Enhanced Components -->
    <link rel="stylesheet" href="../css/enhanced.css">

    <title>BuyMart - Product Catalog</title>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-brand">
                <img src="../images/logo.png" alt="BuyMart" class="nav-logo">
                <span>BuyMart</span>
            </a>

            <div class="nav-center">
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Search products..." id="searchInput">
                    <button class="search-btn" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <select class="filter-dropdown" id="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="food">Food & Beverages</option>
                    <option value="home">Home & Garden</option>
                    <option value="books">Books and Stationary</option>
                    <option value="luxury">Luxury</option>
                    <option value="pet">Pets</option>
                    <option value="kids">Kids</option>
                </select>
            </div>

            <div class="nav-right">
                <button class="nav-btn" onclick="toggleCart(); cHideUnhide();" title="Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </button>

                <button class="nav-btn" onclick="mainpage()" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Filters Section -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <div class="filters-header">
                <h3 class="filters-title">
                    <i class="fas fa-filter"></i>
                    Product Filters
                </h3>
                <button class="filters-toggle d-md-none" onclick="toggleFilters()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filters-body">
                <div class="filter-group">
                    <label class="filter-label">Product Name</label>
                    <input type="text" class="form-control" id="pname" placeholder="Enter Product Name">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Category</label>
                    <select class="filter-select" id="cfilter">
                        <option value="">All Categories</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="food">Food & Beverages</option>
                        <option value="home">Home & Garden</option>
                        <option value="books">Books and Stationary</option>
                        <option value="luxury">Luxury</option>
                        <option value="pet">Pets</option>
                        <option value="kids">Kids</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Price Range</label>
                    <div class="price-range-container">
                        <div class="price-inputs">
                            <select class="filter-select" id="pra25" name="price" onchange="second()">
                                <option value="">Min Price</option>
                                <option value="high">High</option>
                                <option value="low">Low</option>
                            </select>
                            <span class="price-separator">to</span>
                            <select class="filter-select" id="pra26" name="price1" onchange="second1()">
                                <option value="">Max Price</option>
                                <option value="high1">High</option>
                                <option value="low1">Low</option>
                            </select>
                        </div>
                        <input type="range" class="price-range-slider" min="1" max="150000" value="1" onchange="change()" id="sliderRange" name="range">
                        <p class="text-center mt-2">Price: Rs. <span id="demo">1</span></p>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="button" class="apply-filters-btn" onclick="sortFilter()">
                        <i class="fas fa-check"></i>
                        Apply Filters
                    </button>
                    <button type="button" class="clear-filters-btn" onclick="clearFilters()">
                        <i class="fas fa-times"></i>
                        Clear All
                    </button>
                </div>
            </div>
        </div>

        <!-- Cart Sidebar -->
        <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>
        <div class="cart-sidebar" id="cartSidebar">
            <div class="cart-header">
                <h3 class="cart-title">
                    <i class="fas fa-shopping-cart"></i>
                    Shopping Cart
                </h3>
                <button class="cart-close" onclick="toggleCart()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cart-body" id="cartBody">
                <div class="cart-empty">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Your cart is empty</h3>
                    <p>Add some products to get started!</p>
                    <button class="continue-shopping-btn" onclick="toggleCart()">
                        Continue Shopping
                    </button>
                </div>
            </div>
            <div class="cart-footer" id="cartFooter" style="display: none;">
                <div class="cart-summary">
                    <div class="cart-summary-row">
                        <span>Subtotal:</span>
                        <span id="cartSubtotal">Rs. 0</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Tax:</span>
                        <span id="cartTax">Rs. 0</span>
                    </div>
                    <div class="cart-summary-row total">
                        <span>Total:</span>
                        <span id="cartTotal">Rs. 0</span>
                    </div>
                </div>
                <div class="cart-actions">
                    <button class="checkout-btn" onclick="proceedToCheckout()">
                        <i class="fas fa-credit-card"></i>
                        Proceed to Checkout
                    </button>
                    <button class="clear-cart-btn" onclick="clearCart()">
                        <i class="fas fa-trash"></i>
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="products-section">
            <!-- Sort Section -->
            <div class="sort-section">
                <div class="sort-label">
                    <i class="fas fa-sort"></i>
                    Sort by:
                </div>
                <div class="sort-options">
                    <button class="sort-option active" data-sort="default">Featured</button>
                    <button class="sort-option" data-sort="price-low">Price: Low to High</button>
                    <button class="sort-option" data-sort="price-high">Price: High to Low</button>
                    <button class="sort-option" data-sort="rating">Rating</button>
                    <button class="sort-option" data-sort="newest">Newest</button>
                </div>
            </div>

            <!-- Results Info -->
            <div class="results-info">
                <span class="results-count" id="resultsCount">Showing all products</span>
                <span id="loadingIndicator" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Loading...
                </span>
            </div>

            <!-- Products Header -->
            <div class="products-header">
                <h1 class="products-title">Product Catalog</h1>
                <p class="products-subtitle">Discover our wide range of quality products</p>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
                <!-- Products will be dynamically loaded here -->
            </div>
        </div>

        <!-- Recommendations Section -->
        <div class="recommendations-section">
            <div class="recommendations-container">
                <div class="recommendations-header">
                    <h2 class="recommendations-title">
                        <i class="fas fa-thumbs-up"></i>
                        Recommended For You
                    </h2>
                    <p class="recommendations-subtitle">Products you might like based on your browsing history</p>
                </div>

                <div class="recommendation-tabs">
                    <button class="recommendation-tab active" data-category="all">All</button>
                    <button class="recommendation-tab" data-category="similar">Similar Items</button>
                    <button class="recommendation-tab" data-category="popular">Popular</button>
                    <button class="recommendation-tab" data-category="trending">Trending</button>
                </div>

                <div class="recommendations-grid" id="recommendationsGrid">
                    <!-- Recommendations will be loaded here -->
                </div>
            </div>
        </div>
    </main>

    <!-- Recommendation Popup Backdrop -->
    <div class="recommendation-backdrop" onclick="closeRecommendationPopup()"></div>

    <!-- Recommendation Popup (similar to adminmain.php) -->
    <div class="recommendation-div">
        <!-- Recommendation popup content will be dynamically loaded here -->
    </div>

    <script>
        const uname = <?php echo json_encode($uname); ?>;
        const pageType = 2;

        // Toggle functions for enhanced UI
        function toggleFilters() {
            const filtersSection = document.getElementById('filtersSection');
            const filtersBody = filtersSection.querySelector('.filters-body');
            filtersBody.classList.toggle('show');
        }

        function clearFilters() {
            document.getElementById('pname').value = '';
            document.getElementById('cfilter').value = '';
            document.getElementById('pra25').value = '';
            document.getElementById('pra26').value = '';
            document.getElementById('sliderRange').value = '1';
            document.getElementById('demo').textContent = '1';
            // Trigger filter update
            sortFilter();
        }

        function toggleCart() {
            const cartOverlay = document.getElementById('cartOverlay');
            const cartSidebar = document.getElementById('cartSidebar');

            cartOverlay.classList.toggle('active');
            cartSidebar.classList.toggle('active');
        }

        // Sort functionality
        document.querySelectorAll('.sort-option').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.sort-option').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const sortType = this.dataset.sort;
                sortProducts(sortType);
            });
        });

        // Set default sort as active on page load
        document.addEventListener('DOMContentLoaded', function() {
            const defaultSortBtn = document.querySelector('.sort-option[data-sort="default"]');
            if (defaultSortBtn) {
                defaultSortBtn.classList.add('active');
            }
        });

        // Sort products function
        function sortProducts(sortType) {
            // Show loading
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = '<div class="loading-spinner">Loading products...</div>';

            // Get current filters
            const searchTerm = document.getElementById('pname') ? document.getElementById('pname').value : '';
            const category = document.getElementById('cfilter') ? document.getElementById('cfilter').value : '';
            const minPrice = 0;
            const maxPrice = document.getElementById('sliderRange') ? document.getElementById('sliderRange').value : 999999;

            $.ajax({
                url: 'sort_products.php',
                method: 'POST',
                data: {
                    sort: sortType,
                    search: searchTerm,
                    category: category,
                    minPrice: minPrice,
                    maxPrice: maxPrice
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        displayProducts(response.products);

                        // Update product count if element exists
                        const productCount = document.querySelector('.product-count');
                        if (productCount) {
                            productCount.textContent = `${response.count} products found`;
                        }

                        // Show sort confirmation
                        showNotification(`Products sorted by ${getSortLabel(sortType)}`, 'success');
                    } else {
                        showNotification('Error sorting products', 'error');
                        console.error('Sort error:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    showNotification('Failed to sort products', 'error');
                    console.error('AJAX error:', error);
                    productsGrid.innerHTML = '<div class="error-message">Failed to load products</div>';
                }
            });
        }

        // Get sort label for display
        function getSortLabel(sortType) {
            const labels = {
                'default': 'Default',
                'price-low': 'Price: Low to High',
                'price-high': 'Price: High to Low',
                'rating': 'Rating',
                'newest': 'Newest First',
                'name': 'Name A-Z'
            };
            return labels[sortType] || 'Default';
        }

        // View toggle functionality
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const view = this.dataset.view;
                const productsGrid = document.getElementById('productsGrid');
                if (view === 'list') {
                    productsGrid.classList.add('list-view');
                } else {
                    productsGrid.classList.remove('list-view');
                }
            });
        });

        // Recommendation tabs
        document.querySelectorAll('.recommendation-tab').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.recommendation-tab').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                // Load recommendations based on category
                const category = this.dataset.category;
                loadRecommendations(category);
            });
        });

        function loadRecommendations(category) {
            // Implement recommendation loading logic
            console.log('Loading recommendations for:', category);
        }

        // Enhanced cart and notification functions
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotif = document.querySelector('.notification');
            if (existingNotif) existingNotif.remove();

            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
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

        function proceedToCheckout() {
            // Get cart items for checkout
            $.ajax({
                url: "cart1.php",
                method: "POST",
                dataType: "json",
                success: function(res) {
                    if (res.length === 0) {
                        showNotification("Your cart is empty", 'error');
                        return;
                    }

                    // Calculate total amount
                    let totalAmount = 0;
                    res.forEach(item => {
                        totalAmount += item.price * item.qty;
                    });

                    // Show confirmation with total amount
                    if (confirm(`Proceed to payment for Rs. ${totalAmount.toFixed(2)}?`)) {
                        // Get all product IDs
                        const productIds = res.map(item => item.id).join(',');

                        // Redirect to eSewa for all items
                        window.location.href = `esewa1.php?pid=${productIds}`;
                    }
                },
                error: function() {
                    showNotification("Error loading cart items", 'error');
                }
            });
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                $.ajax({
                    url: "clear_cart.php",
                    method: "POST",
                    success: function() {
                        loadCartItems();
                        updateCartCount();
                        showNotification("Cart cleared successfully", 'success');
                    },
                    error: function() {
                        showNotification("Error clearing cart", 'error');
                    }
                });
            }
        }

        // Optimized Recommendation Popup Functions
        let recommendationCache = null;
        let isRecommendationLoading = false;
        let autoPopupShown = false;

        function showRecommendationPopup(trigger = 'auto') {
            // Prevent multiple simultaneous requests
            if (isRecommendationLoading) {
                return;
            }

            // For manual trigger, allow showing even if auto popup was shown
            if (trigger === 'auto' && autoPopupShown) {
                return;
            }

            const recommendationDiv = document.querySelector('.recommendation-div');
            const backdrop = document.querySelector('.recommendation-backdrop');

            // Show loading state
            if (trigger === 'manual') {
                showLoadingPopup();
            }

            isRecommendationLoading = true;

            // Use cache if available and less than 5 minutes old
            if (recommendationCache && (Date.now() - recommendationCache.timestamp < 300000)) {
                renderRecommendationPopup(recommendationCache.data, trigger);
                isRecommendationLoading = false;
                return;
            }

            $.ajax({
                url: "recommendation.php",
                method: "POST",
                dataType: "json",
                timeout: 10000, // 10 second timeout
                success: function(res) {
                    isRecommendationLoading = false;

                    if (res && res.length > 0) {
                        // Cache the results
                        recommendationCache = {
                            data: res,
                            timestamp: Date.now()
                        };

                        renderRecommendationPopup(res, trigger);

                        if (trigger === 'auto') {
                            autoPopupShown = true;
                        }
                    } else {
                        hideLoadingPopup();
                        if (trigger === 'manual') {
                            showNotification("No personalized recommendations available yet. Browse more products to get better suggestions!", 'info');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    isRecommendationLoading = false;
                    hideLoadingPopup();

                    if (trigger === 'manual') {
                        if (status === 'timeout') {
                            showNotification("Request timed out. Please try again.", 'error');
                        } else {
                            showNotification("Unable to load recommendations. Please check your connection.", 'error');
                        }
                    }
                    console.error('Recommendation error:', error);
                }
            });
        }

        function renderRecommendationPopup(products, trigger) {
            const recommendationDiv = document.querySelector('.recommendation-div');
            const backdrop = document.querySelector('.recommendation-backdrop');

            hideLoadingPopup();
            recommendationDiv.innerHTML = "";

            const recommendationContainer = document.createElement("div");
            recommendationContainer.className = "recommendation-container";

            // Create enhanced header with close button and info
            const header = document.createElement("div");
            header.className = "recommendation-header";
            header.innerHTML = `
                <div class="recommendation-title-section">
                    <h3><i class="fas fa-magic me-2"></i>Personalized Recommendations</h3>
                    <p class="recommendation-subtitle">Based on your browsing preferences</p>
                </div>
                <div class="recommendation-controls">
                    <button class="recommendation-refresh" onclick="refreshRecommendations()" title="Refresh Recommendations">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="recommendation-close" onclick="closeRecommendationPopup()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            // Create grid for products with animation
            const recommendationGrid = document.createElement("div");
            recommendationGrid.className = "recommendation-popup-grid";

            products.slice(0, 3).forEach((product, index) => {
                const productCard = createOptimizedRecommendationCard(product, index);
                recommendationGrid.appendChild(productCard);
            });

            // Add "View More" button if there are more products
            if (products.length > 3) {
                const viewMoreCard = createViewMoreCard(products.length - 3);
                recommendationGrid.appendChild(viewMoreCard);
            }

            recommendationContainer.appendChild(header);
            recommendationContainer.appendChild(recommendationGrid);
            recommendationDiv.appendChild(recommendationContainer);

            // Show backdrop and popup with animation
            backdrop.classList.add('show');
            recommendationDiv.classList.add('show');

            // Auto-hide for automatic popup only
            if (trigger === 'auto') {
                setTimeout(() => {
                    closeRecommendationPopup();
                }, 20000); // Increased to 20 seconds
            }

            // Add analytics tracking
            trackRecommendationView(products.length, trigger);
        }

        function showLoadingPopup() {
            const recommendationDiv = document.querySelector('.recommendation-div');
            const backdrop = document.querySelector('.recommendation-backdrop');

            recommendationDiv.innerHTML = `
                <div class="recommendation-loading">
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <p>Loading personalized recommendations...</p>
                </div>
            `;

            backdrop.classList.add('show');
            recommendationDiv.classList.add('show');
        }

        function hideLoadingPopup() {
            const recommendationDiv = document.querySelector('.recommendation-div');
            const backdrop = document.querySelector('.recommendation-backdrop');

            if (recommendationDiv.querySelector('.recommendation-loading')) {
                backdrop.classList.remove('show');
                recommendationDiv.classList.remove('show');
            }
        }

        function closeRecommendationPopup() {
            const recommendationDiv = document.querySelector('.recommendation-div');
            const backdrop = document.querySelector('.recommendation-backdrop');

            recommendationDiv.classList.remove('show');
            backdrop.classList.remove('show');
        }

        function refreshRecommendations() {
            // Clear cache and reload
            recommendationCache = null;
            showRecommendationPopup('manual');
        }

        function createOptimizedRecommendationCard(product, index) {
            const card = document.createElement('div');
            card.className = 'recommendation-popup-card';
            card.style.animationDelay = `${index * 0.1}s`;

            const imageUrl = product.image ? `files/${product.image}` : '../images/default-product.png';
            const price = parseFloat(product.price) || 0;
            const isInStock = product.stock > 0;

            card.innerHTML = `
                <div class="product-card enhanced-card">
                    <div class="product-image-container">
                        <img src="${imageUrl}" alt="${product.name}" class="product-image" 
                             onerror="this.src='../images/default-product.png'"
                             loading="lazy">
                        <div class="product-overlay">
                            ${isInStock ? 
                                `<button class="btn btn-primary btn-sm add-to-cart-rec" onclick="addToCartFromRecommendation(${product.id}, '${product.name}')">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>` :
                                `<button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-ban"></i> Out of Stock
                                </button>`
                            }
                        </div>
                        ${!isInStock ? '<div class="out-of-stock-overlay">Out of Stock</div>' : ''}
                    </div>
                    <div class="product-info">
                        <h5 class="product-title" title="${product.name}">${product.name}</h5>
                        <p class="product-description">${product.description ? 
                            (product.description.length > 60 ? product.description.substring(0, 60) + '...' : product.description) : 
                            'No description available'}</p>
                        <div class="product-price">
                            <span class="current-price">Rs. ${price.toFixed(2)}</span>
                        </div>
                        <div class="product-meta">
                            <span class="product-category">
                                <i class="fas fa-tag"></i> ${product.category}
                            </span>
                            <span class="product-stock ${isInStock ? 'in-stock' : 'out-of-stock'}">
                                <i class="fas fa-cube"></i> ${isInStock ? `${product.stock} in stock` : 'Out of Stock'}
                            </span>
                        </div>
                    </div>
                </div>
            `;

            return card;
        }

        function createViewMoreCard(remainingCount) {
            const card = document.createElement('div');
            card.className = 'recommendation-popup-card view-more-card';

            card.innerHTML = `
                <div class="view-more-content">
                    <div class="view-more-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5>View More</h5>
                    <p>${remainingCount} more recommendations available</p>
                    <button class="btn btn-outline-primary btn-sm" onclick="viewAllRecommendations()">
                        <i class="fas fa-arrow-right"></i> See All
                    </button>
                </div>
            `;

            return card;
        }

        function addToCartFromRecommendation(productId, productName) {
            // Add to cart with enhanced feedback
            addToCart(productId);
            showNotification(`"${productName}" added to cart from recommendations!`, 'success');

            // Track recommendation conversion
            trackRecommendationConversion(productId, productName);
        }

        function viewAllRecommendations() {
            closeRecommendationPopup();
            // Scroll to recommendations section
            document.querySelector('.recommendations-section').scrollIntoView({
                behavior: 'smooth'
            });
            showNotification("Check out all recommendations below!", 'info');
        }

        function trackRecommendationView(count, trigger) {
            // Analytics tracking (placeholder)
            console.log(`Recommendation viewed: ${count} products, trigger: ${trigger}`);
        }

        function trackRecommendationConversion(productId, productName) {
            // Analytics tracking for conversions (placeholder)
            console.log(`Recommendation conversion: Product ${productId} - ${productName}`);
        }

        // Show recommendation popup when page loads (after a delay)
        $(document).ready(function() {
            // Show popup after 5 seconds, but only if user hasn't interacted much
            setTimeout(() => {
                // Check if user has scrolled or clicked around (basic engagement check)
                if (window.scrollY < 100) {
                    showRecommendationPopup('auto');
                }
            }, 5000);

            // Optional: Show popup when user is about to leave (exit intent)
            let exitIntentShown = false;
            $(document).mouseleave(function(e) {
                if (e.clientY <= 0 && !exitIntentShown && !autoPopupShown) {
                    exitIntentShown = true;
                    showRecommendationPopup('exit-intent');
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="../bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script defer src="../jquery/jquery.js"></script>

    <!-- Custom JS -->
    <script defer src="index.js"></script>

</body>

</html>