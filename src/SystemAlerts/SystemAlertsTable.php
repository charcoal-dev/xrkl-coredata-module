<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\SystemAlerts;

use Charcoal\App\Kernel\Orm\Db\AbstractOrmTable;
use Charcoal\App\Kernel\Orm\Db\DbAwareTableEnum;
use Charcoal\Database\ORM\Schema\Charset;
use Charcoal\Database\ORM\Schema\Columns;
use Charcoal\Database\ORM\Schema\Constraints;
use Charcoal\Database\ORM\Schema\TableMigrations;
use Charcoal\Framework\Modules\CoreData\CoreDataModule;

/**
 * Class SystemAlertsTable
 * @package Charcoal\Framework\Modules\CoreData\SystemAlerts
 * @property CoreDataModule $module
 */
class SystemAlertsTable extends AbstractOrmTable
{
    public function __construct(CoreDataModule $module, DbAwareTableEnum $dbTableEnum)
    {
        parent::__construct($module, $dbTableEnum, SystemAlertEntity::class);
    }

    protected function structure(Columns $cols, Constraints $constraints): void
    {
        $cols->setDefaultCharset(Charset::ASCII);

        $cols->int("id")->bytes(8)->unSigned()->autoIncrement();
        $cols->enumObject("level", SystemAlertLevel::class)->options(...SystemAlertLevel::getOptions());
        $cols->string("message")->length(255);
        $cols->int("timestamp")->bytes(4)->unSigned();
        $cols->enum("trace_interface")->options("http", "cli")->nullable();
        $cols->int("trace_qid")->bytes(8)->unSigned()->nullable();
        $cols->blobBuffer("context")->nullable();
        $cols->setPrimaryKey("id");
    }

    protected function migrations(TableMigrations $migrations): void
    {
    }
}