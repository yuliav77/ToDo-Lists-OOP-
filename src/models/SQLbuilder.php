<?php

namespace src\models;

class SQLbuilder
{
    private $tableName;
    protected $query;

    protected function reset(): void
    {
        $this->query = new \stdClass();
    }

    /** Set table name for query  */

    public function setTableName($tableName): SQLbuilder
    {
        $this->tableName = $tableName;

        return $this;
    }

    /** Build SELECT-query  */

    public function select(array $fields): SQLbuilder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $this->tableName;
        $this->query->type = 'select';

        return $this;
    }

    /** Build INSERT-query  */

    public function insert(array $fields, array $values): SQLbuilder
    {
        if (count($fields)!=count($values)) {
            throw new \Exception("Count of fields should equal count of values!");
        }
        $values = array_map(function($value){ return '"' . $value . '"'; }, $values);
        $this->reset();
        $this->query->base = "INSERT INTO " . $this->tableName . " (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")" ;
        $this->query->type = 'insert';

        return $this;
    }

    /** Build DELETE-query  */

    public function delete(): SQLbuilder
    {
        $this->reset();
        $this->query->base = "DELETE FROM " . $this->tableName;
        $this->query->type = 'delete';

        return $this;
    }

    /** Build UPDATE-query  */

    public function update(string $field, $value): SQLbuilder
    {
        $this->reset();
        $this->query->base = "UPDATE " . $this->tableName . " SET ". $field . " = " . $value;
        $this->query->type = 'update';

        return $this;
    }

    /** Build WHERE-expression */

    public function where(string $field, string $value, string $operator = '='): SQLBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    /** Get result SQL-string */

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        $sql .= ";";

        return $sql;
    }

    /** Execute SQL-query */

    public function execute($conn)
    {
        $sth = $conn->prepare($this->getSQL());
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        if ($sth->execute()) {
            if ( $this->query->type == "insert") {
                return $conn->lastInsertId();
            } elseif ($this->query->type == "select") {
                return $sth->fetchAll();
            } elseif (($this->query->type == "delete") || ($this->query->type == "update")) {
                return true;
            }
        } else {
            return false;
        }
    }

}