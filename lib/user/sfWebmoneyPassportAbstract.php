<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

abstract class sfWebmoneyPassportAbstract {

  protected $wmid = '';
  /**
   * @var SimpleXMLElement
   */
  protected $data = null;
  /**
   *
   * @var string
   */
  protected $rawdata = null;

  /**
   *
   * @param string $wmid
   * @param sfNamespacedParameterHolder $attributeHolder
   */
  public function __construct($wmid, $attributeHolder = null)
  {
    $this->wmid = $wmid;
    if($attributeHolder != null && $attributeHolder->has('data','sfWebmoneyPassport')) {
      $this->data = new SimpleXMLElement($attributeHolder->get('data', null,'sfWebmoneyPassport'));
      $this->rawdata = $attributeHolder->get('data', null,'sfWebmoneyPassport');
    }
    else {
      $req = new SimpleXMLElement('<request/>');

      $req->wmid = '';
      $req->sign = '';
      $group = 'params';
      $req->$group->dict = '1';
      $req->$group->info = '1';
      $req->$group->mode = '0';
      $req->passportwmid = $wmid;
      $url = 'https://passport.webmoney.ru/asp/XMLGetWMPassport.asp';
      $this->rawdata = $this->_request($url, $req->asXML());

      $this->data = new SimpleXMLElement($this->rawdata);
      $attributeHolder->set('data', $this->rawdata,'sfWebmoneyPassport');
    }
  }

  private function _request($url, $xml)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

    $certs_path = sfConfig::get('app_sf_webmoney_auth_cert', '');

    if($certs_path['ca'] != '') {
      curl_setopt($ch, CURLOPT_CAINFO, $certs_path['ca']);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    }
    else {
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    }

    $result = curl_exec($ch);
    sfContext::getInstance()->getLogger()->debug('Sending: ' . var_export($xml, true));
    if(curl_errno($ch) != 0) {
      throw new sfException('CURL_error: ' . curl_errno($ch) . ', ' . curl_error($ch));
    }
    curl_close($ch);

    return $result;
  }

  public function __destruct()
  {
    unset($this->data);
    unset($this->rawdata);
  }

}