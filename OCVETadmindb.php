<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: OCVETadmin.html");
    exit;
}

// Handle FAQ submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["faq_question"])) {
    $newFaq = trim($_POST["faq_question"]);
    if (!empty($newFaq)) {
        $faqs = json_decode(file_get_contents("faqs.json"), true) ?: [];
        $faqs[] = ["question" => $newFaq];
        file_put_contents("faqs.json", json_encode($faqs, JSON_PRETTY_PRINT));
    }
    header("Location: OCVETadmindb.php"); // Refresh page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vet Clinic Dashboard</title>
    <link rel="stylesheet" href="OCVETadmindashboard.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <svg class="icon" viewBox="0 0 24 24"><path d="M3 6h18M3 12h18m-18 6h18" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
        <a href="#home">
            <svg class="icon" viewBox="0 0 24 24"><path d="M3 13h2v8h6v-6h2v6h6v-8h2L12 3z" fill="white"/></svg>
            <span>Home</span>
        </a>
        <a href="#specialPrograms">
            <svg class="icon" viewBox="0 0 24 24"><path d="M7 11h10M7 15h7M3 8h18 grimaceM3 4h18v16H3z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Special Programs</span>
        </a>
        <a href="#services">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 3l4 7H8l4-7zM4 21c0-4 4-5 8-5s8 1 8 5H4z" fill="white"/></svg>
            <span>Services</span>
        </a>
        <a href="#news">
            <svg class="icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>News</span>
        </a>
        <a href="#faqs">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7zm0-2a5 5 0 1 0 0-10 5 5 0 0 0 0 10z" fill="white"/></svg>
            <span>FAQs</span>
        </a>
        <a href="#logout" onclick="showLogoutPopup()">
            <svg class="icon" viewBox="0 0 24 24"><path d="M16 17l5-5-5-5m-9 5h14m-14 9h14m-14-18h14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Log-out</span>
        </a>
    </div>
    <div class="content">
        <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>Manage your appointments, pet records, and messages here.</p>

        <!-- FAQ Management Section -->
        <div class="faq-management">
            <h2>Add New FAQ</h2>
            <form method="POST" action="OCVETadmindb.php">
                <div class="input-group">
                    <label for="faq_question">Question:</label>
                    <input type="text" id="faq_question" name="faq_question" required>
                </div>
                <button type="submit" class="add-btn">Add FAQ</button>
            </form>

            <h2>Current FAQs</h2>
            <div class="faqs-list">
                <?php
                $faqs = json_decode(file_get_contents("faqs.json"), true) ?: [];
                if (empty($faqs)) {
                    echo "<p>No FAQs added yet.</p>";
                } else {
                    foreach ($faqs as $index => $faq) {
                        echo "<div class='faq-item'><span class='faq-number'>" . ($index + 1) . ".</span><p>" . htmlspecialchars($faq["question"]) . "</p></div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="overlay" onclick="closeLogoutPopup()"></div>
    <div class="logout-popup">
        <h2>Are you sure you want to log out?</h2>
        <button class="yes-btn" onclick="confirmLogout()">Yes</button>
        <button class="no-btn" onclick="closeLogoutPopup()">No</button>
    </div>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
        function showLogoutPopup() {
            document.querySelector('.logout-popup').style.display = 'block';
            document.querySelector('.overlay').style.display = 'block';
        }
        function closeLogoutPopup() {
            document.querySelector('.logout-popup').style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        }
        function confirmLogout() {
            window.location.href = 'OCVETadmin.html';
        }
    </script>
</body>
</html>