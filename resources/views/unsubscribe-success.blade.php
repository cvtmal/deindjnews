<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erfolgreich abgemeldet - DeinDJ.ch</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif;
            background-color: rgb(43, 43, 43);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 60px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 180px;
            height: auto;
            margin-bottom: 30px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #7afcbd;
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        h1 {
            color: #2b2b2b;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .back-button {
            display: inline-block;
            background-color: #505ae6;
            color: #ffffff;
            padding: 12px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 16px;
            font-weight: normal;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #3d47d9;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://sawa-dev-2-storage-bucket.storage.googleapis.com/profiles/8drdb2mjxf9noul4-b7836.png"
             alt="DeinDJ Logo"
             class="logo">

        <div class="success-icon">
            ✓
        </div>

        <h1>Erfolgreich abgemeldet</h1>

        <p>
            Sie haben sich erfolgreich von unserem Newsletter abgemeldet.<br>
            Sie werden keine weiteren E-Mails von uns erhalten.
        </p>

        <p>
            Falls Sie Ihre Meinung ändern, können Sie sich jederzeit<br>
            wieder auf unserer Website anmelden.
        </p>

        <a href="https://deindj.ch" class="back-button">
            Zur Website
        </a>

        <div class="footer">
            © {{ date('Y') }} DeinDJ.ch. Alle Rechte vorbehalten.
        </div>
    </div>
</body>
</html>