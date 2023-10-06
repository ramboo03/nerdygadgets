<?php
// Gegevens ophalen van het HTML-formulier
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password'];
$number = $_POST['number'];

// Databaseverbinding maken
$conn = new mysqli('localhost', 'root', '', 'nerdygadgets');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Voorbereiden en uitvoeren van de SQL-query met prepared statements
$stmt = $conn->prepare("INSERT INTO users (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $password, $number);

if ($stmt->execute()) {
    // Succesvolle registratie
    session_start();
    $_SESSION['registratie_melding'] = "Succesvol geregistreerd";
    $stmt->close();
    $conn->close();
    header("Location: homepage.html");
    exit();
} else {
    // Fout bij het uitvoeren van de query
    echo "Fout bij de registratie: " . $stmt->error;
    $stmt->close();
    $conn->close();
}
?>