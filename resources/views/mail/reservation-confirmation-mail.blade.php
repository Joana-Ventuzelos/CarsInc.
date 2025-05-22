@props([
    'client' => 'Client',
    'local' => 'Main Store',
])
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #333;
      line-height: 1.5;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      background: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
    }
    .header {
      background-color: #4f46e5;
      color: white;
      padding: 20px;
      text-align: center;
      border-radius: 8px 8px 0 0;
    }
    .content {
      padding: 20px;
      background-color: white;
    }
    .button {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 20px;
      background-color: #4f46e5;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
      font-family: sans-serif;
    }
    .footer {
      font-size: 12px;
      color: #777;
      margin-top: 30px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Reservation Confirmation</h1>
    </div>
    <div class="content">
      <p>Hello, <strong>{{ $client }}</strong>!</p>

      <p>We are pleased to confirm your reservation.</p>

      <p><strong>Pickup:</strong> {{ $local }}, from 1 PM.</p>

      <p>Please bring your identification documents to complete the rental.</p>

      <p>Thank you for choosing our services! If you have any questions, we are at your disposal.</p>

      <a href="{{ url('/dashboard') }}" class="button">Access reservation details</a>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} Cars Company. All rights reserved.
    </div>
  </div>
</body>
</html>
