<?php

class SlowQueryTest
{
    protected function _prepareLoadSelect(array $selects)
    {
        return $this->_getReadAdapter()->select()->union($selects, Zend_Db_Select::SQL_UNION_ALL);
    }
}

$duplicatedUsers = $installer->getConnection()->fetchPairs("
SELECT user_id, username FROM {$tableAdmins} GROUP by username HAVING COUNT(user_id) > 1
");

$sql = "SELECT
        attribute_id, value
    FROM {$installer->getTable('sales_order_entity_decimal')}
    WHERE
        entity_id={$itemId}
        AND entity_type_id={$itemEntityId}

    UNION
    SELECT
        attribute_id, value
    FROM {$installer->getTable('sales_order_entity_datetime')}
    WHERE
        entity_id={$itemId}
        AND entity_type_id={$itemEntityId}";