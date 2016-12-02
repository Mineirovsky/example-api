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

      $to = 'infopagamentos@gmail.com'; //email que receberá
      $subject = 'Novo boleto aprovado para pagamento';
      $msg = "
      <html>
      <head>
      <title>Novo boleto aprovado para pagamento</title>
      </head>
      <body>
      <p>Um novo boleto foi aprovado para pagamento</p>
      <table>
      <tbody>
      <tr><td>Valor (R$):</td><td>$bill['brlvalue']</td></tr>
      <tr><td>Valor (&#3647;):</td><td>$bill['xbtvalue']</td></tr>
      <tr><td>Vencimento:</td><td>$bill['expire']</td></tr>
      <tr><td>E-mail:</td><td>$bill['email']</td></tr>
      <tr><td>Linha digit&aacute;vel:</td><td><code>$bill['cod']</code></td></tr>
      </tbody>
      </table>
      </body>
      </html>
      ";
      $headers = "MIME-Version: 1.0" . "\r\n"
               . "Content-type:text/html;charset=UTF-8" . "\r\n"
               . 'From: <noreply@contascombitcoin.com.br>' . "\r\n";
      if(mail($to,$subject,$msg,$headers) === FALSE) {
        $btciapi->logError("Callback: não foi possível enviar e-mail, endereço: $address");
      }
    } else {
      echo '*bad value*';
      $btcapi->logError("Callback: valor pago incorreto no endereço: $address");
    }
  } else {
    echo '*waiting confirmation*';
  }
} else {
  echo '*bad*';
}
?>
