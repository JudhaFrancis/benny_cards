<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #111827;
            color: #ffffff;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        .content {
            padding: 40px;
        }

        .item {
            margin-bottom: 25px;
        }

        .label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #9ca3af;
            margin-bottom: 5px;
        }

        .value {
            font-size: 16px;
            color: #111827;
            font-weight: 500;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #ffffff;">Contact <span style="color: #00CFE8; font-style: italic;">Submission</span></h1>
        </div>
        <div class="content">
            <div class="item">
                <div class="label">From</div>
                <div class="value">{{ $data['name'] }}</div>
            </div>
            <div class="item">
                <div class="label">Email Address</div>
                <div class="value">{{ $data['email'] }}</div>
            </div>
            @if(!empty($data['phone']))
                <div class="item">
                    <div class="label">Phone Number</div>
                    <div class="value">{{ $data['phone'] }}</div>
                </div>
            @endif
            <div class="item">
                <div class="label">Message</div>
                <div class="value" style="white-space: pre-wrap;">{{ $data['message'] }}</div>
            </div>
        </div>
        <div class="footer">
            Sent from Benny's Cards Support Center
        </div>
    </div>
</body>

</html>