<?php

namespace App\Http\Controllers;

use App\Models\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class NewsController extends Controller
{
    // rules for validation
    protected $rules = [
        'title' => 'required',
        'author' => 'required',
        'description' => 'required',
        'content' => 'required',
        'url' => 'required',
        'url_image' => '',
        'published_at' => '',
        'category' => 'required',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // order by recent news
        $news = News::orderBy('created_at', 'desc')->get();

        // data for response
        $data = [
            'message' => 'get all news',
            'result' => $news,
            'total' => $news->count(),
        ];

        return response()->json(data: $data, status: 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // set published_at to current date time
        $current_time = Date::now()->format('Y-m-d H:i:s');
        $request['published_at'] = $current_time;

        // validate request data
        $validatedData = $request->validate($this->rules);

        try {
            $news = News::create($validatedData);
            $data = [
                'message' => 'news successfully created',
                'result' => $news,
            ];
            return response()->json(data: $data, status: 200);
        } catch (Exception $e) {
            $error_message = $e->getMessage();

            $data = [
                'message' => $error_message,
            ];

            return response()->json(data: $data, status: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        // clone old news
        $old_news = clone $news;

        if ($news) {
            // validate request data
            $validatedData = $request->validate([
                'title' => 'string',
                'author' => 'string',
                'description' => 'string',
                'content' => 'string',
                'url' => 'string',
                'url_image' => 'string',
                'published_at' => '',
                'category' => 'string',
            ]);

            $news->update($validatedData);


            $data = [
                'message' => 'news successfully updated',
                'old news' => $old_news,
                'new news' => $news
            ];
            return response()->json(data: $data, status: 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // get news by id
        $news = News::find($id);
        if ($news) {
            return response()->json(['message' => 'news has been successfully deleted'], 200);
        } else {
            return response()->json(['message' => 'news cannot be found'], 500);
        }
    }

    public function search(string $title)
    {
        // search by title
        $searchTerm = $title;

        $news = News::where('title', 'like', "%{$searchTerm}%")->get();

        // Check if any records were found
        if ($news->isNotEmpty()) {
            // data for response
            $data = [
                'message' => 'found news',
                'result' => $news,
                'total' => $news->count(),
            ];

            return response()->json(data: $data, status: 200);
        } else {
            // data for response
            $data = [
                'message' => 'no matching records found',
                'result' => $news,
                'total' => $news->count(),
            ];

            return response()->json(data: $data, status: 200);
        }

    }

    // shows sport category news
    public function sport()
    {
        $news = News::where('category', '=', 'sport')->get();
        return $news;
    }

    // shows finance category news
    public function finance()
    {
        $news = News::where('category', '=', 'finance')->get();
        return $news;
    }

    // shows automotive category news
    public function automotive()
    {
        $news = News::where('category', '=', 'automotive')->get();
        return $news;
    }
}
