<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class BasesfWebmoneyAuthActions extends sfActions {

  public function executeLogin(sfWebRequest $request)
  {
    if($request->isMethod('POST')) {

      $validator = new sfWebmoneyValidatorUser();
      $user = $validator->clean($request->getParameterHolder()->getAll());
      // catch validation errors here
      if($user)
      {
        $this->getUser()->signIn($user);
        $this->redirect(sfConfig::get('app_sf_webmoney_auth_redirect','@homepage'));
      }
      else
        $this->redirect("https://login.wmtransfer.com/GateKeeper.aspx?RID=".sfConfig::get('app_sf_webmoney_auth_RID'));
    }
    else
    {
      $this->redirect("https://login.wmtransfer.com/GateKeeper.aspx?RID=".sfConfig::get('app_sf_webmoney_auth_RID'));
    }
  }

  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->signOut();
    $this->redirect(sfConfig::get('app_sf_webmoney_auth_redirect','@homepage'));
  }

}
