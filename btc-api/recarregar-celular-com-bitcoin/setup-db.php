<?php
/*******************************************************************************
Este arquivo deve ser acessado para criar o banco de dados sqlite
*******************************************************************************/
$sqlite = new SQLite3('bills.sqlite');
$sql = "CREATE TABLE payments(ddd INT, phone INT, carrier TEXT, address TEXT, xbtvalue REAL, brlvalue REAL);";
if (!$sqlite->query($sql)) {
  echo 'Error creating table';
} else {
  echo 'Success';
}
?>
