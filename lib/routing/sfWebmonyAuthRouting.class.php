<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class sfWebmoneyAuthRouting {

  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   * @static
   */
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();
    if(sfConfig::get('app_sf_webmoney_auth_routes_register', true)) {
      // preprend our routes
      $r->prependRoute('signin', new sfRoute('/login', array('module' => 'sfWebmoneyAuth', 'action' => 'login')));
      $r->prependRoute('signout', new sfRoute('/logout', array('module' => 'sfWebmoneyAuth', 'action' => 'logout')));
    }
  }

}