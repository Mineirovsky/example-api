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
  Endere�o de dep�sito: <?php echo $btcapi->getAddress(); ?>
  <?php $btcapi->registerBill($cod, $expire, $email); ?>
<?php else: ?>
  Esta p�gina n�o pode ser acessada sem par�metros
<?php endif; ?>
