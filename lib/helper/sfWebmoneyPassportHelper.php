<?php

/*
 * This file is part of the symfony plugin package.
 * (c) 2011 Roman Gnatyuk <fozzy@hackers.net.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function attestat_image_tag($tid, $options = array())
{
  return image_tag("/sfWebmoneyAuthPlugin/images/attestat/{$tid}.gif", $options);
}

function link_to_passport($name, $wmid)
{
  $arguments = func_get_args();
  $arguments[1] = "https://passport.webmoney.ru/asp/certView.asp?wmid={$wmid}";
  return call_user_func_array('link_to', $arguments);
}