<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\BruteForceControl;

use Charcoal\App\Kernel\Orm\Db\AbstractOrmTable;
use Charcoal\App\Kernel\Orm\Db\DbAwareTableEnum;
use Charcoal\Database\ORM\Schema\Columns;
use Charcoal\Database\ORM\Schema\Constraints;
use Charcoal\Database\ORM\Schema\TableMigrations;
use Charcoal\Framework\Modules\CoreData\CoreDataModule;

/**
 * Class BfcTable
 * @package Charcoal\Framework\Modules\CoreData\BruteForceControl
 * @property CoreDataModule $module
 */
class BfcTable extends AbstractOrmTable
{
    public function __construct(CoreDataModule $module, DbAwareTableEnum $dbTableEnum)
    {
        parent::__construct($module, $dbTableEnum, null);
    }

    protected function structure(Columns $cols, Constraints $constraints): void
    {
        $cols->int("id")->bytes(8)->unSigned()->autoIncrement();
        $cols->string("action")->length(64);
        $cols->string("caller")->length(45);
        $cols->int("timestamp")->bytes(4)->unSigned();
        $cols->setPrimaryKey("id");
    }

    protected function migrations(TableMigrations $migrations): void
    {
    }
}