<?php
$sqlite = new SQLite3('bills.sqlite');
$res = $sqlite->query("SELECT * FROM payments;");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Ver pagamentos listados no cache</title>
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <td>Telefone</td>
          <td>Operadora</td>
          <td>Endereço BTC</td>
          <td>Valor em BTC</td>
          <td>Valor em BRL</td>
        </tr>
      </thead>
      <tbody>
      <?php while($row = $res->fetchArray(SQLITE3_ASSOC)): ?>
        <tr>
          <td><?php echo $row['ddd'] . substr($row['phone'], 0, 3); ?>...</td>
          <td><?php echo $row['carrier']; ?></td>
          <td><?php echo $row['address']; ?></td>
          <td><?php echo $row['xbtvalue']; ?></td>
          <td><?php echo $row['brlvalue']; ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </body>
</html>
