<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\Countries;

use Charcoal\App\Kernel\Orm\Entity\CacheableEntityInterface;
use Charcoal\App\Kernel\Orm\Entity\CacheableEntityTrait;
use Charcoal\App\Kernel\Orm\Repository\AbstractOrmEntity;

/**
 * Class CountryEntity
 * @package Charcoal\Framework\Modules\CoreData\Countries
 */
class CountryEntity extends AbstractOrmEntity implements CacheableEntityInterface
{
    public bool $status;
    public string $name;
    public string $region;
    public string $code3;
    public string $code2;
    public string $dialCode;

    use CacheableEntityTrait;

    public function getPrimaryId(): string
    {
        return $this->code3;
    }

    protected function collectSerializableData(): array
    {
        return [
            "status" => $this->status,
            "name" => $this->name,
            "region" => $this->region,
            "code3" => $this->code3,
            "code2" => $this->code2,
            "dialCode" => $this->dialCode,
        ];
    }
}