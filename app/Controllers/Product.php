<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ProductService;
use App\Models\CategoryModel;

class Product extends BaseController
{
    protected ProductService $productService;
    protected CategoryModel  $categoryModel;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->categoryModel  = new CategoryModel();
    }

    public function index()
    {
        return view('product/index', [
            'title'    => 'Data Produk',
            'products' => $this->productService->getAll(),
        ]);
    }

    public function create()
    {
        return view('product/form', [
            'title'      => 'Tambah Produk',
            'product'    => null,
            'categories' => $this->categoryModel->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'code'        => 'required|is_unique[products.code]',
            'price'       => 'required|numeric|greater_than_equal_to[0]',
            'cost_price'  => 'permit_empty|numeric|greater_than_equal_to[0]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'unit'        => 'required|max_length[30]',
            'category_id' => 'permit_empty|integer',
            'image'       => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'code'        => $this->request->getPost('code'),
            'price'       => $this->request->getPost('price'),
            'cost_price'  => $this->request->getPost('cost_price') ?: 0,
            'stock'       => $this->request->getPost('stock'),
            'unit'        => $this->request->getPost('unit'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'description' => $this->request->getPost('description'),
            'is_active'   => 1,
        ];

        $imageFile = $this->request->getFile('image');

        if (! $this->productService->create($data, $imageFile)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->productService->getValidationErrors());
        }

        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $product = $this->productService->findById((int) $id);

        if (! $product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        return view('product/form', [
            'title'      => 'Edit Produk',
            'product'    => $product,
            'categories' => $this->categoryModel->findAll(),
        ]);
    }

    public function update($id = null)
    {
        $product = $this->productService->findById((int) $id);

        if (! $product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'code'        => "required|is_unique[products.code,id,{$id}]",
            'price'       => 'required|numeric|greater_than_equal_to[0]',
            'cost_price'  => 'permit_empty|numeric|greater_than_equal_to[0]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'unit'        => 'required|max_length[30]',
            'category_id' => 'permit_empty|integer',
            'image'       => 'permit_empty|max_size[image,2048]|is_image[image]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'code'        => $this->request->getPost('code'),
            'price'       => $this->request->getPost('price'),
            'cost_price'  => $this->request->getPost('cost_price') ?: 0,
            'stock'       => $this->request->getPost('stock'),
            'unit'        => $this->request->getPost('unit'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'description' => $this->request->getPost('description'),
            'is_active'   => $this->request->getPost('is_active') ?? 1,
        ];

        $imageFile = $this->request->getFile('image');

        if (! $this->productService->update((int) $id, $data, $imageFile)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->productService->getValidationErrors());
        }

        return redirect()->to('/products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $product = $this->productService->findById((int) $id);

        if (! $product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        $this->productService->delete((int) $id);

        return redirect()->to('/products')->with('success', 'Produk berhasil dihapus.');
    }
}
