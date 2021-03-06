<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Controller\Traits;

use Windwalker\Core\Controller\AbstractController;
use Windwalker\Core\Controller\Middleware\HtmlResponseMiddleware;

/**
 * The HtmlResponseTrait class.
 *
 * @since  3.0
 */
trait HtmlResponseTrait
{
    /**
     * bootHtmlResponseTrait
     *
     * @param AbstractController $controller
     *
     * @return  void
     */
    public function bootHtmlResponseTrait(AbstractController $controller)
    {
        $controller->addMiddleware(HtmlResponseMiddleware::class);
    }
}
