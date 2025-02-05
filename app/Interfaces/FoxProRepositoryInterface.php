<?php

namespace App\Interfaces;

interface FoxProRepositoryInterface
{
    public function select(string $query);
    public function insert(string $table, array $fields, array $values): array;
    public function update(string $table, array $fields, array $values, string $condition): array;
    public function delete(string $query);
    public function isDate($value): bool;
    public function syncAllFoxProToMySQL(string $foxTable): array;
    public function historiaUrgencias(string $documento, string $mes, string $año);
    public function historiaClinica(string $documento, string $mes, string $año);

}
