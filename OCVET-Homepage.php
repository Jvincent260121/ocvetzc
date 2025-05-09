<?php
$faqs = json_decode(file_get_contents("faqs.json"), true) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office of the City Veterinarian - Zamboanga City</title>
    <link rel="stylesheet" href="OCVET.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/b13def851d7a78ce98af9c8bc60e166d?family=Agrandir+Narrow" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo-text-wrapper">
            <img id="ocvetlogo" src="ocvetlogo.png" alt="OCVET Logo">
            <div class="text-container">
                <h1><strong>OFICINA DE VETERENARIO CIUDAD DE ZAMBOANGA</strong></h1>
                <p><i>Office of the City Veterinarian, Zamboanga City</i></p>
            </div>
        </div>

        <div class="search-container" style="position: absolute; right: 20px; top: 35px;">
            <div class="container">
                <input type="text" name="text" class="search" required="" placeholder="Type to search...">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                        <title>Search</title>
                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    <nav>
        <div class="nav-logo">
            <img src="ocvetlogo.png" alt="Nav Logo" style="width: 50px; height: 50px;">
            <span class="nav-logo-text">OCVET</span>
        </div>
        <div class="nav-links">
            <a href="#home">HOME</a>
            <a href="OCVET-aboutUs.html" onclick="goToAboutUs()">ABOUT US</a>
            <a href="#faq">FAQs</a>
            <a href="#programs">SPECIAL PROGRAMS</a>
            <a href="#news">NEWS</a>
            <a href="#appointment" onclick="openModal()">LOGIN / SIGN UP</a>
        </div>
        <div class="nav-search">
            <!-- This will be populated with the search-container when scrolled -->
        </div>
    </nav>

    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <div id="paragraph">
                <p><i>“WE CARE FOR YOUR PETS<br>AS WE WOULD OUR OWN”</i></p>
            </div>
            <button type="button" class="apt-btn"  onclick="openModal()">BOOK AN APPOINTMENT</button>
            <p class="contact-number"><strong>Or give us a call at</strong> (062) 985 0247</p>
        </div>
    </section>

    <section class="about-us">
        <div class="about-part">
            <h2>GET TO KNOW US</h2>
            <div class="content-image-container">
                <div class="about-content">
                    <p>At OCVET, we believe that every pet deserves love, care, and quality veterinary services. Our team is dedicated to providing compassionate and professional care for your furry companions, ensuring they stay happy and healthy. Whether it’s a routine check-up or an emergency, we’re here for you and your pets!</p>
                    <p>We’re more than just a clinic—we’re a community that values responsible pet ownership and animal welfare. Thank you for trusting us with your beloved pets!</p>
                    <button class="learn-more-btn" onclick="goToAboutUs()">LEARN MORE</button>
                </div>
                <div class="about-image">
                    <img src="OCVETimg4.png" alt="Dog Image">
                </div>
            </div>
        </div>
    </section>

    <section class="special-programs">
        <div class="special-programs-container">
            <h2>SPECIAL PROGRAMS</h2> <!-- Fixed typo -->
            <div class="special-image">
                <img src="OCVETimg5.png" alt="Special Programs Image">
            </div>
            <button class="learn-more-btn">LEARN MORE</button>
        </div>
    </section>

    <!-- New Services Section -->
    <section class="services">
        <div class="services-container">
            <div class="services-header">
                <h2><span>SERVICES</span><br>WE OFFER</h2>
            </div>
            <div class="services-grid">
                <div class="service-item">
                    <i class="fas fa-paw"></i>
                    <p>ANIMAL HEALTH SERVICES</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-shield-alt"></i>
                    <p>PUBLIC SAFETY AND ANIMAL CONTROL</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-tractor"></i>
                    <p>LIVESTOCK AND AGRICULTURAL SUPPORT</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-drumstick-bite"></i>
                    <p>MEAT INSPECTION AND FOOD SAFETY</p>
                </div>
                <div class="service-item">
                    <i class="fas fa-virus"></i>
                    <p>ZOONOTIC DISEASE PREVENTION AND CONTROL</p>
                </div>
            </div>
            <button class="view-all-btn">VIEW ALL SERVICES</button>
        </div>
    </section>

    <!-- New News Section -->
    <section class="news">
        <div class="news-container">
            <h2>NEWS</h2>
            <div class="news-grid">
                <div class="news-item">
                    <img src="news-img1.png" alt="Zamboanga City Rabies Awareness">
                    <p class="news-date">March 4, 2026</p>
                    <h3>Zamboanga City officially launched Rabies Awareness Month</h3>
                    <p>Zamboanga City officially launched Rabies Awareness Month on March 4, 2026, with the theme: Rabies-free na, pusa’t-aso, kaligtasan ng pamilyang Pilipino: Magpabakuna Na! The event began with a motorcade from the City Health Office to Don Gregorio Evangelista Memorial School (DONGEMS), spearheaded by the Office of the City Veterinarian and members of Zamboanga City...</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
                <div class="news-item">
                    <img src="news-img2.png" alt="Spay and Neuter Activity">
                    <p class="news-date">February 27, 2026</p>
                    <h3>Spay and Neuter Activity</h3>
                    <p>The Office of the City Veterinarian conducted low-cost spay and neuter activity for cats on the year 2026. A total of 63 animals were spayed and neutered, providing services to 23 clients. Help control the pet population by having your pets spayed or neutered. For those interested in this service, we recommend that you register your pets in advance at City Pound located at San Roque Malagutay Drive. We don’t have online registration...</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
                <div class="news-item">
                    <img src="news-img3.png" alt="Anti-Rabies Vaccination Drive">
                    <p class="news-date">February 25, 2026</p>
                    <h3>Anti-Rabies Vaccination, Deworming, Consultation and Free Veterinary Drive</h3>
                    <p>As part of the pre-anniversary activities for its 57th Founding Anniversary, the Coast Guard District Southwestern Mindanao (CGDSWM), in partnership with the Office of the City Veterinarian, successfully conducted an Anti-Rabies Vaccination Drive, Deworming, and Free Veterinary Consultation on February 25, 2026, at...</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </div>
            <button class="learn-more-btn">LEARN MORE</button>
        </div>
    </section>

    <!-- New FAQs Section -->
    <section class="faqs">
        <div class="faqs-container">
            <h2>FAQs</h2>
            <div class="faqs-grid">
                <?php
                if (empty($faqs)) {
                    echo '<div class="faq-item"><span class="faq-number">1.</span><p>No FAQs available yet.</p></div>';
                } else {
                    foreach ($faqs as $index => $faq) {
                        echo '<div class="faq-item">';
                        echo '<span class="faq-number">' . ($index + 1) . '.</span>';
                        echo '<p>' . htmlspecialchars($faq["question"]) . '</p>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <button class="more-btn">MORE</button>
        </div>
    </section>

     <!-- LOGIN / SIGN UP -->
    <div id="loginModal" class="modal">
        <div class="modal-container">
            <ul class="tab-group">
                <li class="tab active"><a href="#signup" onclick="switchTab('signup')">Sign Up</a></li>
                <li class="tab"><a href="#login" onclick="switchTab('login')">Log In</a></li>
            </ul>
            <div class="tab-content">
                <div id="signup" class="active">
                    <h1>Ready to Create an Account?</h1>
                    <form onsubmit="return handleFormSubmit(event)" action="OCVET-UserDashboard.html" method="GET">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="input" required aria-label="Last Name">
                                <label class="user-label">Last Name</label>
                            </div>
                            <div class="input-group">
                                <input type="text" class="input" required aria-label="First Name">
                                <label class="user-label">First Name</label>
                            </div>
                            <div class="input-group">
                                <input type="email" class="input" required aria-label="Email Address">
                                <label class="user-label">Email Address</label>
                            </div>
                            <div class="input-group">
                                <input type="password" id="password" class="input" required aria-label="Create Your Password">
                                <label class="user-label">Create Your Password</label>
                                <span id="passwordMessage" class="message"></span>
                            </div>
                            <div class="input-group">
                                <input type="password" id="confirmPassword" class="input" required aria-label="Confirm Your Password">
                                <label class="user-label">Confirm Your Password</label>
                                <span id="passwordMatchMessage" class="message error">Passwords do not match.</span>
                            </div>
                        </div>
                        <div class="custom-checkbox-container">
                            <input class="custom-checkbox-input" id="modernCheckbox" type="checkbox" required />
                            <label class="custom-checkbox-label" for="modernCheckbox">
                                <span class="custom-checkbox-text">By continuing you are confirming that you have read, understood, and agreed to our <a href="#">Terms and Conditions</a></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit">Get Started</button>
                        </div>
                    </form>
                </div>
                <div id="login">
                    <h1>Welcome Back!</h1>
                    <form action="OCVET-UserDashboard.html" method="GET">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="email" class="input" required aria-label="Email Address">
                                <label class="user-label">Email Address</label>
                            </div>
                            <div class="input-group">
                                <input type="password" name="password" class="input" required aria-label="Password">
                                <label class="user-label">Password</label>
                            </div>
                        </div>
                        <p class="forgot"><a href="#">Forgot Password?</a></p>
                        <div class="form-group">
                            <button type="submit">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal(event)" aria-label="Close Modal">×</button>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3>ABOUT OCVET ZAMBOANGA</h3>
                <ul>
                    <li><a href="#mission">Mission</a></li>
                    <li><a href="#vision">Vision</a></li>
                    <li><a href="#objectives">Objectives</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>CONTACT INFORMATION</h3>
                <p>Office of the City Veterinarian, San Roque, Philippines</p>
                <p>Weekdays, 8:00am – 5:00pm</p>
                <p><a href="mailto:ocvetzamboangacity@gmail.com">ocvetzamboangacity@gmail.com</a></p>
                <p>(062) 985 0247</p>
            </div>
            <div class="footer-column">
                <h3>SOCIAL MEDIA LINKS</h3>
                <ul>
                    <li><a href="http://www.facebook.com/ocvet" target="_blank">Facebook</a></li>
                    <li><a href="#instagram" target="_blank">Instagram</a></li>
                    <li><a href="#x" target="_blank">X</a></li>
                    <li><a href="#youtube" target="_blank">YouTube</a></li>
                </ul>
            </div>
            <div class="footer-logos">
                <!-- Replace with actual logo paths -->
                <img src="ocvetlogo.png" alt="City of Zamboanga Seal">
                <img src="zambo.jpg" alt="Zamboanga Sibugay Seal">
                <img src="cityhealth.png" alt="OCVET Logo">
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; Copyright 2025 OCVET Zamboanga</p>
            <p>For any security issues, please contact <a href="mailto:support@OCVETZC.com">support@OCVETZC.com</a></p>
        </div>
    </footer>

    <script src="OCVETjs.js"></script>
</body>
</html>