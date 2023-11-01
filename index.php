$host = "zajecia4mateuszkoczorowski-server.postgres.database.azure.com";
$port = 5432;
$dbname = "postgres";
$user = "lascudaule";
$password = "serwer2023!";

$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$connection) {
    die("Błąd połączenia z bazą danych: " . pg_last_error());
} else {
    echo "Połączono z bazą danych PostgreSQL.";
    // Możesz wykonywać operacje na bazie danych tutaj.
}
