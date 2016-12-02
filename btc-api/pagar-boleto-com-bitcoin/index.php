<!DOCTYPE html>
<html>
  <head>
    <meta charset="iso-8859-1">
    <title>Recarga de celular</title>
  </head>
  <body>
    <form method="post" action="checkout.php">
      <label for="inputCod">Linha digitável</label>
      <input type="number" name="cod" id="inputCod">
      <label for="inputValue">Valor</label>
      <input type="number" name="value" id="inputValue">
      <label for="inputExpire">Vencimento</label>
      <input type="number" name="expire" id="inputExpire">
      <label for="inputEmail">E-mail</label>
      <input type="email" name="email" id="inputEmail">
      <button type="submit">Pagar</button>
    </form>
  </body>
</html>
