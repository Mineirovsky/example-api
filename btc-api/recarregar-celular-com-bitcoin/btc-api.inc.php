<?php
/*******************************************************************************
                                API BITCOIN
Contém a classe BitcoinAPI

Autor: Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
Data: 2016-07-25
*******************************************************************************/
class BitcoinAPI {
  /*****************************************************************************
  Classe contém métodos para receber cotações e realizar cobranças pela API
  Blockchain
  *****************************************************************************/
  const RATEURL = 'http://api.bitvalor.com/v1/ticker.json';
  const ADDRURL = 'https://api.blockchain.info/v2/receive';
  const APIKEY  = 'api_key_here'; //chave de API Blockchain
  const XPUB    = 'xpub6DJ6uEKYrJCkFhzJenjL2bp7uuUyATXwpy1s4UeHaRXyhswsK3CaaEFd5sSLSPxQnfbA9fiYWvizkBj3Dd9wyghLtuKdWt2borrQ1yTS7S9'; //xPub Blockchain
  const SECRET  = 'jzd3yc7actmJpGc6'; //Blockchain secret
  const CALLBK  = 'http://contascombitcoin.com.br/recarregar-celular-com-bitcoin/callback.php';

  public $rate;
  public $brl_value;
  public $xbt_value;
  public $address;

  public static function getRate() {
    /***************************************************************************
    Recebe dados JSON do API e retorna apenas a média acrescida de 1%
    ***************************************************************************/
    $json = file_get_contents(self::RATEURL);
    $data = json_decode($json);
    return $data->ticker_24h->total->vwap * 0.99;
  }

  public function convertToBTC($value) {
    /***************************************************************************
    Recebe o valor em reais e converte para bitcoins
    ***************************************************************************/
    return $value / $this->rate;
  }

  public function setValue($value) {
    /***************************************************************************
    Define os valores em reais e em bitcoins para o objeto
    ***************************************************************************/
    $this->brl_value = $value;
    $this->xbt_value = sprintf("%.8f", $this->convertToBTC($value));
  }

  public function getAddress() {
    /***************************************************************************
    Retorna o endereço Bitcoin onde deve ser depositado
    ***************************************************************************/
    $callbackurl = self::CALLBK . '&secret=' . self::SECRET;
    $parameters = 'xpub=' .self::XPUB. '&callback=' .urlencode($callbackurl). '&key=' .self::APIKEY;
    $address = file_get_contents(self::ADDRURL . '?' . $parameters);
    $response = json_decode($address);
    $this->address = $response->address;
    return $response->address;
  }

  public function registerBill($ddd, $phone, $carrier) {
    /***************************************************************************
    Registra os dados da recarga para ser reconhecida posteriormente
    ***************************************************************************/
    $sqlite = new SQLite3('bills.sqlite');
    $sql = "INSERT INTO payments
                 VALUES ($ddd, $phone, '$carrier', '$this->address', $this->xbt_value, $this->brl_value);";
    if(@$sqlite->query($sql)) {
      $sqlite->close();
      return true;
    } else {
      $this->logError('BitcoinAPI::registerBill SQLite: ' . $sqlite->lastErrorMsg());
      $sqlite->close();
      return false;
    }
  }

  public function getBillByAddr($address) {
    /***************************************************************************
    Retorna uma array com a linha pesquisada no banco de dados pelo endereço
    ***************************************************************************/
    $sqlite = new SQLite3('bills.sqlite');
    $sql = "SELECT *
              FROM payments
             WHERE address = '$address';";
    $row = @$sqlite->query($sql)->fetchArray(SQLITE3_ASSOC);
    if(!$sqlite->lastErrorCode()) {
      if (!$row) $this->logError('BitcoinAPI::getBillByAddr SQLite: row not found');
      $sqlite->close();
      return $row;
    } else {
      $this->logError('BitcoinAPI::getBillByAddr SQLite: ' . $sqlite->lastErrorMsg());
      $sqlite->close();
      return false;
    }
  }

  public function delBillByAddr($address) {
    $sqlite = new SQLite3('bills.sqlite');
    $sql = "DELETE FROM payments WHERE address = '$address';";
    if(@$sqlite->query($sql)) {
      $sqlite->close();
      return true;
    } else {
      $this->logError('BitcoinAPI::delBillByAddr SQLite: ' . $sqlite->lastErrorMsg());
      $sqlite->close();
      return false;
    }
  }

  public function logError($description) {
    $text = date('[Y-m-d H:i:s]') . ' ' . $description . ' (called @ ' . __FILE__ . ')' . PHP_EOL;
    file_put_contents('./error.log', $text, FILE_APPEND);
  }

  function __construct($value = null) {
    /***************************************************************************
    Constrói o objeto inicializando o valor da cotação e, se for passado o valor
    em reais, inicializa as variáveis que contém o valor em reais e em bitcoins
    ***************************************************************************/
    $this->rate = $this->getRate();
    if($value !== null) {
      $this->setValue($value);
    }
  }
}
?>
