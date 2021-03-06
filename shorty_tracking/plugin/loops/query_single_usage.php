<?php
/**
 * @package shorty an ownCloud url shortener plugin
 * @category internet
 * @author Christian Reiner
 * @copyright 2011-2015 Christian Reiner <foss@christian-reiner.info>
 * @license GNU Affero General Public license (AGPL)
 * @link information http://apps.owncloud.com/content/show.php/Shorty?content=150401
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
 * @file plugin/loops/query_single_usage.php
 * @author Christian Reiner
 */

namespace OCA\Shorty\Tracking\Loop;

/**
 * @class \OCA\Shorty\Tracking\Loop\QuerySingleUsage
 * @extends \OCA\Shorty\Plugin\LoopQueryShorty
 * @brief Represents the list of database queries offered by an app
 * @access public
 * @author Christian Reiner
 */
class QuerySingleUsage extends \OCA\Shorty\Plugin\LoopAppQuery
{
	static $QUERY_KEY       = 'tracking-single-usage';
	static $QUERY_STATEMENT = \OCA\Shorty\Tracking\Query::QUERY_TRACKING_SINGLE_USAGE;
	static $QUERY_PARAM     = [':shorty'];
}
