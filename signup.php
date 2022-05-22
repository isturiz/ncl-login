<?php

  require 'database.php';

  $message = '';
  
  // Se comprueba que los campos de email y contraseña no estén vacíos
  if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    // Comprobación de igualdad entre las contraseñas
    if ($_POST['password'] == $_POST['confirm_password'])
    {
      $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':email', $_POST['email']);
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $stmt->bindParam(':password', $password);

      if ($stmt->execute()) {
        $message = 'Usuario creado exitosamente';
      } else {
        $message = 'Lo sentimos, ha ocurrido algún error';
      } 
    }
    else
    {
      $message = 'Las contraseñas no coinciden';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SignUp</title>
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php require 'complementos/header.php' ?>
  
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>SignUp</h1>
    <span>or <a href="login.php">Login</a></span> 

    <!-- Formulario de registro de un nuevo usuario -->
    <form action="signup.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email" required>
      <input name="password" type="password" placeholder="Enter your Password" required>
      <input name="confirm_password" type="password" placeholder="Confirm Password" required>
      <input type="submit" value="Submit">
    </form>

  </body>
</html>
