<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface sfWebmoneyPassportInterface {
  
  /*
   * Passport type by dictionary
   */

  public function getAttestat();

  /*
   * Passport type by number
   */

  public function getAttestatId();

  /*
   * Passport recalled status
   */

  public function isRecalled();

  /*
   * Date and time (Moscow time) when passport was issued
   */

  public function getIssueDate();

  /*
   * Project name, name (nick) of passport issuer who issued this passport
   */

  public function getRegistrant();

  /*
   * WMID of passport issuer who issued this passport
   */

  public function getRegistrantWmid();

  /*
   * Project name, name (nick)
   */

  public function getNickname();

  /*
   * Additional information (direction of activities, comments, commercial information
   * 
   */

  public function getOpenInfo();

  /*
   * Actual location (city) of the organization or WMID owner
   */

  public function getCity();

  /*
   * Actual location (country) of the organization or WMID owner
   */

  public function getCountry();

  /*
   * Actual location (postal code) of the organization or WMID owner
   */

  public function getZipCode();

  /*
   * Actual location (address) of the organization or WMID owner
   */

  public function getAddress();

  /*
   * Surname of WMID owner
   */

  public function getLastname();

  /*
   * Name of WMID owner
   */

  public function getFirstname();

  /*
   * Second (Patronymic) name of WMID owner
   */

  public function getMiddlename();

  /*
   * Contact information of certified WMID owner. E-mail address.
   */

  public function getEmail();

  /*
   * To be used in __toString() method. Example: Firstname + (Nickname) + Lastname
   */

  public function getUsername();
}