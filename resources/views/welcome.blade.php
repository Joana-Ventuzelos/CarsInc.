<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to CarsInc.</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('https://www.deferias.pt/wp-content/uploads/2019/12/Car_Rental_Unsplash-scaled.jpg');
      background-size: cover;
      background-position: center;
      color: white;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.6);
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
    }

    h1 {
      font-size: 60px;
      margin-bottom: 20px;
    }

    p {
      font-size: 24px;
      margin-bottom: 40px;
    }

    .buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    a.button {
      background-color: rgb(205, 184, 50);
      color: white;
      padding: 15px 30px;
      text-decoration: none;
      font-size: 18px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    a.button:hover {
      background-color: #b00610;
    }
  </style>
</head>
<body>
  <div class="overlay">
    <h1>Welcome to CarsInc</h1>
    <p>Your destination for amazing cars. Find, explore, and drive in style.</p>

    <div class="buttons">
      <a class="button"  href="{{route('login')}}">Login</a>
      <a class="button" href="{{route('register')}}">Register</a>
    </div>
  </div>
</body>
</html>
