<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Controller\Middleware;

use Windwalker\Http\Response\RedirectResponse;

/**
 * The RedirectResponseMiddleware class.
 *
 * @since  3.0
 *
 * @deprecated Do not manually use this.
 */
class RedirectResponseMiddleware extends AbstractControllerMiddleware
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
        $result = $this->next->execute($data);

        $response = $data->response;

        $this->controller->setResponse(new RedirectResponse(
            $result,
            $response->getStatusCode(),
            $response->getHeaders()
        ));

        return $this->next->execute($data);
    }
}
