<?php
/**
 * @package shorty-tracking an ownCloud url shortener plugin addition
 * @category internet
 * @author Christian Reiner
 * @copyright 2012-2015 Christian Reiner <foss@christian-reiner.info>
 * @license GNU Affero General Public license (AGPL)
 * @link information http://apps.owncloud.com/content/show.php/Shorty+Tracking?content=152473
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

/**
 * @file plugin/loops/loop_include.php
 * Static class providing routines to populate hooks called by other parts of ownCloud
 * @author Christian Reiner
 */

namespace OCA\Shorty\Tracking\Loop;

/**
 * @class \OCA\Shorty\Tracking\Loop\AppIncludes
 * @extends \OCA\Shorty\Plugin\LoopAppIncludes
 * @brief Represents a list of styles and script files to be included
 * @access public
 * @author Christian Reiner
 */
class AppIncludes extends \OCA\Shorty\Plugin\LoopAppIncludes
{
	static $INCLUDE_CALLBACKS = [];

	public function __construct()
	{
		static::$INCLUDE_CALLBACKS[] = function() { \OCP\Util::addStyle  ( 'shorty_tracking', 'tracking' ); };
		static::$INCLUDE_CALLBACKS[] = function() { \OCP\Util::addScript ( 'shorty_tracking', 'tracking' ); };
		static::$INCLUDE_CALLBACKS[] = function() { \OCP\Util::addScript ( 'shorty_tracking', '../3rdparty/js/jquery.sparkline.min' ); };
	}
}
