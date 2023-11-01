<?php
$host = "zajecia4mateuszkoczorowski-server.postgres.database.azure.com";
$port = 5432;
$dbname = "postgres";
$user = "lascudaule";
$password = "serwer2023!";

// Połączenie z bazą danych PostgreSQL
$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connection) {
    die("Błąd połączenia z bazą danych PostgreSQL: " . pg_last_error());
}

// Wyświetlenie listy studentów
$sql = "SELECT * FROM Students";
$query = pg_query($connection, $sql);

if ($query === false) {
    die("Błąd zapytania: " . pg_last_error($connection));
}

echo "<h2>Lista Studentów:</h2>";
echo "<ul>";
while ($row = pg_fetch_assoc($query)) {
    echo "<li>{$row['first_name']} {$row['last_name']} (Semestr: {$row['semester']}, Stypendium: {$row['scholarship']})</li>";
}
echo "</ul>";

// Zamknięcie połączenia z bazą danych PostgreSQL
pg_close($connection);
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

    // Połączenie z bazą danych PostgreSQL
    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$connection) {
        die("Błąd połączenia z bazą danych PostgreSQL: " . pg_last_error());
    }

    // Dodanie nowego studenta
    $sql = "INSERT INTO Students (first_name, last_name, scholarship, semester) VALUES ('$first_name', '$last_name', '$scholarship', $semester)";
    $result = pg_query($connection, $sql);

    if ($result) {
        echo "<p>Nowy student został dodany.</p>";
    } else {
        die("Błąd podczas dodawania studenta: " . pg_last_error($connection));
    }

    // Zamknięcie połączenia z bazą danych PostgreSQL
    pg_close($connection);
}
?>
