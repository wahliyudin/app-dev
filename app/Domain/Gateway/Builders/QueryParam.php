<?php

namespace App\Domain\Gateway\Builders;

trait QueryParam
{
    protected $query = [];

    protected $where = [];

    public function addQuery($query = null)
    {
        $this->query = array_merge($this->query, $query);
        return $this;
    }

    public function select($select)
    {
        $this->addQuery(['select' => $select]);
        return $this;
    }

    public function with($with)
    {
        $this->addQuery(['with' => $with]);
        return $this;
    }

    public function whereIn($field, array $values)
    {
        $this->addQuery([$field => $values]);
        return $this;
    }

    public function where($column, $operator = null, $value = null)
    {
        if (!$value && $operator) {
            $value = $operator;
            $operator = '=';
        }
        array_push($this->where, ['column' => $column, 'operator' => $operator, 'value' => $value]);
        return $this;
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        if (!$value && $operator) {
            $value = $operator;
            $operator = '=';
        }
        array_push($this->where, ['column' => $column, 'operator' => $operator, 'value' => $value, 'boolean' => 'or']);
        return $this;
    }

    public function buildQuery()
    {
        $query = array_merge($this->query, ['where' => $this->where]);
        $this->query = [];
        $this->where = [];
        return $query;
    }
}
