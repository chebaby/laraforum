<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth')->except(['index', 'show']);
	}

    public function index()
    {
        $threads = Thread::latest()->get();

        return view('threads.index', compact('threads'));
    }


    public function create()
    {
    	return view('threads.create');
    }


    public function store(Request $request)
    {
    	$thread = Thread::create([
			'title'   => request('title'),
			'body'    => request('body'),
			'user_id' => auth()->id()
    	]);

    	return redirect($thread->path());
    }


    public function show(Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

}
