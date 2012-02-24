<?php
/**
* ownCloud shorty plugin, a URL shortener
*
* @author Christian Reiner
* @copyright 2011-2012 Christian Reiner <foss@christian-reiner.info>
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the license, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.
* If not, see <http://www.gnu.org/licenses/>.
*
*/

// Check if we are a user
OC_Util::checkLoggedIn ( );
OC_Util::checkAppEnabled ( 'shorty' );

OC_Util::addStyle  ( 'shorty', 'personal' );
OC_Util::addScript ( 'shorty', 'personal' );

OC_Util::addStyle  ( '3rdparty', 'chosen/chosen' );
OC_Util::addScript ( '3rdparty', 'chosen/chosen.jquery.min' );

// fetch template
$tmpl = new OC_Template ( 'shorty', 'tmpl_personal' );
// inflate template
$tmpl->assign ( 'backend-types',
                array (
                  'none'    => ' [ none ] ',
                  'static'  => 'static backend',
                  'google'  => 'google service',
                  'tinyurl' => 'tinyURL service',
                  'isgd'    => 'is.gd service',
                  'bitly'   => 'bitly.com service',
                ));
$tmpl->assign ( 'backend-static-base-system', OC_Appconfig::getValue('shorty','backend-static-base','') );
$tmpl->assign ( 'backend-static-base',        OC_Preferences::getValue(OC_User::getUser(),'shorty','backend-static-base','') );
$tmpl->assign ( 'backend-google-key',         OC_Preferences::getValue(OC_User::getUser(),'shorty','backend-google-key','') );
$tmpl->assign ( 'backend-bitly-user',         OC_Preferences::getValue(OC_User::getUser(),'shorty','backend-bitly-user','') );
$tmpl->assign ( 'backend-bitly-key',          OC_Preferences::getValue(OC_User::getUser(),'shorty','backend-bitly-key','') );
$tmpl->assign ( 'backend-type',               OC_Preferences::getValue(OC_User::getUser(),'shorty','backend-type','') );
// render template
return $tmpl->fetchPage ( );
?>
