<!DOCTYPE html>
<html>
<body>

<h1>Welcom to this page!</h1>

<?php

// azure database login
$azure_mysql_connstr = $_SERVER["MYSQLCONNSTR_localdb"];
$azure_mysql_connstr_match = preg_match(
    "/".
    "Database=(?<database>.+);".
    "Data Source=(?<datasource>.+);".
    "User Id=(?<userid>.+);".
    "Password=(?<password>.+)".
    "/u",
    $azure_mysql_connstr,
    $_);
    
$dsn = "mysql:host={$_["datasource"]};dbname=test_database;charset=utf8";
$user = $_["userid"];
$password = $_["password"];

$dbh = new PDO($dsn, $user, $password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "INSERT INTO access(timestamp) VALUES(?)";
$stmt = $dbh -> prepare($sql);
$data[] = date('Y-m-d H:i:s');
$stmt -> execute($data);

$sql = "SELECT MAX(code) AS LargestPrice FROM access";
$stmt = $dbh -> prepare($sql);
$stmt -> execute();

$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
echo "このページのアクセス回数は";
echo $rec["LargestPrice"];
echo "です。";
?>

</body>
</html>