<?php
echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Login</title>
        </head>
        <body>
            <div id='detector' style='color: green; text-align: center; margin-top: 50px; font-size: 20px;'>
                Please wait...
            </div>
    
            <script>
                document.getElementById('detector').innerText = 'Login successful!';
                setTimeout(function() {
                    window.location.href = '../dashboard.php';
                }, 2000);
            </script>
        </body>
        </html>";
