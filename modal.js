$(document).ready(function() {
    // Updated styles with centered modal and hidden horizontal scrollbar
    const styles = `
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            text-decoration: none;
            list-style: none;
        }

        .modal-overlay {
            display: none;
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

        .container {
            position: relative;
            width: 600px;
            height: 500px;
            background: #dfd7d0;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, .2);
            overflow-x: hidden;
            overflow-y: auto;
        }

        .container h1 {
            font-size: 28px;
            margin: -5px 0;
        }

        .container p {
            font-size: 13px;
            margin: 10px 0;
        }

        form { width: 100%; }

        .form-box {
            position: absolute;
            right: 0;
            width: 50%;
            height: 100%;
            background: #dfd7d0;
            display: flex;
            align-items: center;
            color: #333;
            text-align: center;
            padding: 30px;
            z-index: 1;
            transition: .6s ease-in-out 1.2s, visibility 0s 1s;
        }

        .container.active .form-box { right: 50%; }

        .form-box.register { visibility: hidden; }
        .container.active .form-box.register { visibility: visible; }

        .input-box {
            position: relative;
            margin: 10px 0;
            width: 100%;
        }

        .input-box input, .input-box select {
            width: 100%;
            padding: 10px 40px 10px 15px;
            background: #eee;
            border-radius: 6px;
            border: none;
            outline: none;
            font-size: 14px;
            color: #333;
            font-weight: 500;
            box-sizing: border-box;
        }

        .input-box input::placeholder, .input-box select::placeholder {
            color: #888;
            font-weight: 400;
        }

        .input-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        .forgot-link { margin: -10px 0 10px; }
        .forgot-link a {
            font-size: 13px;
            color: #333;
        }

        .btn {
            width: 100%;
            height: 40px;
            background: #7494ec;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0, 0, 0, .1);
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: #fff;
            font-weight: 600;
        }

        .social-icons {
            display: flex;
            justify-content: center;
        }

        .social-icons a {
            display: inline-flex;
            padding: 8px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 20px;
            color: #333;
            margin: 0 6px;
        }

        .toggle-box {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .toggle-box::before {
            content: '';
            position: absolute;
            left: -250%;
            width: 300%;
            height: 100%;
            background: #a3d2e3;
            border-radius: 100px;
            z-index: 2;
            transition: 1.8s ease-in-out;
        }

        .container.active .toggle-box::before { left: 50%; }

        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 2;
            transition: .6s ease-in-out;
        }

        .toggle-panel.toggle-left {
            left: 0;
            transition-delay: 1.2s;
        }

        .container.active .toggle-panel.toggle-left {
            left: -50%;
            transition-delay: .6s;
        }

        .toggle-panel.toggle-right {
            right: -50%;
            transition-delay: .6s;
        }

        .container.active .toggle-panel.toggle-right {
            right: 0;
            transition-delay: 1.2s;
        }

        .toggle-panel p { margin-bottom: 15px; font-size: 13px; }

        .toggle-panel .btn {
            width: 140px;
            height: 40px;
            background: transparent;
            border: 2px solid #fff;
            box-shadow: none;
            font-size: 14px;
        }

        @media screen and (max-width: 650px) {
            .container {
                width: 90%;
                max-width: 400px;
                height: calc(100vh - 30px);
                border-radius: 15px;
                overflow-x: hidden;
                overflow-y: auto;
            }

            .form-box {
                bottom: 0;
                width: 100%;
                height: 65%;
                padding: 20px;
            }

            .container.active .form-box {
                right: 0;
                bottom: 35%;
            }

            .toggle-box::before {
                left: 0;
                top: -270%;
                width: 100%;
                height: 300%;
                border-radius: 15vw;
            }

            .container.active .toggle-box::before {
                left: 0;
                top: 65%;
            }

            .container.active .toggle-panel.toggle-left {
                left: 0;
                top: -35%;
            }

            .toggle-panel {
                width: 100%;
                height: 35%;
            }

            .toggle-panel.toggle-left { top: 0; }
            .toggle-panel.toggle-right {
                right: 0;
                bottom: -35%;
            }

            .container.active .toggle-panel.toggle-right { bottom: 0; }

            .container h1 { font-size: 24px; }
            .container p { font-size: 12px; }
            .input-box input, .input-box select { font-size: 13px; padding: 8px 35px 8px 12px; }
            .input-box i { font-size: 16px; right: 12px; }
            .btn { height: 36px; font-size: 13px; }
            .social-icons a { font-size: 18px; padding: 6px; }
            .toggle-panel .btn { width: 120px; height: 36px; font-size: 13px; }
        }

        @media screen and (max-width: 400px) {
            .form-box { padding: 15px; }
            .toggle-panel h1 { font-size: 22px; }
            .container h1 { font-size: 20px; }
            .container p { font-size: 11px; }
            .input-box input, .input-box select { font-size: 12px; padding: 7px 30px 7px 10px; }
            .btn { height: 34px; font-size: 12px; }
        }
    `;

    // Append styles and external resources
    if (!$('style[data-login-signup]').length) {
        $('head').append(`<style data-login-signup>${styles}</style>`);
        $('head').append('<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">');
        $('head').append('<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">');
    }

    // Show login/signup modal
    function showModal() {
        console.log('showModal called');
        if ($('.modal-overlay').length > 0) {
            $('.modal-overlay').fadeIn(300);
            return;
        }
        const modalHTML = `
            <div class="modal-overlay">
                <div class="container">
                    <div class="form-box login">
                        <form id="loginForm">
                            <h1>Login</h1>
                            <div class="input-box">
                                <input type="text" id="username" placeholder="Username" required>
                                <i class='bx bxs-user'></i>
                            </div>
                            <div class="input-box">
                                <input type="password" id="password" placeholder="Password" required>
                                <i class='bx bxs-lock-alt'></i>
                            </div>
                            <div class="forgot-link">
                                <a href="#">Forgot Password?</a>
                            </div>
                            <button type="submit" class="btn">Login</button>
                            <p>or login with social platforms</p>
                            <div class="social-icons">
                                <a href="#"><i class='bx bxl-google'></i></a>
                                <a href="#"><i class='bx bxl-facebook'></i></a>
                                <a href="#"><i class='bx bxl-github'></i></a>
                                <a href="#"><i class='bx bxl-linkedin'></i></a>
                            </div>
                        </form>
                    </div>
                    <div class="form-box register">
                        <form id="signupForm">
                            <h1>Registration</h1>
                            <div class="input-box">
                                <input type="text" id="signup-username" placeholder="Username" required>
                                <i class='bx bxs-user'></i>
                            </div>
                            <div class="input-box">
                                <input type="email" id="signup-email" placeholder="Email" required>
                                <i class='bx bxs-envelope'></i>
                            </div>
                            <div class="input-box">
                                <input type="password" id="signup-password" placeholder="Password" required>
                                <i class='bx bxs-lock-alt'></i>
                            </div>
                            <button type="submit" class="btn">Register</button>
                            <p>or register with social platforms</p>
                            <div class="social-icons">
                                <a href="#"><i class='bx bxl-google'></i></a>
                                <a href="#"><i class='bx bxl-facebook'></i></a>
                                <a href="#"><i class='bx bxl-github'></i></a>
                                <a href="#"><i class='bx bxl-linkedin'></i></a>
                            </div>
                        </form>
                    </div>
                    <div class="toggle-box">
                        <div class="toggle-panel toggle-left">
                            <h1>Hello, Welcome!</h1>
                            <p>Don't have an account?</p>
                            <button class="btn register-btn">Register</button>
                        </div>
                        <div class="toggle-panel toggle-right">
                            <h1>Welcome Back!</h1>
                            <p>Already have an account?</p>
                            <button class="btn login-btn">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHTML);
        $('.modal-overlay').fadeIn(300);
    }

    // Hide modal
    function hideModal() {
        console.log('hideModal called');
        $('.modal-overlay').fadeOut(300, function() {
            $('.container').removeClass('active');
            $(this).remove();
        });
    }

    // Toggle between login and register
    $(document).on('click', '.register-btn', function(e) {
        e.preventDefault();
        console.log('Register button clicked');
        $('.container').addClass('active');
    });

    $(document).on('click', '.login-btn', function(e) {
        e.preventDefault();
        console.log('Login button clicked');
        $('.container').removeClass('active');
    });

    // Open login/signup modal
    window.openModal = function(event) {
        event.preventDefault();
        console.log('openModal called');
        showModal();
    };

    $(document).on('click', '.login-signup-btn', function(e) {
        e.preventDefault();
        console.log('Login/Signup button clicked');
        showModal();
    });

    // Login form submission
    $(document).on('submit', '#loginForm', function(e) {
        e.preventDefault();
        console.log('Login form submitted');
        var username = $('#username').val();
        var password = $('#password').val();
        console.log('Sending login request:', { username: username });

        $.ajax({
            url: 'api/login.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: username,
                password: password
            }),
            dataType: 'json',
            success: function(response) {
                console.log('Login response:', response);
                if (response.success) {
                    console.log('Login successful, redirecting...');
                    sessionStorage.setItem('user_id', response.user_id);
                    window.location.href = 'OCVET-UserDashboard.html';
                } else {
                    console.warn('Login failed:', response.error);
                    alert(response.error || 'Login failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', { status: status, error: error, xhr: xhr });
                console.log('Response text:', xhr.responseText);
                alert('Failed to connect to the server. Please try again.');
            }
        });
    });

    // Signup form submission
    $(document).on('submit', '#signupForm', function(e) {
        e.preventDefault();
        console.log('Signup form submitted');
        $.ajax({
            url: 'api/signup.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: $('#signup-username').val(),
                email: $('#signup-email').val(),
                password: $('#signup-password').val()
            }),
            dataType: 'json',
            success: function(response) {
                console.log('Signup response:', response);
                if (response.success) {
                    console.log('Signup successful, redirecting...');
                    sessionStorage.setItem('user_id', response.user_id);
                    window.location.href = 'OCVET-UserDashboard.html';
                } else {
                    console.warn('Signup failed:', response.error);
                    alert(response.error || 'Signup failed');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', { status: status, error: error, xhr: xhr });
                console.log('Response text:', xhr.responseText);
                alert('Failed to connect to the server. Please try again.');
            }
        });
    });

    // Close modal
    $(document).on('click', '.modal-overlay', function(e) {
        if ($(e.target).hasClass('modal-overlay')) {
            hideModal();
        }
    });
});