<?php
/*******************************************************************************
Este arquivo deve ser acessado para criar o banco de dados sqlite
*******************************************************************************/
$sqlite = new SQLite3('bills.sqlite');
$sql = "CREATE TABLE payments(cod TEXT, expire TEXT, email TEXT, address TEXT, xbtvalue REAL, brlvalue REAL);";
if (!$sqlite->query($sql)) {
  echo 'Error creating table';
} else {
  echo 'Success';
}
?>
