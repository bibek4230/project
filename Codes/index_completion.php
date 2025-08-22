                        <p class="text-muted">Shop with confidence using our secure payment system.</p>
                        </div>
                        </div>

                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <h4>24/7 Support</h4>
                                <p class="text-muted">Our customer support team is always here to help you.</p>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>

                        <!-- Admin Registration Form -->
                        <div class="auth-container" id="pra10" style="display: none;">
                            <div class="auth-card">
                                <div class="auth-brand">
                                    <img src="../images/logo.png" alt="BuyMart" class="auth-logo">
                                    <h2 class="auth-brand-title">Admin Access</h2>
                                    <p class="auth-brand-subtitle">
                                        Register as an administrator to manage the BuyMart platform and oversee all operations.
                                    </p>
                                    <div class="admin-features">
                                        <div class="admin-feature">
                                            <i class="fas fa-users-cog"></i>
                                            <span>User Management</span>
                                        </div>
                                        <div class="admin-feature">
                                            <i class="fas fa-chart-bar"></i>
                                            <span>Analytics Dashboard</span>
                                        </div>
                                        <div class="admin-feature">
                                            <i class="fas fa-cog"></i>
                                            <span>System Settings</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="auth-form-container">
                                    <div class="auth-form-header">
                                        <h3 class="auth-form-title">Admin Registration</h3>
                                        <p class="auth-form-subtitle">Complete the form to request admin access</p>
                                    </div>

                                    <form action="index.php" method="post" class="auth-form" id="adminForm">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-user me-2"></i>First Name
                                                </label>
                                                <input type="text" class="form-input" placeholder="First Name" name="afname" required>
                                                <div id="msg11" class="form-error"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-user me-2"></i>Last Name
                                                </label>
                                                <input type="text" class="form-input" placeholder="Last Name" name="alname" required>
                                                <div id="msg13" class="form-error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-user me-2"></i>Middle Name (Optional)
                                            </label>
                                            <input type="text" class="form-input" placeholder="Middle Name" name="amname">
                                            <div id="msg12" class="form-error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-map-marker-alt me-2"></i>Address
                                            </label>
                                            <textarea class="form-input form-textarea" placeholder="Complete address" name="aaddress" rows="3" required></textarea>
                                            <div id="msg15" class="form-error"></div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-envelope me-2"></i>Email
                                                </label>
                                                <input type="email" class="form-input" placeholder="admin@email.com" name="aemail" required>
                                                <div id="msg17" class="form-error"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-phone me-2"></i>Mobile Number
                                                </label>
                                                <input type="tel" class="form-input" placeholder="Mobile number" name="amobile" required>
                                                <div id="msg14" class="form-error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-venus-mars me-2"></i>Gender
                                            </label>
                                            <div class="radio-group">
                                                <label class="radio-item">
                                                    <input type="radio" name="agender" value="m" required>
                                                    <span class="radio-custom"></span>
                                                    <span class="radio-text">Male</span>
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="agender" value="f" required>
                                                    <span class="radio-custom"></span>
                                                    <span class="radio-text">Female</span>
                                                </label>
                                                <label class="radio-item">
                                                    <input type="radio" name="agender" value="o" required>
                                                    <span class="radio-custom"></span>
                                                    <span class="radio-text">Other</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-user-shield me-2"></i>Admin Username
                                                </label>
                                                <input type="text" class="form-input" placeholder="Admin username" name="auname" required>
                                                <div id="msg16" class="form-error"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-lock me-2"></i>Password
                                                </label>
                                                <div class="password-group">
                                                    <input type="password" class="form-input" placeholder="Secure password" name="apwd" required id="adminPassword">
                                                    <button type="button" class="password-toggle" onclick="togglePassword('adminPassword')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div id="msg18" class="form-error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-lock me-2"></i>Confirm Password
                                            </label>
                                            <div class="password-group">
                                                <input type="password" class="form-input" placeholder="Confirm password" name="apwd1" required id="adminConfirmPassword">
                                                <button type="button" class="password-toggle" onclick="togglePassword('adminConfirmPassword')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div id="msg19" class="form-error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label class="checkbox-group">
                                                <input type="checkbox" name="aterms" required>
                                                <span class="checkbox-custom"></span>
                                                <span class="checkbox-text">
                                                    I agree to the admin <a href="#" class="terms-link">Terms and Conditions</a> and understand my responsibilities
                                                </span>
                                            </label>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" name="post3" class="auth-btn auth-btn-warning">
                                                <i class="fas fa-user-shield"></i>
                                                Request Admin Access
                                            </button>
                                        </div>
                                    </form>

                                    <div class="form-footer">
                                        <p class="form-footer-text">Already have an account?</p>
                                        <button type="button" class="form-switch-link" onclick="login()">
                                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- JavaScript Functions -->
                        <script>
                            function login() {
                                hideAllForms();
                                document.getElementById("pra4").style.display = "flex";
                            }

                            function signup() {
                                hideAllForms();
                                document.getElementById("pra5").style.display = "flex";
                            }

                            function admin() {
                                hideAllForms();
                                document.getElementById("pra10").style.display = "flex";
                            }

                            function hideAllForms() {
                                document.getElementById("welcome").style.display = "none";
                                document.getElementById("pra4").style.display = "none";
                                document.getElementById("pra5").style.display = "none";
                                document.getElementById("pra10").style.display = "none";
                                document.getElementById("navigationTrigger").style.display = "none";
                            }

                            function togglePassword(inputId) {
                                const input = document.getElementById(inputId);
                                const icon = input.parentElement.querySelector('.password-toggle i');

                                if (input.type === 'password') {
                                    input.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    input.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            }

                            // Enhanced form validation
                            function validation() {
                                // Add your validation logic here
                                return true;
                            }
                        </script>

                        <!-- jQuery -->
                        <script src="../jquery/jquery.js"></script>

                        <!-- Bootstrap JS -->
                        <script src="../bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>

                        <!-- Custom JS -->
                        <script defer src="index.js"></script>

                        </body>

                        </html>