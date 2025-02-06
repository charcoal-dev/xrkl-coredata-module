<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\BruteForceControl;

use Charcoal\App\Kernel\Orm\AbstractOrmRepository;
use Charcoal\Framework\Modules\CoreData\CoreDataModule;

/**
 * Class BfcController
 * @package Charcoal\Framework\Modules\CoreData\BruteForceControl
 * @property CoreDataModule $module
 */
class BfcController extends AbstractOrmRepository
{
    /**
     * @param BruteForceCheck $action
     * @param string $caller
     * @return void
     * @throws \Charcoal\Database\Exception\QueryExecuteException
     */
    public function logEntry(BruteForceCheck $action, string $caller): void
    {
        $this->table->getDb()->exec(
            "INSERT INTO `" . $this->table->name . "` (`action`, `caller`, `timestamp`)" .
            " VALUES (:action, :caller, :timestamp)",
            [
                "action" => strtolower($action->actionStr),
                "caller" => strtolower($caller),
                "timestamp" => time()
            ]
        );
    }

    /**
     * @param BruteForceCheck|null $action
     * @param string|null $caller
     * @param int $timePeriod
     * @return int
     * @throws \Charcoal\Database\Exception\QueryExecuteException
     * @throws \Charcoal\Database\Exception\QueryFetchException
     */
    public function checkCount(BruteForceCheck $action = null, string $caller = null, int $timePeriod = 3600): int
    {
        $queryStmt = "SELECT count(*) FROM `" . $this->table->name . "` WHERE `timestamp`>=?";
        $queryData = [(time() - $timePeriod)];
        if ($action) {
            $queryStmt .= " AND `action`=?";
            $queryData[] = $action->actionStr;
        }

        if (is_string($caller) && !empty($caller)) {
            $queryStmt .= " AND `caller`=?";
            $queryData[] = strtolower($caller);
        }

        if (count($queryData) <= 1) {
            throw new \LogicException("No action or caller provided to check BFC count");
        }

        $attempts = $this->table->getDb()->fetch($queryStmt, $queryData)->getNext();
        return (int)($attempts["count(*)"] ?? 0);
    }
}