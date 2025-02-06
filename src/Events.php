<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData;

use Charcoal\Events\Event;
use Charcoal\Events\EventsRegistry;

/**
 * Class Events
 * @package Charcoal\Framework\Modules\CoreData
 */
class Events extends EventsRegistry
{
    /**
     * @return Event
     */
    public function onSystemAlert(): Event
    {
        return $this->on("app.coreData.systemAlert");
    }
}