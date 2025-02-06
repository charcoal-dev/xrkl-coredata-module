<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData;

use Charcoal\App\Kernel\Build\AppBuildPartial;
use Charcoal\App\Kernel\Orm\AbstractOrmModule;
use Charcoal\App\Kernel\Orm\CacheStoreEnum;
use Charcoal\App\Kernel\Orm\Db\DatabaseTableRegistry;
use Charcoal\App\Kernel\Orm\Db\DbAwareTableEnum;
use Charcoal\Framework\Modules\CoreData\BruteForceControl\BfcController;
use Charcoal\Framework\Modules\CoreData\BruteForceControl\BfcTable;
use Charcoal\Framework\Modules\CoreData\Countries\CountriesOrm;
use Charcoal\Framework\Modules\CoreData\ObjectStore\ObjectStoreController;
use Charcoal\Framework\Modules\CoreData\ObjectStore\ObjectStoreTable;
use Charcoal\Framework\Modules\CoreData\SystemAlerts\SystemAlertsController;
use Charcoal\Framework\Modules\CoreData\SystemAlerts\SystemAlertsTable;

/**
 * Class CoreDataModule
 * @package Charcoal\Framework\Modules\CoreData
 */
abstract class CoreDataModule extends AbstractOrmModule
{
    public ObjectStoreController $objectStore;
    public CountriesOrm $countries;
    public BfcController $bfc;
    public SystemAlertsController $alerts;
    public Events $events;

    public function __construct(
        AppBuildPartial                    $app,
        CacheStoreEnum                     $cacheStore = null,
        private readonly ?DbAwareTableEnum $objectStoreTable = null,
        private readonly ?DbAwareTableEnum $countriesTable = null,
        private readonly ?DbAwareTableEnum $bfcTable = null,
        private readonly ?DbAwareTableEnum $systemAlertsTable = null,
    )
    {
        parent::__construct($app, $cacheStore);
        $this->events = new Events();
    }

    final protected function declareChildren(AppBuildPartial $app): void
    {
        if ($this->objectStoreTable) {
            $this->objectStore = new ObjectStoreController($this, $this->objectStoreTable);
        }

        if ($this->countriesTable) {
            $this->countries = new CountriesOrm($this, $this->countriesTable);
        }

        if ($this->bfcTable) {
            $this->bfc = new BfcController($this, $this->bfcTable);
        }

        if ($this->systemAlertsTable) {
            $this->alerts = new SystemAlertsController($this, $this->systemAlertsTable);
        }
    }

    final protected function declareDatabaseTables(DatabaseTableRegistry $tables): void
    {
        if ($this->objectStoreTable) {
            $tables->register(new ObjectStoreTable($this, $this->objectStoreTable));
        }

        if ($this->countriesTable) {
            $tables->register(new ObjectStoreTable($this, $this->countriesTable));
        }

        if ($this->bfcTable) {
            $tables->register(new BfcTable($this, $this->bfcTable));
        }

        if ($this->systemAlertsTable) {
            $tables->register(new SystemAlertsTable($this, $this->systemAlertsTable));
        }
    }

    protected function collectSerializableData(): array
    {
        $data = parent::collectSerializableData();
        $data["events"] = null;
        return $data;
    }

    protected function onUnserialize(array $data): void
    {
        parent::onUnserialize($data);
        $this->events = new Events();
    }
}