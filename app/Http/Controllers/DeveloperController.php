<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * Show the Developer index page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('developers.index');
    }

    /**
     * Show the Developer Documents page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function documents()
    {
        $templates = Template::all();

        return view('developers.documents.index', ['templates' => $templates]);
    }

    /**
     * Show the Developer Images page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function images()
    {
        return view('developers.images.index');
    }

    /**
     * Show the Developer Account page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account()
    {
        return view('developers.account.index');
    }
}
