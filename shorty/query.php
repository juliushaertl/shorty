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
 * @file query.php
 * This is the plugins central query service
 * @access public
 * @author Christian Reiner
 */

namespace OCA\Shorty;

// swallow any accidental output generated by php notices and stuff to preserve a clean JSON reply structure
Tools::ob_control ( TRUE );

// Session checks
\OCP\App::checkAppEnabled ( 'shorty' );

$RUNTIME_NOSETUPFS = true;

try
{
	$p_id      = Type::req_argument ( 'id',     Type::ID,     FALSE );
	$p_query   = Type::req_argument ( 'query',  Type::STRING, FALSE );
	$p_format  = Type::req_argument ( 'format', Type::STRING, FALSE );
	$p_sort    = Type::req_argument ( 'sort',   Type::STRING, 'ka' );
	$param = [
		':user'   => \OCP\User::getUser ( ),
		':id'     => $p_id,
		':sort'   => Type::$SORTING[$p_sort],
		':format' => $p_format,
		':query'  => $p_query,
	];

	$match = NULL;
	$candidates = Hooks::requestQueries();
	foreach ($candidates['list'] as $candidate)
		if ($candidate['id']==$p_query)
			$match = $candidate;
	if ( ! $match )
		throw new Exception ( "Request for unknown query '%1'.", [$p_query] );

	// run query
	$query = \OCP\DB::prepare ( $match['query'] );
	$result = $query->execute(array_intersect($param,$match['param']));
	$reply = $result->fetchAll();

	// swallow any accidental output generated by php notices and stuff to preserve a clean JSON reply structure
	Tools::ob_control ( FALSE );

	// output payload
	switch ( strtolower($p_format) ) {
		default:
			throw new Exception ( "Sorry, no payload format specified." );

			case 'json':
				// check availability of phps yaml extension ("syck")
				if ( ! extension_loaded('json') )
					throw new Exception ( "Sorry, support for payload format 'json' not installed." );
				// output payload
				print json_encode($reply);
			break;

			case 'yaml':
				// first option: php extension 'yaml'
				if ( extension_loaded('yaml') )
					print yaml_emit($reply);
				elseif ( function_exists('syck_dump') )
					syck_dump($reply);
				elseif (class_exists('Spyc'))
					Spyc::YAMLDump($reply);
				else
					// no implementation found, sorry...
					throw new Exception ( "Sorry, support for payload format 'yaml' not installed." );
			break;

			case 'csv':
				// apparently php _always_ offers csv support...
				// output payload
				$buffer = fopen('php://temp', 'r+');
				foreach ($reply as $entry) {
					fputcsv($buffer, $entry);
				} // foreach
				rewind($buffer);
				print fpassthru($buffer);
				fclose($buffer);
			break;

	} // switch format

	\OCP\Util::writeLog( 'shorty', sprintf("Delivered response to remote call of query '%s'",$p_query), \OCP\Util::DEBUG );

} catch ( Exception $e ) { header($e->getMessage()); }
