<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card with Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 390px;
            height: 520px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #fff;
            text-align: center;
            padding: 20px;
        }

        .card h1 {
            font-size: 28px;
            color: #010c3e;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .card p {
            padding:10px 10px;
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .card-images {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-images img {
            width: 350px;
            height: 220px;
            border-radius: 8px;
            object-fit: cover;
        }

        .card-heading {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-transform: capitalize;
        }

        .card-price {
            margin-top: 20px;
            font-size: 40px;
            font-weight: bold;
            color:  #010c3e;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Car Wash</h1>
        <p>Interior cleaning ensures the inside of the car is spotless. It includes vacuuming carpets and seats, wiping and polishing the dashboard, and deep-cleaning the upholstery for a fresh look and feel.</p>
        <div class="card-images">
            <img src="images/interior-cleaning.php  " alt="Image 1">
        </div>
        <div class="card-heading">Interior Cleaning </div>
        <div class="card-price">$70</div>
    </div>
</body>
</html>
