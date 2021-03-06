<?php
/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    LGPL-2.0-or-later
 */

namespace Windwalker\Core\DateTime;

/**
 * Interface ChronosInterface
 *
 * @since  3.5
 */
interface ChronosInterface
{
    public const FORMAT_YMD = 'Y-m-d';

    public const FORMAT_YMD_HI = 'Y-m-d H:i';

    public const FORMAT_YMD_HIS = 'Y-m-d H:i:s';

    public const TZ_LOCALE = true;
}
