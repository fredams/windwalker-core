<?php
/**
 * Part of windwalker  project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Security;

use Windwalker\Core\Facade\AbstractProxyFacade;
use Windwalker\Crypt\Cipher\CipherInterface;
use Windwalker\Crypt\Crypt;
use Windwalker\Crypt\CryptInterface;

/**
 * The Crypto class.
 *
 * @see    Crypt
 * @see    CryptInterface
 *
 * @method  static string   encrypt($string, $key = null, $iv = null)
 * @method  static string   decrypt($string, $key = null, $iv = null)
 * @method  static boolean  verify($string, $encrypted, $key = null, $iv = null)
 * @method  static Crypt    setKey($key)
 * @method  static string   getKey($key)
 * @method  static Crypt    getIV($key)
 * @method  static string   setIV($iv)
 * @method  static CipherInterface getCipher()
 * @method  static Crypt    setCipher(CipherInterface $iv)
 *
 * @since  3.0
 */
class Crypto extends AbstractProxyFacade
{
    /**
     * Property _key.
     *
     * @var  string
     * phpcs:disable
    */
    protected static $_key = 'crypt';
    // phpcs:enable
}
