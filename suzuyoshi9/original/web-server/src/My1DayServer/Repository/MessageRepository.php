<?php

namespace My1DayServer\Repository;

class MessageRepository
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllMessages()
    {
        $builder = $this->conn->createQueryBuilder();
        $builder
            ->select('m.*')
            ->from('vg_message', 'm')
        ;

        return $this->conn->fetchAll((string)$builder);
    }

    public function getMessage($id)
    {
        $builder = $this->conn->createQueryBuilder();
        $builder
            ->select('m.*')
            ->from('vg_message', 'm')
            ->where('id = ?')
        ;

        return $this->conn->fetchAssoc((string)$builder, [$id]);
    }

    public function createMessage($data)
    {
        $datetime = \date_create(null, new \DateTimeZone('UTC'))->format('Y-m-d H:i:s');

        $data = array_merge($data, [
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ]);

        $queryResult = $this->conn->insert('vg_message', $data);
        if (!$queryResult) {
            return false;
        }

        return $this->conn->lastInsertId();
    }
}
