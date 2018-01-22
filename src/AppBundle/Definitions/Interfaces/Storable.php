<?php

namespace AppBundle\Definitions\Interfaces;

use AppBundle\Service\Storage\Data\StorageData;
use AppBundle\Service\Storage\Data\StoredData;

interface Storable
{
    public function store(StorageData $storageData): StoredData;
}