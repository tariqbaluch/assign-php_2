<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $servername = "localhost";
    $db_username = "admin";
    $db_password = "admin123";
    $dbname = "transport_management";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
      
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
       
            if(password_verify($password, $result['password'])) {
               
                $_SESSION['username'] = $username;
                echo "Login successful!";
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "Invalid username or password!";
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
