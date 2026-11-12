<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Pastikan hanya CC Room yang dapat mengelola kategori.
     */
    private function authorizeCCRoom(): void
    {
        abort_unless(
            Auth::check() &&
            Auth::user()->role === 'cc_room',
            403,
            'Hanya CC Room yang dapat mengelola kategori.'
        );
    }

    /**
     * Daftar kategori.
     */
    public function index()
    {
        $this->authorizeCCRoom();

        $categories = Category::with('division')
            ->orderBy('division_id')
            ->orderBy('name')
            ->paginate(10);

        return view(
            'categories.index',
            compact('categories')
        );
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        $this->authorizeCCRoom();

        $divisions = Division::orderBy('name')->get();

        return view(
            'categories.create',
            compact('divisions')
        );
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $this->authorizeCCRoom();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
        ]);

        Category::create([
            'name' => $validated['name'],
            'division_id' => $validated['division_id'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit kategori.
     */
    public function edit(Category $category)
    {
        $this->authorizeCCRoom();

        $divisions = Division::orderBy('name')->get();

        return view(
            'categories.edit',
            compact('category', 'divisions')
        );
    }

    /**
     * Perbarui kategori.
     */
    public function update(
        Request $request,
        Category $category
    ) {
        $this->authorizeCCRoom();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
        ]);

        $category->update([
            'name' => $validated['name'],
            'division_id' => $validated['division_id'],
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Aktifkan atau nonaktifkan kategori.
     */
    public function toggleStatus(Category $category)
    {
        $this->authorizeCCRoom();

        $category->update([
            'is_active' => !$category->is_active,
        ]);

        $message = $category->is_active
            ? 'Kategori berhasil diaktifkan.'
            : 'Kategori berhasil dinonaktifkan.';

        return redirect()
            ->route('categories.index')
            ->with('success', $message);
    }
}
