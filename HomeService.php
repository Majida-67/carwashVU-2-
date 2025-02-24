<?php
session_start();

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: NEW3.php");

    exit();
}
// footer
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "feedback_system"; // your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle feedback submission
function submitFeedback($rating, $comment)
{
    global $conn;

    // Validate rating (should be between 1 and 5)
    if ($rating >= 1 && $rating <= 5) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO feedbacks (rating, comment) VALUES (?, ?)");
        $stmt->bind_param("is", $rating, $comment);  // 'i' for integer, 's' for string

        // Execute the statement
        if ($stmt->execute()) {
            return "Thank you for your feedback!";
        } else {
            return "Error: " . $stmt->error;
        }
    } else {
        return "Invalid rating! Please provide a rating between 1 and 5.";
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $message = submitFeedback($rating, $comment);
}

// Close the connection
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Navbar with Admin Menu</title>
    <!-- FontAwesome for icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <script src="jquery.js"></script>
    <script src="scrollup-master/dist/jquery.scrollUp.js"></script>
    <style>
        /* Centered Notification Popup */
        .popup-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.5);
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .popup-box {
            background-color: #ebfcff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .popup-box h2 {
            color: #010c3e;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .popup-box p {
            color: #333;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .popup-close {
            font-size: 1.5em;
            color: #010c3e;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            transition: color 0.3s;
        }

        .popup-close:hover {
            color: #87d3d7;
        }

        .popup-button {
            background-color: #010c3e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .popup-button:hover {
            background-color: #87d3d7;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #010c3e;
        }

        .faq-container {
            padding: 30px;
            max-width: 800px;
            margin: 50px auto;

        }

        .faq-container h2 {
            text-align: center;
            font-size: 28px;
            color: #010c3e;
            margin-bottom: 20px;
        }

        .faq-item {
            margin-bottom: 20px;
        }

        .faq-question {
            width: 100%;
            text-align: left;
            padding: 18px;
            background-color: #fff;
            color: #010c3e;
            font-size: 18px;
            border: 2px solid #010c3e;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            position: relative;
        }

        .faq-question:hover {
            background-color: #87d3d752;
            /* Light teal hover effect */
        }

        .faq-answer {
            padding: 15px;
            background-color: #afd1d53d;
            font-size: 16px;
            color: #333;
            display: none;
            border-radius: 5px;
            margin-top: 10px;
            border-left: 4px solid #87d3d7;
            /* Light teal left border */
        }

        .faq-question::after {
            content: "×";
            /* Cross symbol for the button */
            font-size: 42px;
            color: #010c3e;
            position: absolute;
            right: 20px;
            transition: transform 0.3s ease, scale 0.3s ease;
        }

        .faq-item.open .faq-answer {
            display: block;
        }

        .faq-item.open .faq-question::after {
            transform: rotate(45deg) scale(1.3);
            /* Rotate and scale the "×" symbol */
        }

        .faq-item.open .faq-question {
            transform: scale(1.05);
            /* Slightly enlarge the button when answer is open */
        }

        /* footer */


        footer {

            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 30px;
            background-color: #fff;
            color: #000;
            gap: 20px;
        }

        .column {
            flex: 1;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            min-width: 250px;
        }

        .form-container {
            flex: 1.5;
            background-color: #010c3e;
            color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .column h3,
        .form-container h1 {
            color: #010c3e;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .column p,
        .column a,
        .column ul {
            font-size: 16px;
            margin-bottom: 10px;
            color: #010c3e;
            text-decoration: none;
        }

        .column ul {
            text-decoration: underline;
            list-style: none;
            padding: 0;
        }

        .column ul li {
            margin-bottom: 5px;
        }

        .column ul li a:hover {
            color: #87d3d7;
        }



        .form-container h1 {
            text-align: center;
            color: #87d3d7;
            font-size: 24px;
        }

        .stars {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-bottom: 20px;
        }

        .star {
            font-size: 30px;
            cursor: pointer;
            color: #ccc;
        }

        .star.selected {
            color: #ffcc00;
        }

        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #87d3d7;
            color: #010c3e;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-size: 13px;
        }

        button:hover {
            background-color: #6ba8a8;
        }

        @media (max-width: 768px) {
            footer {
                flex-direction: column;
            }
        }


        .footer-section {
            height: 65px;
            font-size: 15px;
            align-items: center;
            text-align: center;
            color: #fff;
            background-color: #010c3e;
            display: flex;
            justify-content: space-between;
            padding: 5px 5px;
        }

        /* Basic icon style */
        a {
            margin: 8px 8px;
            font-size: 18px;
            padding: 5px 5px;
            text-decoration: none;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;

        }

        @media (max-width: 480px) {
            a {
                margin: 8px 8px;
                font-size: 10px;
                padding: 5px 5px;
                text-decoration: none;
                border-radius: 50%;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .footer-section {
                height: 65px;
                font-size: 10px;
                align-items: center;
                text-align: center;
                color: #fff;
                background-color: #010c3e;
                display: flex;
                justify-content: space-between;
                padding: 5px 5px;
            }

            .faq-question {
                width: 100%;
                text-align: left;
                padding: 18px;
                background-color: #fff;
                color: #010c3e;
                font-size: 10px;
                border: 2px solid #010c3e;
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-radius: 5px;
                transition: background-color 0.3s ease, transform 0.3s ease;
                position: relative;
            }

            .faq-question::after {
                content: "×";
                /* Cross symbol for the button */
                font-size: 30px;
                color: #010c3e;
                position: absolute;
                right: 20px;
                transition: transform 0.3s ease, scale 0.3s ease;
            }

            button {
                background-color: #87d3d7;
                color: #010c3e;
                padding: 12px 20px;
                border: none;
                border-radius: 5px;
                width: 60%;
                cursor: pointer;
                font-size: 16px;
            }


        }

        /* WhatsApp */
        .whatsapp {
            background-color: #ffff;
            color: #010c3e;
        }

        .whatsapp:hover {
            background-color: green;
        }

        /* Facebook */
        .facebook {
            background-color: #ffff;
            color: #010c3e;
        }

        .facebook:hover {
            background-color: #155D9B;

        }

        .email {
            background-color: #ffff;
            color: #010c3e;

        }

        .email:hover {
            background-color: red;
        }

        a:hover {
            color: #fff;
        }

        .social-icons a[href^="tel:"] {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        .social-icons a[href^="tel:"]:hover {
            color: #87d3d7;
        }


        .container1 {
            background-color: #fff;
            /* border:2px solid blue; */
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .payment-method {
            margin: -3px;
        }

        .payment-method img {
            width: 70px;
            background-color: transparent;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease, opacity 0.3s ease;
            box-shadow: 0 4px 8px rgb(37 39 40 / 63%);

        }

        .payment-method img:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        footer {
            margin-top: 50px;
            color: #777;
            font-size: 14px;
        }

        /* Designer Name Highlight */
        .designer-name {
            color: #87d3d7;
            font-size: 19px;

        }

        #scrollUp {
            bottom: 40px;
            right: 20px;
            background: url(' images/scrollup.png') no-repeat center center;
            background-size: contain;
            width: 60px;
            height: 50px;

            border-radius: 250px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

        }
    </style>
</head>

<body>
    <header>
        <p></p>
    </header>


    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <a href="Carwash.php"> CARWASH </a>
        </div>

        <!-- Menu (Links) -->
        <ul class="menu">
            <li><a href="Client_services.php" class="nav-link">Services</a></li>
            <li><a href="client_view_packages.php" class="nav-link">Packages</a></li>
            <li><a href="Booking.php" class="nav-link">BookNow</a></li>
            <!-- <a href="register_as.php" class="nav-link">CreateAccount</a> -->
            <li class="dropdown">
                <a href="register_as.php" class="nav-link">CreateAccount</a>
            </li>
            <li><a href="booking_history.php" class="nav-link">BookingHistory</a></li>

            <li><a href="submit_feedback.php" class="nav-link">Feedback</a></li>
            <li><a href="create_booking.php" class="nav-link">CreateBooking</a></li>
            <!-- Logout Button -->
            <li><button class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button></li>
        </ul>

        <div class="hamburger" onclick="toggleSidebar()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#">Tutorial</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>


    <section class="home">
        <div class="home-content">
            <h1>Welcome to Car Wash</h1>
            <p>Premium car wash services at your doorstep</p>
            <a href="Booking.php" class="btn">Get Started</a>
        </div>
    </section>


    <!-- Popup Notification -->
    <div class="popup-container" id="popup">
        <span class="popup-close" id="popupClose">&#10005;</span>
        <div class="popup-box">
            <h2>Best Friday Sale</h2>
            <p>Enjoy <strong>20%</strong> discounts on all car wash services—this Friday only!</p>
            <p>Stay tuned for more promotions!</p>
            <button class="popup-button" id="popupButton">Close</button>
        </div>
    </div>

    <!-- services section  -->
    <h1> Services</h1>
    <div class="container" id="serviceContainer">
        <!-- Initial 4 Service Cards -->
        <div class="card">
            <img src="https://media.ed.edmunds-media.com/non-make/howto/howto_1129112_1600.jpg" alt="Exterior Wash and Wax">
            <div class="content">
                <h3>Exterior Wash and Wax</h3>
                <p>This service focuses on cleaning the car's exterior, removing dirt, dust, and grime. After washing, a layer of wax is applied to enhance shine and protect the paint from environmental elements.</p>
                <a href=" Exterior Wash and Wax.php">View Price</a>
            </div>
        </div>
        <div class="card">
            <img src="https://surfnshine.com/wp-content/uploads/2023/10/interior-detailing-1024x576.jpg" alt="Interior Cleaning">
            <div class="content">
                <h3>Interior Cleaning</h3>
                <p>Interior cleaning ensures the inside of the car is spotless. It includes vacuuming carpets and seats, wiping and polishing the dashboard, and deep-cleaning the upholstery for a fresh look and feel.</p>
                <a href="interiorcleaning.php">View Price</a>
            </div>
        </div>
        <div class="card">
            <img src="https://autoniche.ca/wp-content/uploads/2021/06/AutoNiche-Engine-Cleaning-2048x1367.jpg" alt="Engine Cleaning">
            <div class="content">
                <h3>Engine Cleaning</h3>
                <p>Engine cleaning involves removing oil stains, grease, and dirt from the engine compartment. It helps improve engine efficiency and gives it a clean, well-maintained appearance.</p>
                <a href="enginecleaning.php">View Price</a>
            </div>
        </div>
        <div class="card">
            <img src="https://i.ytimg.com/vi/3bh2Ds4GDME/maxresdefault.jpg" alt="Ceramic Coating">
            <div class="content">
                <h3>Ceramic Coating</h3>
                <p>Ceramic coating adds a protective layer to the car's paint, shielding it from scratches, UV rays, and fading. It enhances the car's gloss and provides long-term protection.</p>
                <a href="creamiccoating.php">View Price</a>
            </div>
        </div>
        <!-- Additional 2 Cards (Initially Hidden) -->
        <div class="card extra" style="display: none;">
            <img src="https://cdn.australia247.info/assets/uploads/024453248395782c70919d5b71120900_-queensland-gympie-regional-rainbow-beach-4wd-underbody-complete-car-washhtml.jpg" alt="Underbody Wash">
            <div class="content">
                <h3>Underbody Wash</h3>
                <p>This service cleans the underside of the car, removing dirt, salt, and road grime. It helps prevent rust and corrosion, especially in areas with harsh weather conditions.</p>
                <a href="underboady.php">Read More</a>
            </div>
        </div>
        <div class="card extra" style="display: none;">
            <img src="https://www.soft99.co.jp/en/howto/sensya-navi/images/lesson6/img_02.jpg" alt="Tire and Wheel Cleaning">
            <div class="content">
                <h3>Tire and Wheel Cleaning</h3>
                <p>Tire and wheel cleaning removes built-up brake dust and grime, restoring the shine of your wheels and ensuring they remain in excellent condition.</p>
                <a href="tyres.php">Read More</a>
            </div>
        </div>
    </div>
    <div class="load-more">
        <button id="readMoreBtn" onclick="loadMore()">Load More</button>
        <button id="readLessBtn" onclick="loadLess()" style="display: none;">Load Less</button>
    </div>


    <!-- Packages-->
    <h1>Packages</h1>

    <div class="package-container">
        <!-- The Works -->
        <div class="package works">
            <div class="package-header">
                <span>1</span>
                <h3>The WORKS</h3>
                <span>$65</span>
            </div>
            <div class="package-content">
                <ul>
                    <li>Tire Gloss</li>
                    <li>Ceramic Body Wax&reg;</li>
                    <li>Red Hot Cleanser</li>
                    <li>Rainbow Coat&reg;</li>
                    <li>Tommy Guard&reg;</li>
                </ul>
                <p class="package-description">
                    Our best wash! Ceramic Body Wax, rain and UV protectant.
                </p>
                <center><a href="receive_mail.php"><button>Book Now</button></a></center>

            </div>
        </div>

        <!-- Ultimate -->
        <div class="package ultimate">
            <div class="package-header">
                <span>2</span>
                <h3>ULTIMATE</h3>
                <span>$80</span>

            </div>
            <div class="package-content">
                <ul>
                    <li>Rainbow Coat&reg;</li>
                    <li>3-Step Wheel Cleaning</li>
                    <li>Tommy Guard&reg;</li>
                </ul>
                <p class="package-description">
                    The ULTIMATE Wash includes a deep penetrating foam wash, rain and UV protectant, wheel cleaning, and an underbody flush.
                </p>
                <center><a href="RECEIPTS.php"><button>Book Now</button></a></center>
            </div>
        </div>

        <!-- Super -->
        <div class="package super">
            <div class="package-header">
                <span>3</span>
                <h3>SUPER</h3>
                <span>$120</span>
            </div>
            <div class="package-content">
                <ul>
                    <li>Tommy Guard&reg;</li>
                    <li>Underbody Flush</li>
                </ul>
                <p class="package-description">
                    The SUPER Wash includes the standard wash, rain and UV protectant, and an underbody flush.
                </p>
                <center><a href="RECEIPTS.php"><button>Book Now</button></a></center>
            </div>

        </div>
    </div>

    <!-- FAQS  -->

    <div class="faq-container">
        <h2>Frequently Asked Questions</h2>

        <!-- FAQ Item 1 -->
        <div class="faq-item">
            <button class="faq-question">What services does the car wash offer?</button>
            <div class="faq-answer">
                <p>We provide exterior washing, interior cleaning, waxing, and full detailing services tailored to your needs.</p>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="faq-item">
            <button class="faq-question">How long does a car wash take?</button>
            <div class="faq-answer">
                <p>Typically, a basic car wash takes around 30 minutes. Detailing services might take longer based on the package selected.</p>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="faq-item">
            <button class="faq-question">What are the payment options available?</button>
            <div class="faq-answer">
                <p>We accept cash, credit/debit cards, and mobile payments including Apple Pay and Google Pay.</p>
            </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="faq-item">
            <button class="faq-question">Can I schedule a car wash appointment in advance?</button>
            <div class="faq-answer">
                <p>Yes, you can schedule an appointment online or by phone, ensuring you get your preferred time slot.</p>
            </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="faq-item">
            <button class="faq-question">Is there any warranty on the services provided?</button>
            <div class="faq-answer">
                <p>We offer a satisfaction guarantee. If you're not happy with the service, let us know, and we will make it right.</p>
            </div>
        </div>
    </div>
    <!-- FAQS  -->
    <!-- footer  -->

    <footer>
        <!-- Company Info -->
        <div class="column company-info">
            <h3> CARWASH </h3>
            <p>We have been providing high-quality car wash services for over 10 years. Let us take care of your car!</p>
            <p>Mon - Sat: 8:00 AM - 6:00 PM</p>
            <h3>Choose How You Want to Pay</h3>


            <div class="container1">
                <!-- Easypaisa -->
                <div class="payment-method">

                    <a href="https://easypaisa.com.pk" target="_blank">
                        <img src="https://tse2.mm.bing.net/th?id=OIP.v3GC5TWNk2k6F7t5lrh6cQAAAA&pid=Api&P=0&h=220 " alt="Pay with Easypaisa">
                    </a>
                </div>


                <!-- PayPal -->
                <div class="payment-method">
                    <a href="https://www.paypal.com/signin" target="_blank">
                        <img src=" https://www.pngall.com/wp-content/uploads/5/PayPal-Logo-PNG-Free-Download.png" alt="Pay with PayPal">
                    </a>
                </div>

                <!-- JazzCash  -->
                <div class="payment-method">
                    <a href="https://www.jazzcash.com.pk" target="_blank">
                        <img src=" https://www.techlist.pk/wp-content/uploads/2022/05/jazzcash_9cxy.jpg " alt="Pay with JazzCash">
                    </a>
                </div>
            </div>

        </div>

        <div class="column quick-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Booking</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Customer Support</a></li>
                <li><a href="#">Feedback</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>


        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


        <!-- Feedback Form -->
        <div class="form-container">
            <h1>Submit Your Feedback</h1>

            <!-- Feedback Message -->
            <?php if (isset($message)) {
                echo "<div class='message'>$message</div>";
            } ?>

            <!-- Feedback Form -->
            <form method="POST" action="">
                <label for="rating">Rating (1-5): </label>
                <div class="stars">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="" required>

                <label for="comment">Comment: </label><br>
                <textarea name="comment" id="comment" rows="3" required></textarea><br>

                <button type="submit">Submit Feedback</button>
            </form>
        </div>


    </footer>
    <!-- Center Section -->
    <div class="footer-section">

        <p>© 2025 CarWash. All Rights Reserved.</p>

        <div class="footer-section right">
            <nav class="social-icons">
                <!-- Social Icons -->
                <!-- Contact Info -->
                <i class="fas fa-phone-alt"></i> <a href="tel:+1234567890">+23091234919</a>
                <i class="fas fa-phone-alt"></i> <a href="tel:+1234567890">+1234567890</a>
                <a href="https://www.facebook.com/yourprofile" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://wa.me/1234567890" class="whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <a href="mailto:yourmail@example.com" class="email" target="_blank"><i class="fas fa-envelope"></i></a>


            </nav>
        </div>


        <!-- footer ends -->

        <script>
            document.querySelectorAll('.faq-question').forEach(function(faq) {
                faq.addEventListener('click', function() {
                    const parent = faq.closest('.faq-item');
                    parent.classList.toggle('open');
                });
            });

            // Show the popup after 7 seconds
            window.onload = function() {
                setTimeout(function() {
                    document.getElementById("popup").style.visibility = "visible";
                    document.getElementById("popup").style.opacity = "1";
                }, 7000);
            };

            // Close popup functionality
            document.getElementById("popupClose").onclick = function() {
                document.getElementById("popup").style.visibility = "hidden";
                document.getElementById("popup").style.opacity = "0";
            };

            document.getElementById("popupButton").onclick = function() {
                document.getElementById("popup").style.visibility = "hidden";
                document.getElementById("popup").style.opacity = "0";
            };

            // footer 
            // Handle star rating selection
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = star.getAttribute('data-value');
                    ratingInput.value = value;

                    stars.forEach(star => {
                        star.classList.remove('selected');
                    });

                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('selected');
                    }
                });
            });

            // footer

            $(function() {
                $.scrollUp({
                    scrollText: '', // Keeps the button icon-only

                });
            });

        </script>
        <script src="script.js"></script>

</body>

</html>