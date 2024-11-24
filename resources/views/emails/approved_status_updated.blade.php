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
        <h1>Application Approved</h1>
        <h3>Dear {{ $inquiries->full_name }},</h3>
        <p>We are pleased to inform you that your application has been successfully approved. Our team has reviewed your submission, and we are excited to welcome you as a part of our community.</p>
        
        <p>Please note that your account is currently being set up. Once your account is fully activated, you will receive a confirmation email containing all necessary login information and instructions for accessing your profile.</p>
        
        <p>We appreciate your patience as we finalize these arrangements, and we look forward to supporting you in your journey with us.</p>
        
        <p>Should you have any questions in the meantime, please do not hesitate to reach out to our support team at <span class="highlight">digiapart13@gmail.com</span>.</p>
        
        <p>Sincerely,</p>
        <p>MABALACAT DORM: A WEB APPLICATION FOR ENHANCED TENANT MONITORING AND MANAGEMENT</p>
    </div>
</body>
</html>
