<?php
require_once('btc-api.inc.php');
if(isset($_POST['value'])):
?>
  <?php
  $ddd = $_POST['ddd'];
  $phone = $_POST['phone'];
  $carrier = $_POST['carrier'];
  $value = $_POST['value'];
  $btcapi = new BitcoinAPI($value);
  ?>
  Valor a ser depositado: <?php echo $btcapi->xbt_value; ?> BTC<br>
  Endere�o de dep�sito: <?php echo $btcapi->getAddress(); ?>
  <?php $btcapi->registerBill($ddd, $phone, $carrier); ?>
<?php else: ?>
  Esta p�gina n�o pode ser acessada sem par�metros
<?php endif; ?>
