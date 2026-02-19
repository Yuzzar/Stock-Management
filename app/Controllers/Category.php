<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CategoryService;

class Category extends BaseController
{
    protected CategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    public function index()
    {
        return view('category/index', [
            'title'      => 'Data Kategori',
            'categories' => $this->categoryService->getAll(),
        ]);
    }

    public function create()
    {
        return view('category/form', [
            'title'    => 'Tambah Kategori',
            'category' => null,
        ]);
    }

    public function store()
    {
        $rules = [
            'name'        => 'required|min_length[2]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if (! $this->categoryService->create($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->categoryService->getValidationErrors());
        }

        return redirect()->to('/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $category = $this->categoryService->findById((int) $id);

        if (! $category) {
            return redirect()->to('/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('category/form', [
            'title'    => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update($id = null)
    {
        $category = $this->categoryService->findById((int) $id);

        if (! $category) {
            return redirect()->to('/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        $rules = [
            'name'        => 'required|min_length[2]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if (! $this->categoryService->update((int) $id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->categoryService->getValidationErrors());
        }

        return redirect()->to('/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $category = $this->categoryService->findById((int) $id);

        if (! $category) {
            return redirect()->to('/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        $this->categoryService->delete((int) $id);

        return redirect()->to('/categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
