<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCVET - Appointments</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #05234b;
            --secondary-color: #abc8d0;
            --accent-color: #0a8ba8;
            --background-color: #ece8e5;
            --white: #ffffff;
            --text-color: #333333;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
            background: var(--background-color);
            overflow-x: hidden;
        }

        header {
            background: linear-gradient(rgba(236, 232, 229, 0.2), rgba(236, 232, 229, 0.2)), url('OCVETheadbar.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: var(--primary-color);
            padding: 1.5rem;
            width: calc(100% - 80px);
            margin-left: 80px;
            position: fixed;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 80px;
            display: flex;
            align-items: center;
            transition: width 0.3s ease, margin-left 0.3s ease;
        }

        .sidebar.expanded ~ header {
            width: calc(100% - 250px);
            margin-left: 250px;
        }

        header h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 80px;
            background: var(--secondary-color);
            padding: 1.5rem 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: width 0.3s ease;
            height: 100vh;
            z-index: 999;
            overflow-y: auto;
        }

        .sidebar.expanded {
            width: 250px;
        }

        .sidebar .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem 0;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo-container img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .sidebar .logo-container span {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 0.5rem;
            display: none;
        }

        .sidebar.expanded .logo-container span {
            display: block;
        }

        .sidebar a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            white-space: nowrap;
        }

        .sidebar a:hover {
            background: var(--accent-color);
            color: var(--white);
        }

        .sidebar a:hover .icon {
            fill: var(--white);
        }

        .sidebar:not(.expanded) a span {
            display: none;
        }

        .sidebar:not(.expanded) a {
            justify-content: center;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.3s ease;
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .toggle-btn:hover {
            color: var(--accent-color);
        }

        .icon {
            width: 24px;
            height: 24px;
            fill: var(--primary-color);
            transition: fill 0.3s ease;
        }

        .content {
            flex: 1;
            padding: 2rem;
            margin-left: 80px;
            margin-top: 80px;
            transition: margin-left 0.3s ease;
        }

        .sidebar.expanded ~ .content {
            margin-left: 250px;
        }

        .content h2 {
            color: var(--primary-color);
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .appointment-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .appointment-table {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .appointment-table h3 {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .appointment-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .appointment-table th,
        .appointment-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 0.875rem;
        }

        .appointment-table th {
            color: var(--primary-color);
            font-weight: 600;
        }

        .appointment-table td {
            color: var(--text-color);
        }

        .content input,
        .content select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--text-color);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
        }

        .content button {
            padding: 0.75rem;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .content button.create-btn {
            background: var(--accent-color);
            color: var(--white);
            margin-bottom: 1rem;
        }

        .content button.edit-btn,
        .content button.delete-btn {
            padding: 0.5rem;
            font-size: 0.75rem;
            margin-right: 0.5rem;
        }

        .content button.edit-btn {
            background: #f0ad4e;
            color: var(--white);
        }

        .content button.delete-btn {
            background: #d9534f;
            color: var(--white);
        }

        .content button[type="submit"] {
            background: var(--accent-color);
            color: var(--white);
        }

        .content button[type="button"] {
            background: var(--text-color);
            color: var(--white);
        }

        .content button:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        .content label {
            color: var(--text-color);
            font-size: 0.875rem;
        }

        .content a {
            color: var(--accent-color);
            text-decoration: underline;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            z-index: 1000;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 500px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            overflow-y: auto;
        }

        .modal-content {
            padding: 1.5rem;
        }

        .modal h3 {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .modal form {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .modal input,
        .modal select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--text-color);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
        }

        .modal button {
            padding: 0.75rem;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal button[type="submit"] {
            background: var(--accent-color);
            color: var(--white);
        }

        .modal button[type="button"] {
            background: var(--text-color);
            color: var(--white);
        }

        .modal button:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        .modal label {
            color: var(--text-color);
            font-size: 0.875rem;
        }

        .modal a {
            color: var(--accent-color);
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 0.875rem;
        }

        .logout-popup,
        .delete-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--white);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            display: none;
            text-align: center;
            z-index: 1001;
            width: 90%;
            max-width: 300px;
        }

        .logout-popup h2,
        .delete-popup h2 {
            margin-bottom: 1rem;
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .logout-popup button,
        .delete-popup button {
            padding: 0.75rem 1.5rem;
            margin: 0.5rem;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-popup .yes-btn,
        .delete-popup .yes-btn {
            background: var(--accent-color);
            color: var(--white);
        }

        .logout-popup .no-btn,
        .delete-popup .no-btn {
            background: var(--text-color);
            color: var(--white);
        }

        .logout-popup button:hover,
        .delete-popup button:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar.expanded {
                width: 200px;
            }

            .content {
                margin-left: 80px;
            }

            .sidebar.expanded ~ .content {
                margin-left: 200px;
            }

            header {
                width: calc(100% - 80px);
                margin-left: 80px;
            }

            .sidebar.expanded ~ header {
                width: calc(100% - 200px);
                margin-left: 200px;
            }

            .modal {
                width: 90%;
                height: auto;
                max-height: 80vh;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 1rem;
            }

            header h1 {
                font-size: 1.25rem;
            }

            .content h2 {
                font-size: 1.5rem;
            }

            .modal {
                padding: 1rem;
            }

            .modal h3 {
                font-size: 1rem;
            }

            .modal button {
                padding: 0.5rem;
                font-size: 0.875rem;
            }

            .appointment-table th,
            .appointment-table td {
                padding: 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo-container">
            <img id="ocvetlogo" src="ocvetlogo.png" alt="OCVET Logo">
            <span>OCVET</span>
        </div>
        <button class="toggle-btn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
            <svg class="icon" viewBox="0 0 24 24"><path d="M3 6h18M3 12h18m-18 6h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
        <a href="#dashboard" onclick="navigateTo('dashboard')" aria-label="Dashboard">
            <svg class="icon" viewBox="0 0 24 24"><path d="M3 13h2v8h6v-6h2v6h6v-8h2L12 3z" fill="currentColor"/></svg>
            <span>Dashboard</span>
        </a>
        <a href="#appointments" onclick="navigateTo('appointments')" aria-label="Appointments">
            <svg class="icon" viewBox="0 0 24 24"><path d="M7 11h10M7 15h7M3 8h18M3 4h18v16H3z" fill="currentColor"/></svg>
            <span>Appointments</span>
        </a>
        <a href="#pet-records" onclick="navigateTo('pet-records')" aria-label="Pet Records">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 3l4 7H8l4-7zM4 21c0-4 4-5 8-5s8 1 8 5H4z" fill="currentColor"/></svg>
            <span>Pet Records</span>
        </a>
        <a href="#messages" onclick="navigateTo('messages')" aria-label="Messages">
            <svg class="icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" fill="currentColor"/></svg>
            <span>Messages</span>
        </a>
        <a href="#profile" onclick="navigateTo('profile')" aria-label="Profile">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7zm0-2a5 5 0 1 0 0-10 5 5 0 0 0 0 10z" fill="currentColor"/></svg>
            <span>Profile</span>
        </a>
        <a href="#logout" onclick="showLogoutPopup()" aria-label="Log Out">
            <svg class="icon" viewBox="0 0 24 24"><path d="M16 17l5-5-5-5m-9 5h14m-14 9h14m-14-18h14" fill="currentColor"/></svg>
            <span>Log-out</span>
        </a>
    </div>

    <header>
        <h1 id="header-title">User Dashboard</h1>
    </header>

    <div class="content">
        <h2>Appointments</h2>
        <div class="appointment-container">
            <button class="create-btn" id="createAppointmentBtn">Create Appointment</button>
            <div class="appointment-table">
                <h3>Your Appointments</h3>
                <table id="appointmentsTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Pet</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="modal" id="appointmentModal">
        <div class="modal-content">
            <h3 id="appointmentModalTitle">Create Appointment</h3>
            <form id="appointmentForm">
                <input type="hidden" id="appointment_id">
                <input type="text" id="fname" placeholder="First Name" required>
                <input type="text" id="mname" placeholder="Middle Name">
                <input type="text" id="lname" placeholder="Last Name" required>
                <input type="text" id="address" placeholder="Address">
                <input type="date" id="date_of_birth" placeholder="Date of Birth">
                <select id="sex" required>
                    <option value="">Select Sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <select id="civil_status" required>
                    <option value="">Select Civil Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
                <input type="text" id="nationality" placeholder="Nationality">
                <input type="text" id="place_of_birth" placeholder="Place of Birth">
                <input type="text" id="contact_number" placeholder="Contact Number">
                <input type="email" id="email_address" placeholder="Email Address">
                <select id="pet_id" required>
                    <option value="">Select Pet</option>
                </select>
                <input type="date" id="appointment_date" placeholder="Appointment Date" required>
                <input type="time" id="appointment_time" placeholder="Appointment Time" required>
                <input type="text" id="purpose" placeholder="Purpose (e.g., Vaccination, Checkup)" required>
                <button type="button" id="addPetRecordBtn">Add Pet Record</button>
                <label><input type="checkbox" id="terms_accepted" required> I agree to the <a href="/terms">Terms and Conditions</a></label>
                <button type="submit">Save Appointment</button>
                <button type="button" id="closeAppointmentModalBtn">Close</button>
            </form>
            <div id="errorMessage" class="error" style="display: none;"></div>
        </div>
    </div>

    <div class="modal" id="petRecordModal">
        <div class="modal-content">
            <h3>Add Pet Record</h3>
            <form id="petRecordForm">
                <input type="text" id="pet_name" placeholder="Pet Name" required>
                <input type="text" id="species" placeholder="Species" required>
                <select id="pet_sex" required>
                    <option value="">Select Sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Unknown">Unknown</option>
                </select>
                <input type="number" id="age" placeholder="Age" required min="0">
                <input type="text" id="breed" placeholder="Breed">
                <input type="text" id="color_markings" placeholder="Color/Markings">
                <button type="submit">Save Pet</button>
                <button type="button" id="closePetModalBtn">Close</button>
                <div id="petErrorMessage" class="error" style="display: none;"></div>
            </form>
        </div>
    </div>

    <div class="overlay" id="logoutOverlay"></div>
    <div class="logout-popup" id="logoutPopup">
        <h2>Are you sure you want to log out?</h2>
        <button class="yes-btn" onclick="confirmLogout()">Yes</button>
        <button class="no-btn" onclick="closeLogoutPopup()">No</button>
    </div>

    <div class="delete-popup" id="deletePopup">
        <h2>Are you sure you want to delete this appointment?</h2>
        <button class="yes-btn" id="confirmDeleteBtn">Yes</button>
        <button class="no-btn" onclick="closeDeletePopup()">No</button>
    </div>

    <script>
        let userId = null;
        let profileData = null;

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('expanded');
        }

        function showLogoutPopup() {
            document.getElementById('logoutPopup').style.display = 'block';
            document.getElementById('logoutOverlay').style.display = 'block';
        }

        function closeLogoutPopup() {
            document.getElementById('logoutPopup').style.display = 'none';
            document.getElementById('logoutOverlay').style.display = 'none';
        }

        function confirmLogout() {
            $.ajax({
                url: 'api/logout.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    user_id: userId
                }),
                success: function() {
                    console.log('Logout successful');
                },
                complete: function() {
                    sessionStorage.clear();
                    window.location.href = 'OCVET-Homepage.html';
                }
            });
        }

        function navigateTo(section) {
            if (section === 'profile') {
                window.location.href = 'OCVET-Profile.html';
            } else if (section === 'dashboard') {
                window.location.href = 'OCVET-UserDashboard.html';
            } else if (section === 'appointments') {
                window.location.href = 'OCVET-Appointment.html';
            } else if (section === 'pet-records') {
                window.location.href = 'OCVET-PetRecords.html';
            } else if (section === 'messages') {
                window.location.href = 'OCVET-Messages.html';
            }
        }

        function loadProfileData() {
            if (!userId) return;
            $.ajax({
                url: 'api/profile.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'get_profile',
                    user_id: userId
                }),
                success: function(response) {
                    if (response.success && response.data) {
                        profileData = response.data;
                    }
                },
                error: function() {
                    console.error('Failed to load profile data');
                }
            });
        }

        function showAppointmentModal(mode, appointment = null) {
            $('#appointmentModal').show();
            $('#modalOverlay').show();
            $('#errorMessage').hide();
            $('#appointmentForm')[0].reset();
            $('#terms_accepted').prop('checked', false);

            if (mode === 'edit' && appointment) {
                $('#appointmentModalTitle').text('Edit Appointment');
                $('#appointment_id').val(appointment.id);
                $('#fname').val(appointment.fname);
                $('#mname').val(appointment.mname);
                $('#lname').val(appointment.lname);
                $('#address').val(appointment.address);
                $('#date_of_birth').val(appointment.date_of_birth);
                $('#sex').val(appointment.sex);
                $('#civil_status').val(appointment.civil_status);
                $('#nationality').val(appointment.nationality);
                $('#place_of_birth').val(appointment.place_of_birth);
                $('#contact_number').val(appointment.contact_number);
                $('#email_address').val(appointment.email_address);
                $('#pet_id').val(appointment.pet_id);
                $('#appointment_date').val(appointment.appointment_date);
                $('#appointment_time').val(appointment.appointment_time);
                $('#purpose').val(appointment.purpose);
                $('#terms_accepted').prop('checked', true);
            } else {
                $('#appointmentModalTitle').text('Create Appointment');
                $('#appointment_id').val('');
                if (profileData) {
                    $('#fname').val(profileData.fname || '');
                    $('#mname').val(profileData.mname || '');
                    $('#lname').val(profileData.lname || '');
                    $('#address').val(profileData.address || '');
                    $('#date_of_birth').val(profileData.date_of_birth || '');
                    $('#sex').val(profileData.sex || '');
                    $('#civil_status').val(profileData.civil_status || '');
                    $('#nationality').val(profileData.nationality || '');
                    $('#place_of_birth').val(profileData.place_of_birth || '');
                    $('#contact_number').val(profileData.contact_number || '');
                    $('#email_address').val(profileData.email_address || '');
                }
            }
        }

        function closeAppointmentModal() {
            $('#appointmentModal').hide();
            $('#modalOverlay').hide();
            $('#errorMessage').hide();
        }

        function showDeletePopup(appointmentId) {
            $('#deletePopup').show();
            $('#modalOverlay').show();
            $('#confirmDeleteBtn').off('click').on('click', function() {
                deleteAppointment(appointmentId);
            });
        }

        function closeDeletePopup() {
            $('#deletePopup').hide();
            $('#modalOverlay').hide();
        }

        function loadFormData() {
            if (!userId) return;
            $.ajax({
                url: 'api/pet_records.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'get_pet_records',
                    user_id: userId
                }),
                success: function(response) {
                    if (response.success) {
                        $('#pet_id').empty().append('<option value="">Select Pet</option>');
                        (response.data || []).forEach(function(pet) {
                            $('#pet_id').append(`<option value="${pet.id}">${pet.pet_name}</option>`);
                        });
                    }
                },
                error: function() {
                    $('#errorMessage').text('Failed to load pet records').show();
                }
            });
        }

        function loadAppointments() {
            if (!userId) return;
            $.ajax({
                url: 'api/appointments.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'get_appointments',
                    user_id: userId
                }),
                success: function(response) {
                    const tbody = $('#appointmentsTable tbody').empty();
                    if (response.success && response.data && response.data.length > 0) {
                        response.data.forEach(function(appointment) {
                            tbody.append(`
                                <tr>
                                    <td>${appointment.appointment_date}</td>
                                    <td>${appointment.appointment_time}</td>
                                    <td>${appointment.purpose}</td>
                                    <td>${appointment.pet_name}</td>
                                    <td>${appointment.status}</td>
                                    <td>
                                        <button class="edit-btn" onclick='showAppointmentModal("edit", ${JSON.stringify(appointment)})'>Edit</button>
                                        <button class="delete-btn" onclick="showDeletePopup(${appointment.id})">Delete</button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="6">No appointments found</td></tr>');
                    }
                },
                error: function() {
                    $('#errorMessage').text('Failed to load appointments').show();
                }
            });
        }

        function deleteAppointment(appointmentId) {
            if (!userId) {
                $('#errorMessage').text('Session expired. Please log in again.').show();
                setTimeout(() => {
                    window.location.href = 'OCVET-Homepage.html';
                }, 2000);
                return;
            }
            $.ajax({
                url: 'api/appointments.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'delete_appointment',
                    user_id: userId,
                    appointment_id: appointmentId
                }),
                success: function(response) {
                    if (response.success) {
                        alert('Appointment deleted!');
                        closeDeletePopup();
                        loadAppointments();
                    } else {
                        $('#errorMessage').text(response.message || 'Error deleting appointment').show();
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to delete appointment';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || errorMessage;
                    } catch (e) {
                        errorMessage = xhr.responseText || errorMessage;
                    }
                    $('#errorMessage').text(errorMessage).show();
                }
            });
        }

        $(document).ready(function() {
            userId = sessionStorage.getItem('user_id');
            const cachedUsername = sessionStorage.getItem('username');
            const headerTitle = $('#header-title');

            if (!userId) {
                headerTitle.text('Guest Dashboard');
                $('#errorMessage').text('Please log in to access this page').show();
                setTimeout(() => {
                    window.location.href = 'OCVET-Homepage.html';
                }, 2000);
                return;
            }

            if (cachedUsername) {
                headerTitle.text(`${cachedUsername}'s Dashboard`);
            } else {
                $.ajax({
                    url: 'api/get_username.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        action: 'get_user',
                        user_id: userId
                    }),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.username) {
                            headerTitle.text(`${response.username}'s Dashboard`);
                            sessionStorage.setItem('username', response.username);
                        } else {
                            headerTitle.text('User Dashboard');
                        }
                    },
                    error: function() {
                        headerTitle.text('User Dashboard');
                    }
                });
            }

            loadProfileData();
            loadFormData();
            loadAppointments();

            $('#createAppointmentBtn').click(function() {
                showAppointmentModal('create');
                loadFormData();
            });

            $('#closeAppointmentModalBtn').click(closeAppointmentModal);

            $('#appointmentForm').submit(function(e) {
                e.preventDefault();
                $('#errorMessage').hide();

                if (!userId) {
                    $('#errorMessage').text('Session expired. Please log in again.').show();
                    setTimeout(() => {
                        window.location.href = 'OCVET-Homepage.html';
                    }, 2000);
                    return;
                }

                const email = $('#email_address').val().trim();
                if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    $('#errorMessage').text('Invalid email address format').show();
                    return;
                }

                const appointmentDate = $('#appointment_date').val();
                const appointmentTime = $('#appointment_time').val();
                const purpose = $('#purpose').val().trim();
                const today = new Date().toISOString().split('T')[0];
                const now = new Date();
                const selectedDateTime = new Date(`${appointmentDate}T${appointmentTime}`);

                if (!appointmentDate || !appointmentTime || !purpose) {
                    $('#errorMessage').text('Appointment date, time, and purpose are required').show();
                    return;
                }

                if (appointmentDate < today) {
                    $('#errorMessage').text('Appointment date cannot be in the past').show();
                    return;
                }

                if (appointmentDate === today && selectedDateTime < now) {
                    $('#errorMessage').text('Appointment time cannot be in the past').show();
                    return;
                }

                if (purpose.length > 255) {
                    $('#errorMessage').text('Purpose cannot exceed 255 characters').show();
                    return;
                }

                if (!$('#terms_accepted').is(':checked')) {
                    $('#errorMessage').text('Please accept the Terms and Conditions').show();
                    return;
                }

                const appointmentData = {
                    action: $('#appointment_id').val() ? 'edit_appointment' : 'save_appointment',
                    user_id: userId,
                    appointment_id: $('#appointment_id').val(),
                    fname: $('#fname').val().trim(),
                    mname: $('#mname').val().trim(),
                    lname: $('#lname').val().trim(),
                    address: $('#address').val().trim(),
                    date_of_birth: $('#date_of_birth').val(),
                    sex: $('#sex').val(),
                    civil_status: $('#civil_status').val(),
                    nationality: $('#nationality').val().trim(),
                    place_of_birth: $('#place_of_birth').val().trim(),
                    contact_number: $('#contact_number').val().trim(),
                    email_address: email,
                    pet_id: $('#pet_id').val(),
                    appointment_date: appointmentDate,
                    appointment_time: appointmentTime,
                    purpose: purpose,
                    terms_accepted: $('#terms_accepted').is(':checked')
                };

                $.ajax({
                    url: 'api/appointments.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(appointmentData),
                    success: function(response) {
                        if (response.success) {
                            alert(appointmentData.action === 'edit_appointment' ? 'Appointment updated!' : 'Appointment created!');
                            closeAppointmentModal();
                            loadAppointments();
                        } else {
                            $('#errorMessage').text(response.message || 'Error saving appointment').show();
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to save appointment';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMessage = response.message || errorMessage;
                            if (errorMessage.includes('Session expired') || errorMessage.includes('Unauthorized')) {
                                $('#errorMessage').text(errorMessage + '. Redirecting to login...').show();
                                setTimeout(() => {
                                    sessionStorage.clear();
                                    window.location.href = 'OCVET-Homepage.html';
                                }, 2000);
                                return;
                            }
                        } catch (e) {
                            errorMessage = xhr.responseText || errorMessage;
                        }
                        $('#errorMessage').text(errorMessage).show();
                    }
                });
            });

            $('#addPetRecordBtn').click(function() {
                $('#petRecordModal').show();
                $('#modalOverlay').show();
                $('#petRecordForm')[0].reset();
                $('#petErrorMessage').hide();
            });

            $('#closePetModalBtn').click(function() {
                $('#petRecordModal').hide();
                $('#modalOverlay').hide();
                $('#petErrorMessage').hide();
            });

            $('#petRecordForm').submit(function(e) {
                e.preventDefault();
                if (!userId) {
                    $('#petErrorMessage').text('Session expired. Please log in again.').show();
                    setTimeout(() => {
                        window.location.href = 'OCVET-Homepage.html';
                    }, 2000);
                    return;
                }
                const petData = {
                    action: 'save_pet_record',
                    user_id: userId,
                    pet_name: $('#pet_name').val().trim(),
                    species: $('#species').val().trim(),
                    breed: $('#breed').val().trim(),
                    sex: $('#pet_sex').val(),
                    age: parseInt($('#age').val()) || 0,
                    color_markings: $('#color_markings').val().trim()
                };

                if (!petData.pet_name || !petData.species || !petData.sex || petData.age <= 0) {
                    $('#petErrorMessage').text('Pet name, species, sex, and age are required').show();
                    return;
                }

                $.ajax({
                    url: 'api/pet_records.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(petData),
                    success: function(response) {
                        if (response.success) {
                            loadFormData();
                            $('#petRecordModal').hide();
                            $('#modalOverlay').hide();
                            alert('Pet record added!');
                        } else {
                            $('#petErrorMessage').text(response.error || 'Error adding pet record').show();
                        }
                    },
                    error: function() {
                        $('#petErrorMessage').text('Failed to save pet record').show();
                    }
                });
            });
        });
    </script>
</body>
</html>