<?php
include('includes/config.php'); // Ensure this file exists with the correct DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['rating']) && !empty($_POST['comment'])) {
        $name = $_POST['name'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        // Check if the user is logged in
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

        // Insert feedback with optional user_id
        $sql = "INSERT INTO feedbacks (user_id, name, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isis', $user_id, $name, $rating, $comment);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Feedback submitted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Please fill all fields.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #010c3e; /* Dark Blue Background */
            text-align: center;
            padding: 20px;
        }
        
        h2 {
            color: #87d3d7; /* Light Teal Heading */
        }

        /* Feedback Form */
        form {
            background: white;
            padding: 25px;
            width: 350px;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        form:hover {
            transform: translateY(-5px);
        }

        input, textarea, button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #87d3d7;
            font-size: 16px;
            background: #f8f9fa;
            color: #010c3e;
        }

        textarea {
            resize: none;
        }

        /* Star Rating */
        .stars {
            display: flex;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
            margin-bottom: 15px;
        }

        .stars .star {
            transition: color 0.3s ease-in-out, transform 0.2s ease;
        }

        .stars .star:hover, 
        .stars .star.selected {
            color: #87d3d7;
            transform: scale(1.2);
        }

        /* Submit Button */
        button {
            background-color: #87d3d7;
            color: #010c3e;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background-color: #6bb8c0;
        }
    </style>
</head>
<body>

<h2>Submit Your Feedback</h2>

<!-- Feedback Form -->
<form method="POST">
    <label for="name">Your Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="rating">Rating (1-5):</label>
    <div class="stars" id="starContainer">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
    </div>
    <input type="hidden" name="rating" id="rating" required>

    <label for="comment">Comment:</label>
    <textarea name="comment" id="comment" rows="3" required></textarea>

    <button type="submit">Submit Feedback</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".star");
        const ratingInput = document.getElementById("rating");

        stars.forEach(star => {
            star.addEventListener("click", function () {
                let value = this.getAttribute("data-value");
                ratingInput.value = value;

                // Highlight selected stars
                stars.forEach(s => s.classList.remove("selected"));
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add("selected");
                }
            });
        });
    });
</script>

</body>
</html>
