<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #4a5568;
        }
        p {
            line-height: 1.6;
            margin: 10px 0;
        }
        .highlight {
            color: #3182ce; /* A shade of blue for emphasis */
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tenant Reminder</h1>
        <h3>Hi {{ $user->name }},</h3>
        <p>We’re reaching out to remind you of the upcoming rent payment for your accommodation at Mabalacat Dorm.</p>
        <p>Your rent of <span class="highlight">₱1,500</span> is due in one week. Please ensure timely payment to avoid any late fees and to maintain a smooth tenancy experience.</p>
        <p>Thank you for your attention to this matter. We appreciate your cooperation!</p>
    </div>
</body>
</html>
