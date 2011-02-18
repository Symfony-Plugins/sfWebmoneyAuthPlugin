<?php
/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class sfWebmoneyAuthPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
      $this->dispatcher->connect('routing.load_configuration', array('sfWebmoneyAuthRouting', 'listenToRoutingLoadConfigurationEvent'));
  }
}
