const express = require('express');
const mysql = require('mysql2');
const app = express();

app.use(express.json());

// Database connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'your_username',
    password: 'your_password',
    database: 'ocvet_db'
});

db.connect(err => {
    if (err) throw err;
    console.log('Connected to ocvet_db');
});

// API endpoint to fetch user profile
app.get('/api/user-profile', (req, res) => {
    const userId = req.query.user_id;

    if (!userId) {
        return res.json({ success: false, message: 'User ID is required' });
    }

    const query = 'SELECT name, email, contact, address FROM profile WHERE user_id = ?';
    db.query(query, [userId], (err, results) => {
        if (err) {
            console.error(err);
            return res.json({ success: false, message: 'Database error' });
        }

        if (results.length === 0) {
            return res.json({ success: true, data: {} }); // Empty profile
        }

        res.json({ success: true, data: results[0] });
    });
});

app.listen(3000, () => {
    console.log('Server running on port 3000');
});