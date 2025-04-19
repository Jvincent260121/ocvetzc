<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: OCVETadmin.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["faq_question"]) && isset($_POST["faq_answer"])) {
    $newQuestion = trim($_POST["faq_question"]);
    $newAnswer = trim($_POST["faq_answer"]);
    if (!empty($newQuestion) && !empty($newAnswer)) {
        $faqs = json_decode(file_get_contents("faqs.json"), true) ?: [];
        $faqs[] = ["question" => $newQuestion, "answer" => $newAnswer];
        file_put_contents("faqs.json", json_encode($faqs, JSON_PRETTY_PRINT));
    }
    header("Location: OCVETadmindb.php?section=faqs"); 
    exit;
}

$section = isset($_GET['section']) ? $_GET['section'] : 'home'; 
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
    <header>
        <div class="logo-text-wrapper">
            <img id="ocvetlogo" src="ocvetlogo.png" alt="OCVET Logo">
            <div class="text-container">
                <h1><strong>OFICINA DE VETERENARIO CIUDAD DE ZAMBOANGA</strong></h1>
                <p><i>Office of the City Veterinarian, Zamboanga City</i></p>
            </div>
        </div>
    </header>
    <div class="content">
        <?php if ($section === 'home'): ?>
            <h1>Welcome to the OCVET Admin Dashboard</h1>
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