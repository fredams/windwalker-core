<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2016 LYRASOFT. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace Windwalker\Core\User;

use Windwalker\Authentication\Authentication;
use Windwalker\Authentication\AuthenticationInterface;
use Windwalker\Authentication\Credential;
use Windwalker\Authentication\Method\MethodInterface;
use Windwalker\Authorisation\Authorisation;
use Windwalker\Authorisation\AuthorisationInterface;
use Windwalker\Authorisation\PolicyProviderInterface;
use Windwalker\Core\Facade\AbstractProxyFacade;

/**
 * The User class.
 *
 * @see    UserManager
 * @see    Authentication
 * @see    Authorisation
 *
 * @method static boolean          authenticate(Credential $credential)
 * @method static integer[]        getAuthResults()
 * @method static UserManager      addAuthMethod($name, MethodInterface $method)
 * @method static boolean          authorise($policy, UserDataInterface $user, ...$data)
 * @method static UserManager      addPolicy($name, $handler)
 * @method static UserManager      registerPolicyProvider(PolicyProviderInterface $provider)
 * @method static UserManager      setHandler(UserHandlerInterface $handler)
 * @method static boolean          hasHandler()
 * @method static UserHandlerInterface  getHandler()
 * @method static boolean          login($user, $remember = false, $options = [])
 * @method static boolean          makeUserLoggedIn($user)
 * @method static boolean          logout($conditions = [], $options = [])
 * @method static UserDataInterface       getUser($conditions = [])
 * @method static UserDataInterface       get($conditions = [])
 * @method static UserDataInterface       save($user = [], $options = [])
 * @method static boolean                 delete($conditions = null, $options = [])
 * @method static AuthorisationInterface  getAuthorisation()
 * @method static UserManager             setAuthorisation($authorisation)
 * @method static AuthenticationInterface getAuthentication()
 * @method static UserManager             setAuthentication($authorisation)
 *
 * @since  2.0
 */
class User extends AbstractProxyFacade
{
    /**
     * Property key.
     *
     * @var  string
     * phpcs:disable
    */
    protected static $_key = 'user.manager';
    // phpcs:enable
}
