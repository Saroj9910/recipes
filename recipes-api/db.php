 <?php
// function connect_db() {
//     $host = 'localhost';
//     $db = 'recipes_db';
//     $user = 'root'; // Change this as per your database user
//     $pass = '';     // Change this as per your database password
//    // $port = 3306; // Default MySQL port

//     // Create connection
//     // $dsn = new mysqli($servername, $username, $password, $dbname, $port);
    
//      $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
//     try {
//         $pdo = new PDO($dsn, $user, $pass);
//         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         return $pdo;
//     } catch (PDOException $e) {
//         echo 'Connection failed: ' . $e->getMessage();
//         exit;
//     }
// }

// function connect_db() {
//     $host = 'db';  // Docker environment mein MySQL container ka hostname
//     $db = 'recipes_db';
//     $user = 'user';  // docker-compose.yml mein define kiya gaya username
//     $pass = 'password';  // docker-compose.yml mein define kiya gaya password
//     // $port = 3306; // Default MySQL port

//     // Create connection
//     $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
//     try {
//         $pdo = new PDO($dsn, $user, $pass);
//         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         return $pdo;
//     } catch (PDOException $e) {
//         echo 'Connection failed: ' . $e->getMessage();
//         exit;
//     }
// }
// <?php
function connect_db() {
    $host = 'db'; // This should match the service name in docker-compose.yml
    $db = 'recipes_db';
    $user = 'user'; // This should match the MYSQL_USER in docker-compose.yml
    $pass = 'password'; // This should match the MYSQL_PASSWORD in docker-compose.yml
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
}
?>


