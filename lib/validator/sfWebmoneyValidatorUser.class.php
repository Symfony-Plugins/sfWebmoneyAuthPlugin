<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of sfWebmoneyValidatorUser
 *
 * @author Roman
 */
class sfWebmoneyValidatorUser extends sfValidatorBase {

  public function configure($options = array(), $messages = array())
  {
    $this->addOption('wmid', 'WmLogin_WMID');
    $this->addOption('ticket', 'WmLogin_Ticket');
    $this->addOption('user_address', 'WmLogin_UserAddress');
    $this->addOption('urlid', 'WmLogin_UrlID');
    $this->addOption('last_access', 'WmLogin_LastAccess');
    $this->addOption('flags', 'WmLogin_Flags');
    $this->addOption('auth_type', 'WmLogin_AuthType');
    $this->addOption('created', 'WmLogin_Created');
    $this->addOption('expires', 'WmLogin_Expires');

    $this->setMessages(array(
        '-1' => 'Internal error',
        '1' => 'Invalid arguments',
        '2' => 'Invalid authorization Ticket',
        '4' => 'User not found',
        '5' => 'The holder of a site not found',
        '6' => 'Website Not Found',
        '7' => 'This url is not found, or does not belong to the site',
        '8' => 'Security Settings for the site could not be found',
        '9' => 'Access service is not authorized. Invalid password. ',
        '10' => 'Attempting to gain access to the site, which does not accept you as a trustee',
        '11' => 'Password access to the service blocked',
        '12' => 'The user is temporarily blocked. Probably made the selection Ticket',
        '201' => 'Ip address in the request differs from the address, which was an authorized user',
    ));
  }

  protected function doClean($values)
  {
    $response = $this->checkTicket($values);
    if(intval($response->getAttribute('retval')) == 0) {
      return array_merge($values, array(
          $this->getOption('last_access') => $response->getAttribute('lastAccess'),
          $this->getOption('expires') => $response->getAttribute('expires'),
      ));
    }
    elseif(intval($response->getAttribute('retval')) == 3)
      return false;
    else
      throw new sfValidatorError($this, $response->getAttribute('retval'));
  }

  private function checkTicket($data)
  {
    $url = sfConfig::get('app_sf_webmoney_auth_xiface', 'https://login.wmtransfer.com/ws/authorize.xiface');
    $holder = sfConfig::get('app_sf_webmoney_auth_holder', false);
    $rid = sfConfig::get('app_sf_webmoney_auth_RID', false);

    if(!$rid || !$holder)
      throw new sfFilterException("RID or Holder Wmid isn't set");

    $xml = "<request>
 			<siteHolder>{$holder}</siteHolder>
 			<user>{$data[$this->getOption('wmid')]}</user>
 			<ticket>{$data[$this->getOption('ticket')]}</ticket>
 			<urlId>$rid</urlId>
 			<authType>{$data[$this->getOption('auth_type')]}</authType>
 			<userAddress>{$data[$this->getOption('user_address')]}</userAddress>
		</request>";

    if(extension_loaded('curl')) {
      $certs_path = sfConfig::get('app_sf_webmoney_auth_cert', '');

      $ch = curl_init($url);
      curl_setopt_array($ch, array(
          CURLOPT_HEADER => 0,
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_POST => 1,
          CURLOPT_POSTFIELDS => $xml,
      ));
      if($certs_path['ca'] != '') {
        curl_setopt($ch, CURLOPT_CAINFO, $certs_path['ca']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
      }
      else {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      }
      
      $result = curl_exec($ch);

      if(curl_errno($ch) != 0) {
        throw new sfFilterException('CURL_error: ' . curl_errno($ch) . ', ' . curl_error($ch));
      };
      curl_close($ch);

      $response = new XMLReader();
      $response->XML($result);
      $response->read();

      return $response;
    }
    else {
      throw new sfFilterException("CURL dosen't loaded");
    }

    return false;
  }

}