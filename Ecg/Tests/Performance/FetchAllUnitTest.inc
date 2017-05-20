<?php

namespace Ecg\Tests\Performance;

$roles = $this->_getReadAdapter()->fetchAll($select);

function fetchAll()
{
    echo 1;
}

fetchAll();