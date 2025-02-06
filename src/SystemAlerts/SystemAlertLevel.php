<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\SystemAlerts;

use Charcoal\OOP\Traits\EnumOptionsTrait;

/**
 * Class SystemAlertLevel
 * @package Charcoal\Framework\Modules\CoreData\SystemAlerts
 */
enum SystemAlertLevel: string
{
    case CRITICAL = "critical";
    case ERROR = "error";
    case NOTICE = "notice";
    case INFO = "info";
    case DEBUG = "debug";

    use EnumOptionsTrait;
}