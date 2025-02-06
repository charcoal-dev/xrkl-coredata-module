<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\SystemAlerts;

use Charcoal\App\Kernel\Errors;

/**
 * Class SystemAlertContext
 * @package Charcoal\Framework\Modules\CoreData\SystemAlerts
 */
class SystemAlertContext
{
    public readonly ?array $exception;
    private array $data = [];

    public function __construct(?\Throwable $exception)
    {
        $this->exception = $exception ? Errors::Exception2Array($exception) : null;
    }

    public function set(string $key, string|int|null|bool|float $value): static
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }
}