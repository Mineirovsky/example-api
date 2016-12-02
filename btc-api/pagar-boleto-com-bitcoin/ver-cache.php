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
          <td>Linha digitável</td>
          <td>Vencimento</td>
          <td>E-mail</td>
          <td>Endereço BTC</td>
          <td>Valor em BTC</td>
          <td>Valor em BRL</td>
        </tr>
      </thead>
      <tbody>
      <?php while($row = $res->fetchArray(SQLITE3_ASSOC)): ?>
        <tr>
          <td><?php echo $row['cod']; ?></td>
          <td><?php echo $row['expire']; ?></td>
          <td><?php echo substr($row['email'], 0, 5); ?>...</td>
          <td><?php echo $row['address']; ?></td>
          <td><?php echo $row['xbtvalue']; ?></td>
          <td><?php echo $row['brlvalue']; ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </body>
</html>
