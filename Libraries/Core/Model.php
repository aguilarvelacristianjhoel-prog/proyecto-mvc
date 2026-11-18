<?php

/**
 * Modelo base utilizado en clase.
 * Es una capa de acceso a datos construida sobre PDO con métodos tipo ORM.
 */
class Model extends Conexion
{
    protected $table;
    protected $primaryKey = 'id';
    protected $select = '*';
    protected $joins = [];
    protected $whereBuilder = [];
    protected $orderBy = '';
    protected $limit = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert($data)
    {
        if (empty($data)) {
            return false;
        }

        $columns = array_keys($data);
        $columnList = '`' . implode('`, `', $columns) . '`';
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $sql = "INSERT INTO {$this->table} ({$columnList}) VALUES ({$placeholders})";
        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute(array_values($data));
    }

    public function update($id, $data)
    {
        if (empty($data)) {
            return false;
        }

        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "`{$key}` = :{$key}";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $setClause)
            . " WHERE {$this->primaryKey} = :id";
        $stmt = $this->connect()->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function select($fields)
    {
        $this->select = $fields;
        return $this;
    }

    // Las condiciones se reciben como expresiones SQL, igual que en el material de clase.
    // No concatenes aquí datos ingresados por usuarios; utiliza parámetros preparados.
    public function where($conditions)
    {
        foreach ((array) $conditions as $condition) {
            $this->whereBuilder[] = $condition;
        }
        return $this;
    }

    public function orderBy($field, $direction = 'ASC')
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'ASC';
        }

        $this->orderBy = "ORDER BY {$field} {$direction}";
        return $this;
    }

    public function limit($limit)
    {
        $limit = max(0, (int) $limit);
        $this->limit = "LIMIT {$limit}";
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if (!empty($this->whereBuilder)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereBuilder);
        }
        if ($this->orderBy !== '') {
            $sql .= ' ' . $this->orderBy;
        }
        if ($this->limit !== '') {
            $sql .= ' ' . $this->limit;
        }

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->resetQuery();

        return $result;
    }

    public function first()
    {
        $this->limit(1);
        $result = $this->get();
        return $result[0] ?? null;
    }

    private function resetQuery()
    {
        $this->select = '*';
        $this->joins = [];
        $this->whereBuilder = [];
        $this->orderBy = '';
        $this->limit = '';
    }
}
