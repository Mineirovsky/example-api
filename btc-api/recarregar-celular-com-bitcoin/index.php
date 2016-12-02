<!DOCTYPE html>
<html>
  <head>
    <meta charset="iso-8859-1">
    <title>Recarga de celular</title>
  </head>
  <body>
    <form method="post" action="checkout.php">
      <label for="inputDDD">DDD</label>
      <input type="text" name="ddd" id="inputDDD">
      <label for="inputPhone">Número</label>
      <input type="text" name="phone" id="inputPhone">
      <label for="selCarrier">Operadora</label>
      <select id="selCarrier" name="carrier">
        <option value="Vivo">Vivo</option>
        <option value="Tim">Tim</option>
        <option value="Oi">Oi</option>
        <option value="Claro">Claro</option>
      </select>
      <label for="inputValue">Valor</label>
      <input type="text" name="value" id="inputValue">
      <label for="inputEmail">E-mail</label>
      <input type="text" name="email" id="inputEmail">
      <button type="submit">Recarregar</button>
    </form>
  </body>
</html>
