<?php
/*******************************************************************************
                                API IRECARGA
Contém a classe IRecargaAPI

Autor: Gabriel Mineiro <gabrielpfgmineiro@gmail.com>
Data: 2016-07-28
*******************************************************************************/

class IRecargaAPI {
  /*****************************************************************************
  Classe contém métodos para acessar o sistema iRecarga e realizar recargas
  *****************************************************************************/
  const USER = ''; //e-mail iRecarga
  const PASS = ''; //senha iRecarga

  private $token;

  private function getToken() {
    /***************************************************************************
    Efetua o login e armazena o token
    ***************************************************************************/
    $postaddress = 'https://www.irecarga.com.br/api/ValidateUser.ashx?action=validateLoginSenha';
    $post        = 'NN_LOGIN=' . urlencode(self::USER) . '&NN_PASSWORD=' . urlencode(self::PASS);

    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $postaddress);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec($ch);
    curl_close($ch);
    $response = ob_get_contents();
    ob_end_clean();

    $res = json_decode($response);
    if($res->status) {
      return $res->token;
    } else {
      echo "Login error: $res->erro";
    }
  }

  public function reloadPhone($ddd, $phone, $carrier, $value) {
    /***************************************************************************
    Realiza a recarga do telefone inserido nos parâmetros
    ***************************************************************************/
    $postaddress = 'https://www.irecarga.com.br/api/ReloadPhone.ashx?action=reloadPhoneValue';
    $post = 'NN_DDD=' . $ddd .
            '&NN_PHONENUMBER=' . $phone .
            '&NN_COMPANY=' . $carrier .
            '&NN_VALUE=' . $value .
            '&NN_TOKEN=' . $this->token .
            'NN_OS=VIA';

    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $postaddress);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec($ch);
    curl_close($ch);
    $response = ob_get_contents();
    ob_end_clean();

    $res = json_decode($response);
    if($res->status) {
      return $res->idRecibo;
    } else {
      return false;
    }
  }

  function __construct()
  {
    $this->token = $this->getToken();
  }
}
?>
