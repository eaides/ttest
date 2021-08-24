<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait InsertIgnoreOnDuplicate
{
    /**
     * 2 public functions receive array $data:
     *
     * public static function insertIgnore(array $data)
     * public static function insertOnDuplicate(array $data)
     *
     * Example of $data:
     *
     * $data = [
     *    [
     *    'id' => 1,
     *    'first_name' => 'Ernesto',
     *    'last_name' => 'Aides',
     *    'email' => 'eaides@hotmail.com',
     *    'data' => 'data for 1',
     *    ],
     *    [
     *    'first_name' => 'Ernesto',
     *    'last_name' => 'Aides',
     *    'email' => 'eaides@hotmail.com',
     *    'data' => 'data for 2',
     *    ],
     *    [
     *    'first_name' => 'Natalio',
     *    'last_name' => 'Aides',
     *    'email' => 'eaides@gmail.com',
     *    'data' => 'data for 3',
     *    ],
     *    [
     *    'first_name' => 'Other',
     *    'last_name' => 'Last',
     *    'email' => 'eaides@hotmail.com',
     *    'data' => 'data for 4',
     *    ],
     * ];
     *
     * $data = [
     *      'id' => 1,
     *      'first_name' => 'Ernesto',
     *      'last_name' => 'Aides',
     *      'email' => 'eaides@hotmail.com',
     *      'data' => 'data for 1',
     * ];
     *
     */

    /**
     * Static function for getting connection name
     * @return \Illuminate\Database\Connection
     */
    protected static function getModelConnectionName()
    {
        $model = new static();
        return $model->getConnection();
    }

    /**
     * Static function for getting connection name
     * @return boolean
     */
    protected static function isMySql()
    {
        $model = new static();
        $driver = $model->GetConnection()->GetDriverName();
        return (strtolower($driver)==='mysql');
    }

    /**
     * Static function for getting table name.
     * @return string
     */
    protected static function getTableName()
    {
        $model = new static();
        return $model->getTable();
    }

    /**
     * @param array $data
     */
    protected static function normalizeData(array &$data)
    {
        if (!isset($data[0]) || !is_array($data[0])) {
            $data = [$data];
        }
    }

    /**
     * @brief: Insert using mysql INSERT IGNORE INTO.
     *
     * pay attention:
     *      1) works only with MySql DB
     *      2) this is just an example, Query Builder already supports insertOrIgnore
     *
     * @param array $data
     *
     * @usage: $result = ModelName::insertIgnore($data);
     *
     * @return int
     */
    public static function insertIgnore(array $data)
    {
        if (!self::isMySql()) return 0;  // or throw new \Exception('only supported in MySql');

        if (empty($data)) {
            return false;
        }

        self::normalizeData($data);

        $return = 0;
        foreach($data as $insert)
        {
            $sql = self::buildInsertOnDuplicateSql($insert, true);
            $bindings = array_values($insert);
            $return += DB::affectingStatement($sql, $bindings);
        }

        return $return;
    }

    /**
     * @brief Insert using mysql INSERT IGNORE INTO.
     *
     * pay attention:
     *      1) works only with MySql DB
     *
     * @param array $data
     *
     * @usage: $result = ModelName::insertOnDuplicate($data);
     *
     * @return int
     */
    public static function insertOnDuplicate(array $data)
    {
        if (!self::isMySql()) return 0;  // or throw new \Exception('only supported in MySql');

        if (empty($data)) {
            return 0;
        }

        self::normalizeData($data);

        $return = 0;
        foreach($data as $insert) {
            $sql = self::buildInsertOnDuplicateSql($insert, false);
            $bindings = array_merge(array_values($insert),array_values($insert));
            $return += DB::affectingStatement($sql, $bindings);
        }

        return $return;
    }

    /**
     * Build the INSERT IGNORE or INSERT ON DUPLICATE KEY sql statement.
     * @param array $data
     * @param boolean $ignore
     *
     * @return string
     */
    protected static function buildInsertOnDuplicateSql(array $data, $ignore=true)
    {
        // testing use php 7.3: no typed arguments supported
        $ignoreStr = (bool)$ignore ? ' IGNORE ': '';

        $sql  = 'INSERT' . $ignoreStr . ' INTO `' . self::getTableName() . '`';

        $sql .= ' (' . self::getColumnList($data) . ') VALUES (';
        $sql .= self::buildValuesListByQuestionMarks($data) . ')';

        if ((bool)$ignore) return $sql;

        $sql .= ' ON DUPLICATE KEY UPDATE ';
        $sql .= self::buildUpdateListByQuestionMarks($data);

        return $sql;
    }

    /**
     * Build a column list.
     * @param array $first
     *
     * @return string
     */
    protected static function getColumnList(array $data)
    {
        return '`' . implode('`,`', array_keys($data)) . '`';
    }

    /**
     * Build a value list.
     * @param array $data
     *
     * @return string
     */
    protected static function buildValuesListByQuestionMarks(array $data)
    {
        $values = [];
        foreach ($data as $key => $value) {
            $values[] = '?';
        }
        return implode(', ', $values);
    }

    /**
     * Build a value list.
     * @param array $data
     *
     * @return string
     */
    protected static function buildUpdateListByQuestionMarks(array $data)
    {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = sprintf('`%s` = ?', $key);
        }
        return implode(', ', $updates);
    }

}