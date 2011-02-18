<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class sfWebmoneyUser extends sfBasicSecurityUser {

  /**
   * @var Array
   */
  protected $user = null;
  /**
   * @var sfWebmoneyPassport
   */
  protected $passport = null;

  /**
   * Initializes the sfWebmoneyUser object.
   *
   * @param sfEventDispatcher $dispatcher The event dispatcher object
   * @param sfStorage $storage The session storage object
   * @param array $options An array of options
   */
  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
  {
    parent::initialize($dispatcher, $storage, $options);

    if(!$this->isAuthenticated()) {
      // remove user if timeout
      $this->getAttributeHolder()->removeNamespace('sfWebmoneyUser');
      $this->getAttributeHolder()->removeNamespace('sfWebmoneyPassport');
      $this->user = null;
    }
    else
    {
      $this->user = $this->getAttribute('user');
      $this->passport = new sfWebmoneyPassport($this->user['WmLogin_WMID'],$this->attributeHolder);
    }
  }

  /**
   * Returns the referer uri.
   *
   * @param string $default The default uri to return
   * @return string $referer The referer
   */
  public function getReferer($default)
  {
    $referer = $this->getAttribute('referer', $default);
    $this->getAttributeHolder()->remove('referer');

    return $referer;
  }

  /**
   * Sets the referer.
   *
   * @param string $referer
   */
  public function setReferer($referer)
  {
    if(!$this->hasAttribute('referer')) {
      $this->setAttribute('referer', $referer);
    }
  }

  /**
   * Returns whether or not the user is anonymous.
   *
   * @return boolean
   */
  public function isAnonymous()
  {
    return!$this->isAuthenticated();
  }

  /**
   * Signs in the user on the application.
   *
   * @param array $ticket Ticket returned from login
   */
  public function signIn($ticket)
  {
    $this->user = $ticket;
    $this->setAttribute('user', $ticket);

    $this->passport = new sfWebmoneyPassport($ticket['WmLogin_WMID'], $this->attributeHolder);
    
    $this->setAuthenticated(true);
    $this->clearCredentials();
  }

  public function signOut()
  {
    $this->getAttributeHolder()->removeNamespace('sfWebmoneyUser');
    $this->getAttributeHolder()->removeNamespace('sfWebmoneyPassport');
    $this->getAttributeHolder()->clear();
    $this->user = null;
    // Don't null $this->passport variable
    $this->clearCredentials();
    $this->setAuthenticated(false);
  }

  /*
   * @return sfWebmoneyPassport
   */
  public function getPassport()
  {
    return $this->passport;
  }

  public function getWmid()
  {
    return $this->user['WmLogin_WMID'];
  }

}

?>
