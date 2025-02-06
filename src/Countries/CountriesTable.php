<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\Countries;

use Charcoal\App\Kernel\Orm\Db\AbstractOrmTable;
use Charcoal\App\Kernel\Orm\Db\DbAwareTableEnum;
use Charcoal\Database\ORM\Schema\Charset;
use Charcoal\Database\ORM\Schema\Columns;
use Charcoal\Database\ORM\Schema\Constraints;
use Charcoal\Database\ORM\Schema\TableMigrations;
use Charcoal\Framework\Modules\CoreData\CoreDataModule;

/**
 * Class CountriesTable
 * @package Charcoal\Framework\Modules\CoreData\Countries
 * @property CoreDataModule $module
 */
class CountriesTable extends AbstractOrmTable
{
    /**
     * @param CoreDataModule $module
     * @param DbAwareTableEnum $dbTableEnum
     */
    public function __construct(CoreDataModule $module, DbAwareTableEnum $dbTableEnum)
    {
        parent::__construct($module, $dbTableEnum, CountryEntity::class);
    }

    /**
     * @param Columns $cols
     * @param Constraints $constraints
     * @return void
     */
    protected function structure(Columns $cols, Constraints $constraints): void
    {
        $cols->setDefaultCharset(Charset::ASCII);

        $cols->bool("status")->default(false);
        $cols->string("name")->length(40);
        $cols->string("region")->length(40);
        $cols->string("code3")->fixed(3)->unique();
        $cols->string("code2")->fixed(2)->unique();
        $cols->string("dial_code")->length(8);
    }

    /**
     * @param TableMigrations $migrations
     * @return void
     */
    protected function migrations(TableMigrations $migrations): void
    {
    }
}