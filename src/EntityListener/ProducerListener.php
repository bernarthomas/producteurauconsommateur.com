<?php

namespace App\EntityListener;

use App\Entity\Farm;
use App\Entity\Producer;
use Symfony\Component\Uid\Uuid;

/**
 * Class ProducerListener
 */
class ProducerListener
{
    public function prePersist(Producer $producer): void
    {
        $farm = new Farm();
        $farm
            ->setId(Uuid::v4())
            ->setProducer($producer);
        $producer->setFarm($farm);
    }
}
