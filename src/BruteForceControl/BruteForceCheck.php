<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\BruteForceControl;

/**
 * Class BruteForceCheck
 * @package Charcoal\Framework\Modules\CoreData\BruteForceControl
 */
class BruteForceCheck
{
    public readonly string $actionStr;

    public function __construct(string $actionStr)
    {
        if (!preg_match('/^\w{6,64}$/i', $actionStr)) {
            throw new \LogicException("Invalid action string for " . static::class);
        }

        $this->actionStr = strtolower($actionStr);
    }
}