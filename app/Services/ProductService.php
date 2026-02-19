<?php

namespace App\Services;

use App\Models\ProductModel;

class ProductService
{
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function getAll(): array
    {
        return $this->productModel->getWithCategory();
    }

    public function findById(int $id): ?array
    {
        return $this->productModel->find($id);
    }

    public function create(array $data, $imageFile = null): bool
    {
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $newName         = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/products', $newName);
            $data['image'] = 'uploads/products/' . $newName;
        }

        return (bool) $this->productModel->insert($data);
    }

    public function update(int $id, array $data, $imageFile = null): bool
    {
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $product = $this->productModel->find($id);
            if ($product && $product['image'] && file_exists(FCPATH . $product['image'])) {
                unlink(FCPATH . $product['image']);
            }

            $newName         = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/products', $newName);
            $data['image'] = 'uploads/products/' . $newName;
        }

        return (bool) $this->productModel->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $product = $this->productModel->find($id);
        if ($product && $product['image'] && file_exists(FCPATH . $product['image'])) {
            unlink(FCPATH . $product['image']);
        }

        return (bool) $this->productModel->delete($id);
    }

    public function getValidationErrors(): array
    {
        return $this->productModel->errors();
    }
}
