<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: OCVETadmin.html");
    exit;
}

// Handle FAQ submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["faq_question"]) && isset($_POST["faq_answer"])) {
    $newQuestion = trim($_POST["faq_question"]);
    $newAnswer = trim($_POST["faq_answer"]);
    if (!empty($newQuestion) && !empty($newAnswer)) {
        $faqs = json_decode(file_get_contents("faqs.json"), true) ?: [];
        $faqs[] = ["question" => $newQuestion, "answer" => $newAnswer];
        file_put_contents("faqs.json", json_encode($faqs, JSON_PRETTY_PRINT));
    }
    header("Location: OCVETadmindb.php?section=faqs"); // Refresh page to FAQs section
    exit;
}

// Determine which section to display
$section = isset($_GET['section']) ? $_GET['section'] : 'home'; // Default to 'home'
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
        <a href="?section=home" class="<?php echo $section === 'home' ? 'active' : ''; ?>">
            <svg class="icon" viewBox="0 0 24 24"><path d="M3 13h2v8h6v-6h2v6h6v-8h2L12 3z" fill="white"/></svg>
            <span>Home</span>
        </a>
        <a href="?section=faqs" class="<?php echo $section === 'faqs' ? 'active' : ''; ?>">
            <svg class="icon" viewBox="0 0 24 24"><path d="M7 11h10M7 15h7M3 8h18M3 4h18v16H3z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Faqs</span>
        </a>
        <a href="?section=specialPrograms">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 3l4 7H8l4-7zM4 21c0-4 4-5 8-5s8 1 8 5H4z" fill="white"/></svg>
            <span>Special Programs</span>
        </a>
        <a href="?section=news">
            <svg class="icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>News</span>
        </a>
        <a href="?section=appointment">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7zm0-2a5 5 0 1 0 0-10 5 5 0 0 0 0 10z" fill="white"/></svg>
            <span>Appointment</span>
        </a>
        <a href="?section=records">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7zm0-2a5 5 0 1 0 0-10 5 5 0 0 0 0 10z" fill="white"/></svg>
            <span>Records</span>
        </a>
        <a href="#logout" onclick="showLogoutPopup()">
            <svg class="icon" viewBox="0 0 24 24"><path d="M16 17l5-5-5-5m-9 5h14m-14 9h14m-14-18h14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Log-out</span>
        </a>
    </div>

    <div class="content">
        <?php if ($section === 'home'): ?>
            <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <p>Manage your appointments, pet records, and messages here.</p>
            <div class="dashboard-overview">
                <div class="card">
                    <h3>Appointments</h3>
                    <p>View and manage upcoming appointments.</p>
                    <a href="?section=appointment" class="btn">Go to Appointments</a>
                </div>
                <div class="card">
                    <h3>FAQs</h3>
                    <p>Add or edit frequently asked questions.</p>
                    <a href="?section=faqs" class="btn">Manage FAQs</a>
                </div>
                <div class="card">
                    <h3>Records</h3>
                    <p>Access pet records and history.</p>
                    <a href="?section=records" class="btn">View Records</a>
                </div>
            </div>
        <?php elseif ($section === 'faqs'): ?>
            <!-- FAQ Management Section -->
            <div class="faq-management">
                <h2>Add New FAQ</h2>
                <form method="POST" action="OCVETadmindb.php?section=faqs">
                    <div class="input-group">
                        <label for="faq_question">Question:</label>
                        <input type="text" id="faq_question" name="faq_question" required>
                    </div>
                    <div class="input-group">
                        <label for="faq_answer">Answer:</label>
                        <textarea id="faq_answer" name="faq_answer" required rows="4"></textarea>
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
                            echo "<div class='faq-item'>";
                            echo "<span class='faq-number'>" . ($index + 1) . ".</span>";
                            echo "<div>";
                            echo "<p><strong>Question:</strong> " . htmlspecialchars($faq["question"]) . "</p>";
                            echo "<p><strong>Answer:</strong> " . htmlspecialchars($faq["answer"]) . "</p>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        <?php else: ?>
            <h1>Section Under Construction</h1>
            <p>This section is not yet implemented. Please select another option from the sidebar.</p>
        <?php endif; ?>
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