<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Authenticate;

/**
 * The UserDataInterface class.
 * 
 * @since  2.0
 */
interface UserDataInterface
{
	/**
	 * isGuest
	 *
	 * @return  boolean
	 */
	public function isGuest();

	/**
	 * isMember
	 *
	 * @return  boolean
	 */
	public function isMember();

	/**
	 * toArray
	 *
	 * @return  array
	 */
	public function dump();

	/**
	 * bind
	 *
	 * @param array $data
	 *
	 * @return  mixed
	 */
	public function bind($data);

	/**
	 * isNull
	 *
	 * @return  boolean
	 */
	public function isNull();

	/**
	 * notNull
	 *
	 * @return  boolean
	 */
	public function notNull();
}