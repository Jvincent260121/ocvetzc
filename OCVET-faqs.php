<?php
// Load FAQs from faqs.json
$faqs = json_decode(file_get_contents("faqs.json"), true) ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office of the City Veterinarian - Zamboanga City</title>
    <link rel="stylesheet" href="OCVET-faqs.css">
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
                <p><em>Office of the City Veterinarian, Zamboanga City</em></p>
            </div>
        </div>
    </header>

    <nav>
        <div class="nav-logo">
            <img src="ocvetlogo.png" alt="Nav Logo" style="width: 50px; height: 50px;">
            <span class="nav-logo-text">OCVET</span>
        </div>
        <div class="nav-links">
            <a href="OCVET-Homepage.html">HOME</a>
            <a href="OCVET-aboutUs.html">ABOUT US</a>
            <a href="OCVET-faqs.php" aria-current="page">FAQs</a>
            <a href="#programs">SPECIAL PROGRAMS</a>
            <a href="#news">NEWS</a>
            <a href="#" class="login-signup-btn" onclick="openModal(event)">LOGIN / SIGN UP</a>
        </div>
        <div class="nav-search">
            <!-- This will be populated with the search-container when scrolled -->
        </div>
    </nav>

    <main>
        <section class="faq-section" aria-labelledby="faq-heading">
            <h2 id="faq-heading">How Can We Help You?</h2>
            <?php
            if (empty($faqs)) {
                echo "<p>No FAQs available at the moment.</p>";
            } else {
                foreach ($faqs as $index => $faq) {
                    $faqId = "faq" . ($index + 1);
                    echo '<div class="faq-item">';
                    echo '<button class="faq-question" aria-expanded="false" aria-controls="' . $faqId . '" aria-label="Expand FAQ about ' . htmlspecialchars($faq["question"]) . '">' . htmlspecialchars($faq["question"]) . '</button>';
                    echo '<div class="faq-answer" id="' . $faqId . '">';
                    echo '<p>' . htmlspecialchars($faq["answer"]) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </section>
    </main>

    <footer class="footer" aria-label="Footer">
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
                <p><a href="tel:+63629850247">(062) 985-0247</a></p>
            </div>
            <div class="footer-column">
                <h3>SOCIAL MEDIA LINKS</h3>
                <ul>
                    <li><a href="http://www.facebook.com/ocvet" target="_blank" rel="noopener noreferrer">Facebook</a></li>
                    <li><a href="#instagram" target="_blank" rel="noopener noreferrer">Instagram</a></li>
                    <li><a href="#x" target="_blank" rel="noopener noreferrer">X</a></li>
                    <li><a href="#youtube" target="_blank" rel="noopener noreferrer">YouTube</a></li>
                </ul>
            </div>
            <div class="footer-logos">
                <img src="ocvetlogo.png" alt="OCVET Logo">
                <img src="zambo.jpg" alt="Zamboanga City Official Seal">
                <img src="cityhealth.png" alt="Zamboanga City Health Office Logo">
            </div>
        </div>
        <div class="footer-bottom">
            <p>© Copyright 2025 OCVET Zamboanga</p>
            <p>For any security issues, please contact <a href="mailto:support@OCVETZC.com">support@OCVETZC.com</a></p>
        </div>
    </footer>

    <div id="loginModal" style="display: none;">
        <div class="modal-content">
            <span class="modal-close">×</span>
            <div class="tab-group">
                <div class="tab active"><a href="#login" onclick="switchTab('login')">Login</a></div>
                <div class="tab"><a href="#signup" onclick="switchTab('signup')">Sign Up</a></div>
            </div>
            <div class="tab-content">
                <div id="login" class="active">
                    <form id="loginForm">
                        <label for="loginEmail">Email:</label>
                        <input type="email" id="loginEmail" name="email" required>
                        <label for="loginPassword">Password:</label>
                        <input type="password" id="loginPassword" name="password" required>
                        <button type="submit">Login</button>
                    </form>
                </div>
                <div id="signup">
                    <form id="signupForm">
                        <label for="signupEmail">Email:</label>
                        <input type="email" id="signupEmail" name="email" required>
                        <label for="signupPassword">Password:</label>
                        <input type="password" id="signupPassword" name="password" required>
                        <button type="submit">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-content"></div>

    <script src="OCVETjs.js"></script>
    <script src="modal.js"></script>
</body>
</html>