<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #435468;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .container {
            text-align: center;
        }
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color:  white;
            margin: 0;
        }
        .error-message {
            font-size: 1.5rem;
            margin: 0.5rem 0;
            color:white;
        }
        .back-link {
            margin-top: 1.5rem;
            display: inline-block;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
        .illustration {
            font-size: 4rem;
            color: #ff6b6b;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        <p class="error-message">Oops! The page you are looking for could not be found.</p>
        <a href="{{ url('/') }}" class="back-link">Back to Home</a>
    </div>
</body>
</html>
