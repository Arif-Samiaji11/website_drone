<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;

class BlogController extends Controller
{
    public function index()
    {
        $posts = NewsItem::query()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }
}
