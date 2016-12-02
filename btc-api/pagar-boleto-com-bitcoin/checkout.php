<?php
require_once('btc-api.inc.php');
if(isset($_POST['value'])):
?>
  <?php
  $cod = $_POST['cod'];
  $expire = $_POST['expire'];
  $carrier = $_POST['carrier'];
  $value = $_POST['value'];
  $email = $_POST['email'];
  $btcapi = new BitcoinAPI($value);
  ?>
  Valor a ser depositado: <?php echo $btcapi->xbt_value; ?> BTC<br>
  Endereço de depósito: <?php echo $btcapi->getAddress(); ?>
  <?php $btcapi->registerBill($cod, $expire, $email); ?>
<?php else: ?>
  Esta página não pode ser acessada sem parâmetros
<?php endif; ?>
