<?php

namespace App\Services;

use App\Models\CategoryModel;

class CategoryService
{
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function getAll(): array
    {
        return $this->categoryModel->getWithProductCount();
    }

    public function findById(int $id): ?array
    {
        return $this->categoryModel->find($id);
    }

    public function create(array $data): bool
    {
        return (bool) $this->categoryModel->insert($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) $this->categoryModel->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return (bool) $this->categoryModel->delete($id);
    }

    public function getValidationErrors(): array
    {
        return $this->categoryModel->errors();
    }
}
