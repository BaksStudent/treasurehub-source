<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
    <style>
        body {
            margin: 0;
            background-color: #ffe6e6; /* light red */
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .message-container {
            text-align: center;
            background-color: #ffcccc;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .message-container h1 {
            color: #cc0000;
            margin-bottom: 20px;
        }

        .back-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #cc0000;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #a30000;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h1>Payment has failed</h1>
        <button class="back-button" onclick="maincall()">Go back to cart</button>
    </div>
</body>
<script>
    function getQueryParam(name) 
    {
        const params = new URLSearchParams(window.location.search);
        return params.get(name);
    }

    function maincall()
    {
        
        const action = getQueryParam('div');
        if (action === "foods") 
        {
            window.location.href = "treasure hub foods cart section.php";
        }
        else
        {
            window.location.href = "treasure hub cart section.php";
        }
           
    }
</script>
</html>