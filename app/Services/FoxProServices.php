<?php

namespace App\Services;

use App\Interfaces\FoxProRepositoryInterface;

class FoxProServices
{
    protected FoxProRepositoryInterface $foxProRepository;

    public function __construct(FoxProRepositoryInterface $foxProRepository)
    {
        $this->foxProRepository = $foxProRepository;
    }

    public function select(string $query)
    {
        return $this->foxProRepository->select($query);
    }
    public function insert(string $table, array $fields, array $values): array
    {
        return $this->foxProRepository->insert($table, $fields, $values);
    }
    public function update(string $table, array $fields, array $values, string $condition): array
    {
        return $this->foxProRepository->update($table, $fields, $values, $condition);
    }
    public function delete(string $table, string $condition = null): array
    {
        return $this->foxProRepository->delete($table, $condition);
    }
    public function syncAllFoxProToMySQL(string $foxTable): array{
        return $this->foxProRepository->syncAllFoxProToMySQL($foxTable);
    }
    public function historiaUrgencias(string $documento, string $mes, string $año)
    {
        return $this->foxProRepository->historiaUrgencias($documento, $mes, $año);
    }


}
