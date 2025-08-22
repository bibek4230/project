<?php
session_start();

// Check if user is logged in and has admin access
if (!isset($_SESSION['uname']) || !isset($_SESSION['acc']) || $_SESSION['acc'] != 1) {
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
    <link rel="stylesheet" href="../css/admin.css">

    <title>BuyMart - Admin Dashboard</title>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-brand">
                <img src="../images/logo.png" alt="BuyMart" class="nav-logo">
                <span>BuyMart Admin</span>
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
                <button class="nav-btn" onclick="adminpage()" title="Admin Panel">
                    <i class="fas fa-cog"></i>
                </button>

                <button class="nav-btn" onclick="upload('admin')" title="Upload Product">
                    <i class="fas fa-upload"></i>
                </button>

                <div class="nav-user-info">
                    <span class="user-name">
                        <i class="fas fa-user-shield"></i>
                        <?php echo htmlspecialchars($uname); ?>
                    </span>
                </div>

                <button class="nav-btn logout-btn" onclick="logout()" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Admin Stats Dashboard -->
        <div class="admin-dashboard" id="adminDashboard">
            <div class="dashboard-header">
                <h2 class="dashboard-title">
                    <i class="fas fa-chart-line"></i>
                    Admin Dashboard
                </h2>
                <p class="dashboard-subtitle">Overview of system performance and statistics</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number" id="totalProducts">0</h3>
                        <p class="stat-label">Total Products</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number" id="totalUsers">0</h3>
                        <p class="stat-label">Total Users</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number" id="totalOrders">0</h3>
                        <p class="stat-label">Total Orders</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number" id="avgRating">0.0</h3>
                        <p class="stat-label">Avg Rating</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section" id="filtersSection" style="display: none;">
            <div class="filters-header">
                <h3 class="filters-title">
                    <i class="fas fa-filter"></i>
                    Advanced Filters
                </h3>
                <button class="filters-close" onclick="dispfilter()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filters-body">
                <form class="filters-form">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-search"></i>
                            Product Name
                        </label>
                        <input type="text" class="filter-input" id="pname" placeholder="Enter product name">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-tags"></i>
                            Category
                        </label>
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

                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fas fa-dollar-sign"></i>
                                Price From
                            </label>
                            <select class="filter-select" id="pra25" onchange="second()">
                                <option value="">Select price</option>
                                <option value="high">High to Low</option>
                                <option value="low">Low to High</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fas fa-dollar-sign"></i>
                                Price To
                            </label>
                            <select class="filter-select" id="pra26" onchange="second1()">
                                <option value="">Select range</option>
                                <option value="high1">High Range</option>
                                <option value="low1">Low Range</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-sliders-h"></i>
                            Price Range: Rs. <span id="demo">1</span>
                        </label>
                        <input type="range"
                            class="filter-range"
                            id="sliderRange"
                            min="1"
                            max="150000"
                            value="1"
                            onchange="change()">
                    </div>

                    <div class="filter-actions">
                        <button type="button" class="btn btn-primary" onclick="sortFilter()">
                            <i class="fas fa-filter"></i>
                            Apply Filters
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                            <i class="fas fa-eraser"></i>
                            Clear All
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Products Section -->
        <div class="products-section">
            <!-- Sort Section -->
            <div class="sort-section">
                <div class="sort-header">
                    <h3 class="sort-title">
                        <i class="fas fa-boxes"></i>
                        Product Management
                    </h3>
                    <div class="sort-info">
                        <span class="results-count" id="resultsCount">0 products found</span>
                    </div>
                </div>

                <div class="sort-controls">
                    <div class="sort-options">
                        <label class="sort-label">Sort by:</label>
                        <select class="sort-select" id="sortSelect">
                            <option value="default">Default (Newest)</option>
                            <option value="name">Product Name</option>
                            <option value="price-low">Price (Low to High)</option>
                            <option value="price-high">Price (High to Low)</option>
                            <option value="rating">Rating (High to Low)</option>
                            <option value="stock">Stock (High to Low)</option>
                        </select>
                    </div>

                    <div class="view-options">
                        <button class="view-btn active" data-view="grid" title="Grid View">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-btn" data-view="list" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Header -->
            <div class="products-header">
                <h2 class="products-title">
                    <i class="fas fa-inventory"></i>
                    Product Catalog
                </h2>
                <p class="products-subtitle">Manage and oversee all products in the system</p>
            </div>

            <!-- Products Grid -->
            <div class="admin-products-grid" id="productsGrid">
                <!-- Products will be dynamically loaded here -->
            </div>
        </div>
    </main>

    <script>
        const uname = <?php echo json_encode($uname); ?>;
        const pageType = 1;

        // Admin Dashboard Functions
        function loadDashboardStats() {
            $.ajax({
                url: "admin_stats.php",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("Stats loaded:", data);
                    document.getElementById('totalProducts').textContent = data.products || 0;
                    document.getElementById('totalUsers').textContent = data.users || 0;
                    document.getElementById('totalOrders').textContent = data.orders || 0;
                    document.getElementById('avgRating').textContent = (data.rating || 0).toFixed(1);
                },
                error: function(xhr, status, error) {
                    console.log("Error loading dashboard stats:", error);
                    console.log("Response:", xhr.responseText);
                }
            });
        }

        // Enhanced filter functions
        function clearFilters() {
            document.getElementById('pname').value = '';
            document.getElementById('cfilter').value = '';
            document.getElementById('pra25').value = '';
            document.getElementById('pra26').value = '';
            document.getElementById('sliderRange').value = '1';
            document.getElementById('demo').textContent = '1';
            sortFilter();
        }

        // Toggle filter section
        function dispfilter() {
            const filtersSection = document.getElementById('filtersSection');
            const isVisible = filtersSection.style.display !== 'none';
            filtersSection.style.display = isVisible ? 'none' : 'block';
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Sort functionality
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Admin page loaded, initializing...');

            // Load dashboard stats
            loadDashboardStats();

            // Sort select change handler  
            const sortSelect = document.getElementById('sortSelect');
            if (!sortSelect) {
                console.error('Sort select element not found');
                return;
            }

            sortSelect.addEventListener('change', function() {
                const sortType = this.value;
                console.log('Sort changed to:', sortType);
                sortAdminProducts(sortType);
            });

            // Check if jQuery is loaded
            if (typeof $ === 'undefined') {
                console.error('jQuery not loaded!');
                document.getElementById('productsGrid').innerHTML =
                    '<div class="alert alert-danger">jQuery not loaded. Please refresh the page.</div>';
                return;
            }

            // Load initial products with default sort
            console.log('Loading initial products...');
            setTimeout(() => {
                sortAdminProducts('default');
            }, 100); // Small delay to ensure everything is loaded

            // Admin product sorting function
            function sortAdminProducts(sortType) {
                console.log('Sorting admin products with type:', sortType);
                const productsGrid = document.getElementById('productsGrid');

                if (!productsGrid) {
                    console.error('Products grid element not found');
                    return;
                }

                productsGrid.innerHTML = '<div class="loading-spinner text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading products...</div>';

                $.ajax({
                    url: 'sort_products.php',
                    method: 'POST',
                    data: {
                        sort: sortType,
                        search: '',
                        category: '',
                        minPrice: 0,
                        maxPrice: 999999
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Sort response:', response);
                        if (response.status === 'success') {
                            displayAdminProducts(response.products);

                            // Update product count
                            const countElement = document.querySelector('.products-count');
                            if (countElement) {
                                countElement.textContent = `${response.count} products`;
                            }

                            // Update results count
                            const resultsCount = document.getElementById('resultsCount');
                            if (resultsCount) {
                                resultsCount.textContent = `${response.count} products found`;
                            }
                        } else {
                            console.error('Sort error:', response);
                            productsGrid.innerHTML = '<div class="alert alert-danger">Error loading products: ' + (response.message || 'Unknown error') + '</div>';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', xhr, status, error);
                        console.error('Response text:', xhr.responseText);
                        productsGrid.innerHTML = '<div class="alert alert-danger">Failed to load products. Check console for details.</div>';
                    }
                });
            }

            // Display admin products function
            function displayAdminProducts(products) {
                console.log('Displaying admin products:', products);
                const productsGrid = document.getElementById('productsGrid');

                if (!productsGrid) {
                    console.error('Products grid not found for display');
                    return;
                }

                if (!products || products.length === 0) {
                    console.log('No products to display');
                    productsGrid.innerHTML = '<div class="no-products text-center p-4">No products found</div>';
                    return;
                }

                let html = '';
                products.forEach(product => {
                    const rating = product.avg_rating || 0;
                    const ratingStars = '★'.repeat(Math.floor(rating)) + '☆'.repeat(5 - Math.floor(rating));

                    html += `
                        <div class="admin-product-card">
                            <div class="product-image">
                                <img src="${product.image}" alt="${product.name}" loading="lazy">
                                <div class="product-overlay">
                                    <button class="btn btn-primary" onclick="editProduct(${product.id})" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="deleteProduct(${product.id})" title="Delete Product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-name">${product.name}</h5>
                                <p class="product-category">
                                    <i class="fas fa-tag"></i> 
                                    ${product.category.charAt(0).toUpperCase() + product.category.slice(1)}
                                </p>
                                <div class="product-rating">
                                    <span class="stars">${ratingStars}</span>
                                    <span class="rating-text">(${rating.toFixed(1)}) ${product.rating_count || 0} reviews</span>
                                </div>
                                <div class="product-price">
                                    <span class="price">Rs. ${product.price}</span>
                                </div>
                                <div class="product-stock">
                                    <span class="stock ${product.stock < 10 ? 'low-stock' : ''}">
                                        <i class="fas fa-boxes"></i> Stock: ${product.stock}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                });

                productsGrid.innerHTML = html;
            }

            // Load initial products
            sortAdminProducts('default');

            // Product management functions
            window.editProduct = function(productId) {
                // Redirect to edit page or show edit modal
                window.location.href = `upload1.php?edit=${productId}`;
            };

            window.deleteProduct = function(productId) {
                if (confirm('Are you sure you want to delete this product?')) {
                    $.ajax({
                        url: 'admindel.php',
                        method: 'POST',
                        data: {
                            pid: productId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('Product deleted successfully');
                                // Reload products after deletion
                                const currentSort = document.getElementById('sortSelect').value;
                                sortAdminProducts(currentSort);
                                loadDashboardStats(); // Refresh stats
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('Error deleting product');
                        }
                    });
                }
            };

            // Upload function for adding new products
            window.upload = function(type) {
                if (type === "admin") {
                    window.location.href = "upload.php";
                }
            };

            // Logout function
            window.logout = function() {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = "logout.php";
                }
            };

            // Admin panel function
            window.adminpage = function() {
                window.location.href = "adminpanel.php";
            };

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
        });
    </script>

    <!-- jQuery (load first without defer) -->
    <script src="../jquery/jquery.js"></script>

    <!-- Bootstrap JS -->
    <script src="../bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>