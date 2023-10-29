<!DOCTYPE html>
<html>
<head>
    <title>Lista Studentów</title>
</head>
<body>
    <h1>Lista Studentów</h1>
    
    <?php
    // Kod łączenia z bazą danych
    $serverName = "tcp:mkoczorowskidbwdco.database.windows.net,1433";
    $database = "zajecia4";
    $username = "mkoczorowski";
    $password = "{your_password_here}";

    $connectionOptions = array(
        "UID" => $username,
        "PWD" => $password,
        "Database" => $database,
        "LoginTimeout" => 30,
        "Encrypt" => 1,
        "TrustServerCertificate" => 0
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Wyświetlenie listy studentów
    $sql = "SELECT * FROM Students";
    $query = sqlsrv_query($conn, $sql);
    
    if ($query === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "<h2>Lista Studentów:</h2>";
    echo "<ul>";
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        echo "<li>{$row['first_name']} {$row['last_name']} (Semestr: {$row['semester']}, Stypendium: {$row['scholarship']})</li>";
    }
    echo "</ul>";
    sqlsrv_free_stmt($query);
    
    // Zamknięcie połączenia z bazą danych
    sqlsrv_close($conn);
    ?>

    <h2>Dodaj Studenta:</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Imię: <input type="text" name="first_name" required><br>
        Nazwisko: <input type="text" name="last_name" required><br>
        Stypendium:
        <select name="scholarship">
            <option value="Tak">Tak</option>
            <option value="Nie">Nie</option>
        </select><br>
        Semestr: <input type="number" name="semester" required><br>
        <input type="submit" value="Dodaj studenta">
    </form>

    <?php
    // Obsługa formularza dodawania studenta
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $scholarship = $_POST['scholarship'];
        $semester = $_POST['semester'];
        
        // Połączenie z bazą danych
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        // Dodanie nowego studenta
        $sql = "INSERT INTO Students (first_name, last_name, scholarship, semester) VALUES (?, ?, ?, ?)";
        $params = array($first_name, $last_name, $scholarship, $semester);
        $query = sqlsrv_query($conn, $sql, $params);
        
        if ($query === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        echo "<p>Nowy student został dodany.</p>";
        
        // Zamknięcie połączenia z bazą danych
        sqlsrv_close($conn);
    }
    ?>
</body>
</html>
