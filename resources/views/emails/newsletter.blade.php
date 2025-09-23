<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .content {
            padding: 20px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 0.9em;
            color: #6c757d;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Our deindj</h1>
    </div>

    <div class="content">
        <p>Hi {{ $name }},</p>

        <p>Welcome to our newsletter! We're excited to have you as part of our community.</p>

        <p>This is your personalized newsletter content. Stay tuned for more updates!</p>

        <p>Best regards,<br>
        The Newsletter Team</p>
    </div>

    <div class="footer">
        <p>This email was sent to {{ $email }}</p>
        <p>&copy; {{ date('Y') }} Our Newsletter. All rights reserved.</p>
    </div>
</body>
</html>