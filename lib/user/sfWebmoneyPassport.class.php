<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class sfWebmoneyPassport extends sfWebmoneyPassportAbstract implements sfWebmoneyPassportInterface {

  public function getAddress()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@adres');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getAttestat()
  {
    $data = $this->data->xpath("/response/certinfo/directory/tid[@id={$this->getAttestatId()}]/text()");
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getAttestatId()
  {
    $data = $this->data->xpath('/response/certinfo/attestat/row/@tid');
    return (int) isset($data[0]) ? $data[0][0] : '';
  }

  public function getCity()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@city');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getCountry()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@country');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getEmail()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@email');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getFirstname()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@iname');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getIssueDate()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@pdate');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getLastname()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@fname');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getMiddlename()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@oname');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getNickname()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@nickname');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getOpenInfo()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@infoopen');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getRegistrant()
  {
    $data = $this->data->xpath('/response/certinfo/attestat/row/@regnickname');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getRegistrantWmid()
  {
    $data = $this->data->xpath('/response/certinfo/attestat/row/@regwmid');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function getUsername()
  {
    return $this->getNickname();
  }

  public function getZipCode()
  {
    $data = $this->data->xpath('/response/certinfo/userinfo/value/row/@zipcode');
    return (string) isset($data[0]) ? $data[0][0] : '';
  }

  public function isRecalled()
  {
    $data = $this->data->xpath('/response/certinfo/attestat/row/@recalled');
    return (bool) isset($data[0]) ? $data[0][0] : f;
  }

}

?>
