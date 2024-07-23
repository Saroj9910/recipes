<?php

session_start();
include_once 'db.php'; // Adjust the path as needed

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Show the main application if the user is logged in
    showMainApplication();
} else {
    // Handle sign-up and login if not logged in
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    switch ($action) {
        case 'signup':
            handleSignUp();
            break;
        case 'login':
            handleLogin();
            break;
        default:
            showLoginPage();
            break;
    }
}

// Function to show the main application with links
function showMainApplication() {
    echo '<!DOCTYPE html>
          <html>
          <head>
              <title>Recipe Manager</title>
              <style>
                  body { font-family: Arial, sans-serif; background-color: #f8f8f8; margin: 0; padding: 0; }
                  .container { width: 100%; max-width: 800px; margin: 50px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; }
                  h1 { text-align: center; color: #333; }
                  ul { list-style-type: none; padding: 0; }
                  li { margin: 10px 0; }
                  a { color: #007bff; text-decoration: none; }
                  a:hover { text-decoration: underline; }
                  .navbar { background-color: #333; overflow: hidden; }
                  .navbar a { float: right; display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
                  .navbar a:hover { background-color: #ddd; color: white; }
                  .navbar a.left { float: left; }
              </style>
          </head>

          <body>
              <div class="navbar">
               <a href="?action=logout">Logout</a>
                  <a href="api/recipes/list.php">List Recipes</a>
                  <a href="add_recipe.html">Create Recipe</a>
                  <a href="update_recipe.html">Update Recipe</a>
                   <a href="read_recipe.html">Read Recipe</a>
                   <a href="delete_recipe.html">Delete Recipe</a>
                    <a href="search_recipe.html">Search Recipes</a>
                     <a href="rate_recipe.html">Rate Recipe</a>
                  <a href="#" class="left">Recipe Manager</a>
              </div>
              <div class="container">
                  <h1>Welcome to the Recipe API</h1>
                 <h1> <a href="api/recipes/list.php">List Recipes</a></h1>
                  <h1><p> <a href="add_recipe.html">Create Recipe</a> </p> </h1>
                  <h1>  <p><a href="update_recipe.html">Update Recipe</a> </p> </h1>
                  <h1>   <p> <a href="read_recipe.html">Read Recipe</a> </p> </h1>
                  <h1>   <p> <a href="delete_recipe.html">Delete Recipe</a> </p> </h1>
                    <h1> <p><a href="search_recipe.html">Search Recipes</a> </p></h1>
                  <h1>    <p>  <a href="rate_recipe.html">Rate Recipe</a> </p> </h1>
              </div>
          </body>
          </html>';
}

// Function to show the login page
function showLoginPage() {
    echo '<!DOCTYPE html>
          <html>
          <head>
              <title>Login</title>
              <style>
                  body { font-family: Arial, sans-serif; background-color: #f8f8f8; margin: 0; padding: 0; }
                  .container { width: 100%; max-width: 400px; margin: 50px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; }
                  h1 { text-align: center; color: #333; }
                  form { display: flex; flex-direction: column; }
                  label { margin-bottom: 5px; color: #333; }
                  input[type="text"], input[type="password"] { padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
                  input[type="submit"] { padding: 10px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
                  input[type="submit"]:hover { background-color: #218838; }
                  p { text-align: center; }
                  .navbar { background-color: #333; overflow: hidden; }
                  .navbar a { float: right; display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
                  .navbar a:hover { background-color: #ddd; color: black; }
                  .navbar a.left { float: left; }
              </style>
          </head>
          <body>
              <div class="navbar">
                  <a href="?action=signup">Sign Up</a>
                  <a href="?action=login">Login</a>
                  <a href="<a href="?action=logout">Logout</a>
                  <a href="rate_recipe.html">Rate Recipe</a>
                  <a href="search_recipe.html">Search Recipes</a>
                  <a href="delete_recipe.html">Delete Recipe</a>
                  <a href="update_recipe.html">Update Recipe</a>
                  <a href="read_recipe.html">Read Recipe</a>
                  <a href="add_recipe.html">Create Recipe</a>
                  <a href="api/recipes/list.php">List Recipes</a>
              </div>
              <div class="container">
                  <h1>Login</h1>
                  <form method="POST" action="?action=login">
                      <label>Username:</label>
                      <input type="text" name="username" required>
                      <label>Password:</label>
                      <input type="password" name="password" required>
                      <input type="submit" value="Login">
                  </form>
                  <p><a href="?action=signup">Sign Up</a></p>
              </div>
          </body>
          </html>';
}

// Function to handle user sign-up
function handleSignUp() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            echo 'Username and password are required.';
            return;
        }

        $pdo = connect_db();
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHash);

        if ($stmt->execute()) {
            echo 'Sign up successful. <a href="?action=login">Login</a>';
        } else {
            echo 'Failed to sign up.';
        }
    } else {
        echo '<!DOCTYPE html>
              <html>
              <head>
                  <title>Sign Up</title>
                  <style>
                      body { font-family: Arial, sans-serif; background-color: #f8f8f8; margin: 0; padding: 0; }
                      .container { width: 100%; max-width: 400px; margin: 50px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; }
                      h1 { text-align: center; color: #333; }
                      form { display: flex; flex-direction: column; }
                      label { margin-bottom: 5px; color: #333; }
                      input[type="text"], input[type="password"] { padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
                      input[type="submit"] { padding: 10px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
                      input[type="submit"]:hover { background-color: #218838; }
                      p { text-align: center; }
                      .navbar { background-color: #333; overflow: hidden; }
                      .navbar a { float: right; display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none; }
                      .navbar a:hover { background-color: #ddd; color: black; }
                      .navbar a.left { float: left; }
                  </style>
              </head>
              <body>
                  <div class="navbar">
                      <a href="?action=signup">Sign Up</a>
                      <a href="?action=login">Login</a>
                      <a href="#" class="left">Recipe Manager</a>
                  </div>
                  <div class="container">
                      <h1>Sign Up</h1>
                      <form method="POST" action="?action=signup">
                          <label>Username:</label>
                          <input type="text" name="username" required>
                          <label>Password:</label>
                          <input type="password" name="password" required>
                          <input type="submit" value="Sign Up">
                      </form>
                      <p><a href="?action=login">Login</a></p>
                  </div>
              </body>
              </html>';
    }
}

// Function to handle user login
function handleLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            echo 'Username and password are required.';
            return;
        }

        $pdo = connect_db();
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Store user_id in session
            header('Location: index.php');
            exit;
        } else {
            echo 'Invalid credentials.';
        }
    } else {
        showLoginPage();
    }
}

// Handle user logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
