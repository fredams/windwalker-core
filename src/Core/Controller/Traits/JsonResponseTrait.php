<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Controller\Traits;

use Windwalker\Core\Controller\AbstractController;
use Windwalker\Core\Controller\Middleware\JsonResponseMiddleware;
use Windwalker\Utilities\Queue\PriorityQueue;

/**
 * The HtmlResponseTrait class.
 *
 * @since  3.0
 *
 * @deprecated  Use web middleware instead.
 */
trait JsonResponseTrait
{
    /**
     * bootHtmlResponseTrait
     *
     * @param AbstractController $controller
     *
     * @return  void
     */
    public function bootJsonResponseTrait(AbstractController $controller)
    {
        $controller->addMiddleware(JsonResponseMiddleware::class, PriorityQueue::MAX);
    }
}
