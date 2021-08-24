<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait InsertIgnoreOnDuplicate
{
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
     * Insert using mysql INSERT IGNORE INTO.
     *
     * pay attention, this is just a raw example, Query Builder already supports insertOrIgnore
     * @param array $data
     *
     * @return int
     */
    public static function insertIgnore(array $data)
    {
        if (!self::isMySql()) return 0;  // or throw new \Exception('only supported in MySql');

        if (empty($data)) {
            return false;
        }

        $sql = self::buildInsertOnDuplicateSql($data, true);
        $bindings = array_values($data);
        return DB::affectingStatement($sql, $bindings);
    }

    /**
     * Insert using mysql INSERT IGNORE INTO.
     *
     * @param array $data
     *
     * @return int
     */
    public static function insertOnDuplicate(array $data)
    {
        if (!self::isMySql()) return 0;  // or throw new \Exception('only supported in MySql');

        if (empty($data)) {
            return 0;
        }

        $sql = self::buildInsertOnDuplicateSql($data, false);

        $bindings = array_merge(array_values($data),array_values($data));
        return DB::affectingStatement($sql, $bindings);
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