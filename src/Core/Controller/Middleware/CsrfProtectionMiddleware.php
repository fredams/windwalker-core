<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Controller\Middleware;

use Windwalker\Core\Security\CsrfProtection;

/**
 * The CsrfTokenMiddleware class.
 *
 * @since  3.0
 *
 * @deprecated  Use web middleware instead.
 */
class CsrfProtectionMiddleware extends AbstractControllerMiddleware
{
    /**
     * Call next middleware.
     *
     * @param   ControllerData $data
     *
     * @return  mixed
     */
    public function execute($data = null)
    {
        if ($this->controller->config->get('csrf_protect', true)) {
            CsrfProtection::validate();
        }

        return $this->next->execute($data);
    }
}
