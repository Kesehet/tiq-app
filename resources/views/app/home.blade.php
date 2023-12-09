<!DOCTYPE html>
<html>
<head>
    <title>TIQ App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <style>
        .w3-feature{
            background-color:#005c27 !important;
            color: white;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .content {
            flex: 1;
            margin: 40px 0px;
            text-align: center;
            overflow: scroll-y;
        }

        .bottom-nav {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            color: white;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .bottom-nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            flex: 1; /* Makes each link flexibly occupy equal space */
            text-align: center; /* Centers the text in each link */
        }

        .top-nav {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            color: white;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            top: 0;
        }

        .top-nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            flex: 1; /* Makes each link flexibly occupy equal space */
            text-align: center; /* Centers the text in each link */
        }

        .header6 {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
        }
        .header5 {
            font-size: 24px;
            font-weight: bold;
            text-align: left;
        }

        .scroll-wrapper {
            overflow-x: auto;
            white-space: nowrap;
        }

        .quiz-card {
            display: inline-block;
            margin-right: 10px; /* Spacing between cards */
            width: 150px; /* Fixed width for each card */
            padding: 0px;
            overflow: hidden;
        }

        .quiz-image {
            width: 100%;
            height: auto;
        }

        .quiz-content {
            padding: 0px;
        }

        .analytics-block {
            margin-top: 20px; /* Adjust as needed */
            padding: 15px;
            background-color: #f1f1f1; /* Adjust background color as needed */
            border-radius: 10px;
            width: 100%;
        }

        
    </style>
</head>
<body>
    <div class="top-nav w3-feature">
        TIQ App
    </div>
    <div class="content w3-animate-opacity">
        <div class="w3-container w3-padding">
            <!-- Your main content goes here -->
            @include('app.component.latestQuiz')
            <hr/>
            <h3> Welcome {{Auth::user()->name}}, </h3>
            <p> Lets get you upto speed with your Quizzes.</p>

            <hr/>
            @include('app.component.analytics')
        </div>
    </div>
    <div class="bottom-nav  w3-feature">
        <a href="#"><i class="fa-solid fa-house"></i></a>
        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="#"><i class="fa-solid fa-user"></i></a>
        <a href="#"><i class="fa-solid fa-cog"></i></a>
    </div>
</body>
</html>
