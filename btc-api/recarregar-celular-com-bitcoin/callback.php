<?php
include('btc-api.inc.php');
include('irecarga-api.inc.php');

$btcapi = new BitcoinAPI();

$transaction_hash = $_GET['transaction_hash'];
$address = $_GET['address'];
$confirmations = $_GET['confirmations'];
$value = $_GET['value'] / 100000000;
$secret = $_GET['secret'];

$bill = $btcapi->getBillByAddr($address);
if($bill == false) die('*not found*');

if($secret == BitcoinAPI::SECRET) {
  if($confirmations >= 1) {
    if($value == $bill['xbtvalue']) {
      echo '*ok*';
      $ir = new IRecargaAPI();
      $recibo = $ir->reloadPhone($bill['ddd'], $bill['phone'], $bill['carrier'], $bill['brlvalue']);
    } else {
      echo '*bad value*';
      $btcapi->logError('Callback: valor pago incorreto');
    }
  } else {
    echo '*waiting confirmation*';
  }
} else {
  echo '*bad*';
}
?>
