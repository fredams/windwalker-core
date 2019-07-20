<?php
/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2019 .
 * @license    __LICENSE__
 */

namespace Windwalker\Core\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Windwalker\Http\Stream\Stream;
use Windwalker\Middleware\MiddlewareInterface;
use Windwalker\Utilities\Classes\OptionAccessTrait;

/**
 * The SefWebMiddleware class.
 *
 * @since  __DEPLOY_VERSION__
 */
class SefWebMiddleware extends AbstractWebMiddleware
{
    use OptionAccessTrait;

    /**
     * ForceSslWebMiddleware constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Middleware logic to be invoked.
     *
     * @param Request                      $request  The request.
     * @param Response                     $response The response.
     * @param callable|MiddlewareInterface $next     The next middleware.
     *
     * @return  Response
     */
    public function __invoke(Request $request, Response $response, $next = null)
    {
        /** @var Response $response */
        $response = $next($request, $response);

        if ($this->getOption('enabled', true)) {
            $newBody = $this->replaceRoutes((string) $response->getBody());

            $stream = new Stream('php://memory', Stream::MODE_READ_WRITE_FROM_BEGIN);
            $stream->write($newBody);

            $response = $response->withBody($stream);
        }

        return $response;
    }

    /**
     * replaceRoutes
     *
     * @see https://github.com/joomla/joomla-cms/blob/staging/plugins/system/sef/sef.php
     *
     * @param string $buffer
     *
     * @return  string
     *
     * @since  __DEPLOY_VERSION__
     */
    protected function replaceRoutes(string $buffer): string
    {
        // Replace src links.
        $base = $this->getOption(
            'base',
            rtrim($this->app->uri->path . '/' . $this->app->uri->script, '/') . '/'
        );

        // For feeds we need to search for the URL with domain.

        // Check for all unknown protocals
        // (a protocol must contain at least one alpahnumeric character followed by a ":").
        $protocols  = '[a-zA-Z0-9\-]+:';
        $attributes = ['href=', 'src=', 'poster='];

        foreach ($attributes as $attribute) {
            if (strpos($buffer, $attribute) !== false) {
                $regex  = '#\s' . $attribute . '"(?!/|' . $protocols . '|\#|\')([^"]*)"#m';
                $buffer = preg_replace($regex, ' ' . $attribute . '"' . $base . '$1"', $buffer);
                $this->checkBuffer($buffer);
            }
        }

        if (strpos($buffer, 'srcset=') !== false) {
            $regex  = '#\s+srcset="([^"]+)"#m';
            $buffer = (string) preg_replace_callback(
                $regex,
                static function ($match) use ($base, $protocols) {
                    preg_match_all('#(?:[^\s]+)\s*(?:[\d\.]+[wx])?(?:\,\s*)?#i', $match[1], $matches);

                    foreach ($matches[0] as &$src) {
                        $src = preg_replace('#^(?!/|' . $protocols . '|\#|\')(.+)#', $base . '$1', $src);
                    }

                    return ' srcset="' . implode($matches[0]) . '"';
                },
                $buffer
            );

            $this->checkBuffer($buffer);
        }

        // Replace all unknown protocals in javascript window open events.
        if (strpos($buffer, 'window.open(') !== false) {
            $regex  = '#onclick="window.open\(\'(?!/|' . $protocols . '|\#)([^/]+[^\']*?\')#m';
            $buffer = (string) preg_replace($regex, 'onclick="window.open(\'' . $base . '$1', $buffer);
            $this->checkBuffer($buffer);
        }
        // Replace all unknown protocols in onmouseover and onmouseout attributes.
        $attributes = ['onmouseover=', 'onmouseout='];

        foreach ($attributes as $attribute) {
            if (strpos($buffer, $attribute) !== false) {
                $regex  = '#' . $attribute . '"this.src=([\']+)(?!/|' . $protocols . '|\#|\')([^"]+)"#m';
                $buffer = (string) preg_replace($regex, $attribute . '"this.src=$1' . $base . '$2"', $buffer);
                $this->checkBuffer($buffer);
            }
        }

        // Replace all unknown protocols in CSS background image.
        if (strpos($buffer, 'style=') !== false) {
            $regex_url = '\s*url\s*\(([\'\"]|\&\#0?3[49];)?(?!/|\&\#0?3[49];|'
                . $protocols . '|\#)([^\)\'\"]+)([\'\"]|\&\#0?3[49];)?\)';
            $regex     = '#style=\s*([\'\"])(.*):' . $regex_url . '#m';
            $buffer    = (string) preg_replace($regex, 'style=$1$2: url($3' . $base . '$4$5)', $buffer);
            $this->checkBuffer($buffer);
        }

        // Replace all unknown protocols in OBJECT param tag.
        if (strpos($buffer, '<param') !== false) {
            // OBJECT <param name="xx", value="yy"> -- fix it only inside the <param> tag.
            $regex  = '#(<param\s+)name\s*=\s*"(movie|src|url)"[^>]\s*value\s*=\s*"(?!/|' .
                $protocols . '|\#|\')([^"]*)"#m';
            $buffer = (string) preg_replace($regex, '$1name="$2" value="' . $base . '$3"', $buffer);
            $this->checkBuffer($buffer);

            // OBJECT <param value="xx", name="yy"> -- fix it only inside the <param> tag.
            $regex  = '#(<param\s+[^>]*)value\s*=\s*"(?!/|' . $protocols
                . '|\#|\')([^"]*)"\s*name\s*=\s*"(movie|src|url)"#m';
            $buffer = (string) preg_replace($regex, '<param value="' . $base . '$2" name="$3"', $buffer);
            $this->checkBuffer($buffer);
        }

        // Replace all unknown protocols in OBJECT tag.
        if (strpos($buffer, '<object') !== false) {
            $regex  = '#(<object\s+[^>]*)data\s*=\s*"(?!/|' . $protocols . '|\#|\')([^"]*)"#m';
            $buffer = preg_replace($regex, '$1data="' . $base . '$2"', $buffer);
            $this->checkBuffer($buffer);
        }

        return $buffer;
    }

    /**
     * checkBuffer
     *
     * @param string $buffer
     *
     * @return  void
     *
     * @since  __DEPLOY_VERSION__
     */
    private function checkBuffer(string $buffer): void
    {
        if ($buffer === null) {
            switch (preg_last_error()) {
                case PREG_BACKTRACK_LIMIT_ERROR:
                    $message = 'PHP regular expression limit reached (pcre.backtrack_limit)';
                    break;
                case PREG_RECURSION_LIMIT_ERROR:
                    $message = 'PHP regular expression limit reached (pcre.recursion_limit)';
                    break;
                case PREG_BAD_UTF8_ERROR:
                    $message = 'Bad UTF8 passed to PCRE function';
                    break;
                default:
                    $message = 'Unknown PCRE error calling PCRE function';
            }

            throw new \RuntimeException($message);
        }
    }
}
