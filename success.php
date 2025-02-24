
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Booking Confirmation</title>
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
            background-color: white;
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
            color: #010c3e;
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
    </style>
</head>
<body>

    <!-- Booking Confirmation Popup -->
    <div class="popup-container" id="popup">
        <div class="popup-box">
            <span class="popup-close" id="popupClose">&#10005;</span>
            <h2>Booking Confirmation</h2>
            <p>Thank you for booking your car wash appointment!</p>
            <p>We’ve successfully received your booking. Your appointment is scheduled for the upcoming days, and we’re excited to serve you soon.</p>
            <p>Check your email for service details and reminders.</p>
            <button class="popup-button" id="popupButton">Got It!</button>
        </div>
    </div>

    <script>
        // Show the popup after form is successfully submitted
        window.onload = function() {
            setTimeout(function() {
                // Show the popup notification
                document.getElementById("popup").style.visibility = "visible";
                document.getElementById("popup").style.opacity = "1";
            }, 1000); // Delay to simulate booking confirmation
        };

        // Close the popup when the cross button is clicked
        document.getElementById("popupClose").onclick = function() {
            document.getElementById("popup").style.visibility = "hidden";
            document.getElementById("popup").style.opacity = "0";
        };

        // Close the popup when the "Got It!" button is clicked
        document.getElementById("popupButton").onclick = function() {
            document.getElementById("popup").style.visibility = "hidden";
            document.getElementById("popup").style.opacity = "0";
        };
    </script>

</body>
</html>
