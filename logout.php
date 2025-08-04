<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logout - IdeTrust</title>
  <link rel="icon" href="assets/images/logo.png" type="image/png">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #141e30, #243b55);
      color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }

    .logout-container {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 40px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      max-width: 400px;
      width: 100%;
    }

    .logout-container h1 {
      font-size: 28px;
      margin-bottom: 15px;
      color: #ffffff;
    }

    .logout-container p {
      font-size: 16px;
      margin-bottom: 25px;
      color: #ccc;
    }

    .btn-login {
      background-color: #00b894;
      border: none;
      color: white;
      padding: 12px 24px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
      text-decoration: none;
    }

    .btn-login:hover {
      background-color: #019875;
    }
  </style>
</head>
<body>
  <div class="logout-container">
    <h1>Berhasil Logout</h1>
    <p>Anda telah keluar dari sistem. Terima kasih telah menggunakan layanan kami.</p>
    <a href="index.php" class="btn-login">Kembali ke Login</a>
  </div>
</body>
</html>
