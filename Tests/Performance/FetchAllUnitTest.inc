<?php

$roles = $this->_getReadAdapter()->fetchAll($select);

function fetchAll()
{
    echo 1;
}

fetchAll();