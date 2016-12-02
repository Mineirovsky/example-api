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
  Endereço de depósito: <?php echo $btcapi->getAddress(); ?>
  <?php $btcapi->registerBill($ddd, $phone, $carrier); ?>
<?php else: ?>
  Esta página não pode ser acessada sem parâmetros
<?php endif; ?>
