// loginSignup.js

$(document).ready(function() {
    // Inject CSS styles into the document
    const styles = `
        <style>
            .modal-overlay {
                display: none; /* Hidden initially */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); 
                z-index: 1000;
                display: flex; 
                justify-content: center; 
                align-items: center; 
            }

            .modal-content {
                position: relative;
                background-color: #fff;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                border-radius: 20px;
                width: 700px;
                max-width: 90%;
                height: auto;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: stretch;
                overflow: hidden;
                /* Remove any absolute positioning or margins that might interfere */
            }

            /* Welcome section styling */
            .welcome-section {
                flex: 1;
                background-color: #abc8d0;
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 20px;
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
            }

            /* Login section styling */
            .login-section {
                flex: 1;
                background-color: #fcebdc;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 20px;
                border-top-right-radius: 20px;
                border-bottom-right-radius: 20px;
            }

            form input {
                width: 90%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-family: Arial, sans-serif;

            }

            .welcome-section h2 {
                font-size: 24px;
                margin-bottom: 10px;
                font-family: 'Montserrat', sans-serif;
            }

            .register-btn {
                padding: 10px 20px;
                border: none;
                background-color: #5b8193;
                color: white;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                margin-top: 10px;
                transition: background-color 0.3s ease;
            }

            .register-btn:hover {
                background-color: #abc8d0;
            }

            .login-section h2 {
                margin-bottom: 15px;
                font-family: 'Montserrat', sans-serif;
                color: black;
            }

            .forgot-password {
                font-size: 12px;
                color: black;
                text-decoration: none;
                margin-top: 5px; /* Space above, between password input and link */
                margin-bottom: 15px; /* Space below, before the login button */
                width: 100%; /* Match the input's width */
                text-align: center; /* Center the text */
                display: block; /* Ensure it takes a new line */
            }

            .forgot-password:hover {
                text-decoration: underline;
            }

            .login-btn {
                padding: 10px 20px;
                border: none;
                background-color: #5b8193;
                color: white;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                transition: background-color 0.3s ease;
                width: 120px; /* Fixed width for the button */
                display: block; /* Ensure it takes a new line and can be centered */
                margin: 0 auto; /* Center the button horizontally */
            }

            .login-btn:hover {
                background-color: #8b3a3a;
            }

            .social-icons {
                margin-top: 15px;
            }

            .social-icons a {
                display: inline-block;
                margin: 0 5px;
                padding: 8px 12px;
                border-radius: 50%;
                background-color: #ddd;
                color: #555;
                font-weight: bold;
                text-decoration: none;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .social-icons a:hover {
                background-color: #6d2323;
                color: #fff;
            }
        </style>
    `;

    // Append styles to head if not already present
    if (!$('head').find('style[data-login-signup]').length) {
        $('head').append(styles.replace('<style>', '<style data-login-signup>'));
    }

    // Function to show the modal
    function showModal() {
        const modalHTML = `
            <div class="modal-overlay">
                <div class="modal-content">
                    <div class="welcome-section">
                        <h2>Hello, Welcome!</h2>
                        <p><i>Don't have an account?</i></p>
                        <button class="register-btn">REGISTER</button>
                    </div>
                    <div class="login-section">
                        <h2>Login</h2>
                        <form id="loginForm">
                            <input type="text" id="username" placeholder="Username" required>
                            <input type="password" id="password" placeholder="Password" required>
                            <a href="#" class="forgot-password"><i>Forgot Password?</i></a>
                            <button type="submit" class="login-btn">Login</button>
                        </form>
                        <div class="social-icons">
                            <a href="#">G</a>
                            <a href="#">F</a>
                            <a href="#">T</a>
                            <a href="#">in</a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append modal to body (not a specific #modal-content div)
        $('body').append(modalHTML);
        $('.modal-overlay').fadeIn(300);
    }

    // Function to hide the modal and redirect to main page
    function hideModal() {
        $('.modal-overlay').fadeOut(300, function() {
            $(this).remove();
        });
    }

    // Login/Signup button click handler
    $('.login-signup-btn').on('click', function(e) {
        e.preventDefault();
        showModal();

        // Handle form submission
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            const username = $('#username').val();
            const password = $('#password').val();

            if (username && password) {
                // Simulate successful login and redirect
                console.log('Login attempt with:', { username, password });
                window.location.href = 'OCVET-UserDashboard.html';
            } else {
                alert('Please enter both username and password.');
            }
        });

        // Close modal when clicking outside
        $(document).on('click', function(e) {
            if ($(e.target).hasClass('modal-overlay')) {
                hideModal();
            }
        });
    });

    // Handle register button (for future expansion)
    $(document).on('click', '.register-btn', function() {
        console.log('Register button clicked - implement signup logic here');
        // Add signup form or redirect as needed
    });
});