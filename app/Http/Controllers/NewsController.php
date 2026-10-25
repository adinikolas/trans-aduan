<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    private function authorizeCcRoom(): void
    {
        abort_unless(Auth::user()->role === 'cc_room', 403);
    }

    public function index()
    {
        $this->authorizeCcRoom();

        $news = News::with('creator')
            ->latest()
            ->paginate(10);

        return view('news.index', compact('news'));
    }

    public function create()
    {
        $this->authorizeCcRoom();

        return view('news.create');
    }

    public function store(Request $request)
    {
        $this->authorizeCcRoom();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($validated['title']);

        if (News::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(6));
        }

        $imagePath = $request->file('image')
            ? $request->file('image')->store('news', 'public')
            : null;

        News::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'image' => $imagePath,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        $this->authorizeCcRoom();

        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $this->authorizeCcRoom();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($validated['title']);

        if (
            News::where('slug', $slug)
                ->where('id', '!=', $news->id)
                ->exists()
        ) {
            $slug .= '-' . Str::lower(Str::random(6));
        }

        $imagePath = $news->image;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('news', 'public');
        }

        $publishedAt = $validated['status'] === 'published'
            ? ($news->published_at ?? now())
            : null;

        $news->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'image' => $imagePath,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
        ]);

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        $this->authorizeCcRoom();

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()
            ->route('news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
