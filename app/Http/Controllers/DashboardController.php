<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Image;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the Dashboard page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $now = Carbon::now();

        // If the user previously selected a plan
        if (!empty($request->session()->get('plan_redirect'))) {
            return redirect()->route('checkout.index', ['id' => $request->session()->get('plan_redirect')['id'], 'interval' => $request->session()->get('plan_redirect')['interval']]);
        }

        $templates = Template::orderBy('views', 'desc')->limit(6)->get();

        $recentDocuments = Document::with('user', 'template')->where('user_id', $request->user()->id)->orderBy('id', 'desc')->limit(5)->get();
        $recentImages = Image::with('user')->where('user_id', $request->user()->id)->orderBy('id', 'desc')->limit(5)->get();

        return view('dashboard.index', ['now' => $now, 'recentDocuments' => $recentDocuments, 'recentImages' => $recentImages, 'templates' => $templates]);
    }
}
