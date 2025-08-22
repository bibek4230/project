<?php
session_start();

// Debug: Check if POST data exists at all
if ($_POST) {
    error_log("POST data received: " . print_r($_POST, true));
}

// Debug: Check if FILES data exists
if ($_FILES) {
    error_log("FILES data received: " . print_r($_FILES, true));
} else {
    error_log("No FILES data received");
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['uname']) || !isset($_SESSION['acc']) || $_SESSION['acc'] != 1) {
    // Redirect to login page if not authorized
    header("Location: index.php");
    exit();
}

$adminUsername = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - BuyMart</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap-5.3.4-dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/enhanced.css">

    <style>
        /* Admin Navigation Styles */
        .admin-nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .nav-brand:hover {
            color: white;
            text-decoration: none;
        }

        .nav-center h2 {
            color: white;
            margin: 0;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-info {
            color: white;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-btn {
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .nav-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
        }

        /* Upload Page Styles */
        body {
            background: var(--gradient-bg);
            min-height: 100vh;
            padding-top: 80px;
            /* Account for fixed nav */
        }

        .upload-container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 0 var(--spacing-lg);
        }

        .upload-card {
            background: var(--white);
            border-radius: var(--border-radius-2xl);
            box-shadow: var(--shadow-2xl);
            overflow: hidden;
            border: 1px solid var(--gray-200);
        }

        .upload-header {
            background: var(--gradient-primary);
            color: var(--white);
            padding: var(--spacing-2xl);
            text-align: center;
        }

        .upload-header h1 {
            font-size: var(--font-size-3xl);
            font-weight: var(--font-weight-bold);
            margin-bottom: var(--spacing-sm);
        }

        .upload-header p {
            opacity: 0.9;
            font-size: var(--font-size-lg);
        }

        .upload-form {
            padding: var(--spacing-3xl);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
        }

        .form-group {
            margin-bottom: var(--spacing-lg);
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-weight: var(--font-weight-semibold);
            color: var(--gray-700);
            margin-bottom: var(--spacing-sm);
            font-size: var(--font-size-sm);
        }

        .form-input {
            width: 100%;
            padding: var(--spacing-md);
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius-lg);
            font-size: var(--font-size-base);
            transition: all var(--transition-fast);
            background: var(--white);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .file-upload {
            position: relative;
            display: block;
            width: 100%;
            padding: var(--spacing-xl);
            border: 2px dashed var(--gray-300);
            border-radius: var(--border-radius-lg);
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            background: var(--gray-50);
        }

        .file-upload:hover {
            border-color: var(--primary-color);
            background: rgba(102, 126, 234, 0.05);
        }

        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: var(--spacing-sm);
        }

        .upload-text {
            font-size: var(--font-size-lg);
            font-weight: var(--font-weight-semibold);
            color: var(--gray-700);
            margin-bottom: var(--spacing-xs);
        }

        .upload-subtext {
            color: var(--gray-500);
            font-size: var(--font-size-sm);
        }

        .file-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .file-preview img {
            border: 2px solid var(--gray-200);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: var(--spacing-lg);
            background: var(--gradient-primary);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius-lg);
            font-size: var(--font-size-lg);
            font-weight: var(--font-weight-semibold);
            cursor: pointer;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left var(--transition-normal);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            background: var(--white);
            border: 2px solid var(--primary-color);
            border-radius: var(--border-radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            text-decoration: none;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-fast);
            z-index: 1000;
        }

        .back-btn:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .upload-container {
                margin: 80px auto 30px;
                padding: 0 var(--spacing-md);
            }

            .upload-form {
                padding: var(--spacing-xl);
            }
        }
    </style>
</head>

<body>
    <!-- Admin Navigation -->
    <nav class="admin-nav">
        <div class="nav-container">
            <div class="nav-left">
                <a href="adminmain.php" class="nav-brand">
                    <i class="fas fa-store"></i>
                    <span>BuyMart Admin</span>
                </a>
            </div>
            <div class="nav-center">
                <h2><i class="fas fa-plus-circle"></i> Add Product</h2>
            </div>
            <div class="nav-right">
                <span class="admin-info">
                    <i class="fas fa-user-shield"></i>
                    <?php echo htmlspecialchars($adminUsername); ?>
                </span>
                <a href="adminmain.php" class="nav-btn" title="Back to Admin Dashboard">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="logout.php" class="nav-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="upload-container">
        <div class="upload-card">
            <div class="upload-header">
                <h1><i class="fas fa-plus-circle"></i> Add New Product</h1>
                <p>Fill in the details below to add a new product to your store</p>
            </div>

            <form action="" method="post" enctype="multipart/form-data" class="upload-form" id="uploadForm">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="name">
                            <i class="fas fa-tag"></i> Product Name
                        </label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="Enter product name" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category">
                            <i class="fas fa-folder"></i> Category
                        </label>
                        <select name="category" id="category" class="form-input" required>
                            <option value="">Select Category</option>
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
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="price">
                            <i class="fas fa-dollar-sign"></i> Base Price (Rs.)
                        </label>
                        <input type="number" id="price" name="price" class="form-input" placeholder="0" min="1" required onchange="calculateTotal()">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="serchar">
                            <i class="fas fa-percentage"></i> Service Charge (Rs.)
                        </label>
                        <input type="number" id="serchar" name="serchar" class="form-input" placeholder="0" min="0" required onchange="calculateTotal()">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calculator"></i> Tax (13%)
                        </label>
                        <input type="text" id="tax" class="form-input" placeholder="0" readonly style="background-color: #f8f9fa;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-money-bill"></i> Total Price (Rs.)
                        </label>
                        <input type="text" id="total" class="form-input" placeholder="0" readonly style="background-color: #f8f9fa;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="stock">
                        <i class="fas fa-boxes"></i> Stock Quantity
                    </label>
                    <input type="number" id="stock" name="stock" class="form-input" placeholder="Enter available quantity" min="0" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comment">
                        <i class="fas fa-align-left"></i> Product Description
                    </label>
                    <textarea id="comment" name="comment" class="form-input form-textarea" placeholder="Describe your product in detail..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-image"></i> Product Image
                    </label>
                    <div class="file-upload">
                        <input type="file" name="file" accept="image/*" required id="fileInput">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">Click to upload image</div>
                        <div class="upload-subtext">JPG, PNG, GIF up to 5MB</div>
                    </div>
                </div>

                <button type="submit" name="post" class="submit-btn">
                    <i class="fas fa-plus"></i>
                    Add Product to Store
                </button>
            </form>
        </div>
    </div>

    <script>
        // Calculate total price automatically
        function calculateTotal() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const serchar = parseFloat(document.getElementById('serchar').value) || 0;
            const tax = price * 0.13;
            const total = price + tax + serchar;

            document.getElementById('tax').value = tax.toFixed(1);
            document.getElementById('total').value = total.toFixed(1);
        }

        // Enhanced file upload preview
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const uploadDiv = e.target.parentElement;

            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    e.target.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Only JPG, JPEG, PNG, and GIF files are allowed');
                    e.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(readerEvent) {
                    // Hide the original content and show preview
                    const originalContent = uploadDiv.querySelectorAll('.upload-icon, .upload-text, .upload-subtext');
                    originalContent.forEach(el => el.style.display = 'none');

                    // Create or update preview
                    let preview = uploadDiv.querySelector('.file-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'file-preview';
                        uploadDiv.appendChild(preview);
                    }

                    preview.innerHTML = `
                        <img src="${readerEvent.target.result}" style="max-width: 200px; max-height: 150px; border-radius: 8px; margin-bottom: 10px; display: block;">
                        <div class="upload-text" style="color: var(--success-color);">
                            <i class="fas fa-check-circle"></i> ${file.name}
                        </div>
                        <div class="upload-subtext">Click to change image</div>
                    `;

                    // Mark file as selected
                    uploadDiv.setAttribute('data-file-selected', 'true');
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation and submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            console.log('Form submit event triggered');
            const submitBtn = this.querySelector('.submit-btn');

            // Validate required fields
            const requiredFields = ['name', 'price', 'serchar', 'stock', 'comment', 'category'];
            for (let field of requiredFields) {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    console.log(`Validation failed for field: ${field}`);
                    alert(`Please fill in the ${field.replace(/([A-Z])/g, ' $1').toLowerCase()} field`);
                    input.focus();
                    e.preventDefault();
                    return;
                }
            }

            console.log('All fields validated, submitting form...');

            // Show loading but don't disable until after form submission
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Product...';

            // Disable the button after a short delay to allow form submission
            setTimeout(() => {
                submitBtn.disabled = true;
            }, 100);
        });

        // Initialize calculation on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
        });
    </script>
</body>

</html>

<?php
if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['category'])) {
    // Debug: Simple check to see if this code is being executed
    echo "<script>console.log('Form submission detected!');</script>";

    // Double-check admin authorization for form submission
    if (!isset($_SESSION['uname']) || !isset($_SESSION['acc']) || $_SESSION['acc'] != 1) {
        echo "<script>
            alert('Unauthorized access. Admin privileges required.');
            window.location.href = 'index.php';
        </script>";
        exit();
    }

    include "db.php";

    // Debug: Check database connection
    if ($conn->connect_error) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('Database connection failed: " . addslashes($conn->connect_error) . "', 'error');
            });
        </script>";
        exit();
    }

    // Debug: Check if form data is being received
    error_log("Form submitted with POST data: " . print_r($_POST, true));
    error_log("Files data: " . print_r($_FILES, true));

    // Sanitize and validate input
    $pname = trim($_POST['name']);
    $pprice = (int)$_POST['price'];  // Cast to int to match database
    $serchar = (int)$_POST['serchar']; // Cast to int to match database
    $pdes = trim($_POST['comment']);
    $category = $_POST['category'];
    $stock = (int)$_POST['stock'];

    // Debug: Log processed values
    error_log("Processed values - Name: $pname, Price: $pprice, Service: $serchar, Category: $category, Stock: $stock");

    // Validation
    if (empty($pname) || $pprice <= 0 || $serchar < 0 || empty($pdes) || empty($category) || $stock < 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('Please fill all fields with valid values', 'error');
                console.log('Validation failed: Name={$pname}, Price={$pprice}, Service={$serchar}, Category={$category}, Stock={$stock}');
            });
        </script>";
    } else {
        $ptax = 0.13 * $pprice;
        $total = $pprice + $ptax + $serchar;

        // Convert tax and total to strings to match database varchar fields
        $ptax_str = number_format($ptax, 1, '.', '');
        $total_str = number_format($total, 1, '.', '');

        // File upload handling
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $file_name = $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validate file
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($file_ext, $allowed_types)) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed', 'error');
                        // Re-enable the submit button
                        const submitBtn = document.querySelector('.submit-btn');
                        if (submitBtn) {
                            submitBtn.innerHTML = '<i class=\"fas fa-plus\"></i> Add Product to Store';
                            submitBtn.disabled = false;
                        }
                    });
                </script>";
            } else if ($file_size > $max_size) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification('File size too large. Please choose a file smaller than 5MB', 'error');
                        // Re-enable the submit button
                        const submitBtn = document.querySelector('.submit-btn');
                        if (submitBtn) {
                            submitBtn.innerHTML = '<i class=\"fas fa-plus\"></i> Add Product to Store';
                            submitBtn.disabled = false;
                        }
                    });
                </script>";
            } else {
                // Generate unique filename
                $new_filename = uniqid() . '.' . $file_ext;
                $file_folder = "../files/" . $new_filename;

                if (move_uploaded_file($file_tmp, $file_folder)) {
                    // Insert into database with prepared statement
                    $sql = "INSERT INTO uploads(pname,pprice,serchar,tax,total,pdes,fname,category,stock) VALUES(?,?,?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);

                    if (!$stmt) {
                        error_log("Database prepare failed: " . $conn->error);
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('Database prepare error: " . addslashes($conn->error) . "', 'error');
                            });
                        </script>";
                        return;
                    }

                    $stmt->bind_param("siisssssi", $pname, $pprice, $serchar, $ptax_str, $total_str, $pdes, $file_folder, $category, $stock);

                    error_log("Executing query with values: $pname, $pprice, $serchar, $ptax_str, $total_str, $pdes, $file_folder, $category, $stock");

                    if ($stmt->execute()) {
                        error_log("Product inserted successfully with ID: " . $conn->insert_id);
                        echo "<script>
                            showNotification('Product uploaded successfully! Redirecting...', 'success');
                            setTimeout(function() {
                                window.location.href = 'adminmain.php';
                            }, 2000);
                        </script>";

                        // Also add a meta refresh as backup
                        echo '<meta http-equiv="refresh" content="3;url=adminmain.php">';
                    } else {
                        error_log("Database execute failed: " . $stmt->error);
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification('Database error: " . addslashes($stmt->error) . "', 'error');
                                // Re-enable the submit button
                                const submitBtn = document.querySelector('.submit-btn');
                                if (submitBtn) {
                                    submitBtn.innerHTML = '<i class=\"fas fa-plus\"></i> Add Product to Store';
                                    submitBtn.disabled = false;
                                }
                            });
                        </script>";
                        unlink($file_folder); // Delete uploaded file if database insert fails
                    }
                    $stmt->close();
                } else {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showNotification('Failed to upload image file. Please try again', 'error');
                            // Re-enable the submit button
                            const submitBtn = document.querySelector('.submit-btn');
                            if (submitBtn) {
                                submitBtn.innerHTML = '<i class=\"fas fa-plus\"></i> Add Product to Store';
                                submitBtn.disabled = false;
                            }
                        });
                    </script>";
                }
            }
        } else {
            // Better error message when no file is uploaded
            if (!isset($_FILES['file']) || $_FILES['file']['error'] == 4) {
                $error_msg = 'Please select an image file to upload';
            } else {
                $error_msg = 'File upload error (Code: ' . $_FILES['file']['error'] . ')';
            }

            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('$error_msg', 'error');
                    // Re-enable the submit button
                    const submitBtn = document.querySelector('.submit-btn');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class=\"fas fa-plus\"></i> Add Product to Store';
                        submitBtn.disabled = false;
                    }
                });
            </script>";
        }
    }
    $conn->close();
}

// Add notification system
echo "<script>
function showNotification(message, type = 'info') {
    const existingNotif = document.querySelector('.notification');
    if (existingNotif) existingNotif.remove();

    const notification = document.createElement('div');
    notification.className = \`notification notification-\${type}\`;
    notification.innerHTML = \`
        <div class='notification-content'>
            <i class='fas \${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle'}'></i>
            <span>\${message}</span>
            <button class='notification-close' onclick='this.parentElement.parentElement.remove()'>
                <i class='fas fa-times'></i>
            </button>
        </div>
    \`;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>";

// Add notification CSS
echo "<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
    border-radius: var(--border-radius-lg);
    box-shadow: var(--shadow-xl);
    animation: slideInRight 0.3s ease-out;
}

.notification-success {
    background: var(--success-color);
    color: var(--white);
}

.notification-error {
    background: var(--danger-color);
    color: var(--white);
}

.notification-content {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-md);
}

.notification-close {
    background: none;
    border: none;
    color: currentColor;
    cursor: pointer;
    margin-left: auto;
    opacity: 0.8;
    transition: opacity var(--transition-fast);
}

.notification-close:hover {
    opacity: 1;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>";
?>