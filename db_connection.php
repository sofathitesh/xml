<?php
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Mysql connection error");
$create_table = $connection->query("CREATE TABLE IF NOT EXISTS locat(id int(11) NOT NULL AUTO_INCREMENT, path varchar(200) NOT NULL, flag varchar(200) NOT NULL, PRIMARY KEY(`id`))");
?>
