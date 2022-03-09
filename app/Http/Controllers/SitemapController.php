<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use Carbon\Carbon;

class SitemapController extends Controller
{

    public function index(Request $request)
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function page(Request $request)
    {
        $contents = Content::select('updated_at', 'slug')->whereIn('slug', [
            'how-it-works',
            'faq',
            'money-back-guarantee',
            'privacy-policy',
            'revision-policy',
            'disclaimer',
            'terms-and-conditions'
        ])->pluck('updated_at', 'slug');

        $homepage_last_updated_at = settings('homepage_last_updated_at');

        if ($homepage_last_updated_at) {
            $homepage_last_updated_at = Carbon::createFromDate($homepage_last_updated_at);
        }

        $data['routes'] = [

            'homepage' => $homepage_last_updated_at,
            'pricing' => NULL,
            'contact' => NULL,
            'instant_quote' => NULL,
            'how_it_works' => optional($contents)['how-it-works'],
            'faq' => optional($contents)['faq'],
            'money_back_guarantee' => optional($contents)['money-back-guarantee'],
            'privacy_policy' => optional($contents)['privacy-policy'],
            'revision_policy' => optional($contents)['revision-policy'],
            'disclaimer' => optional($contents)['disclaimer'],
            'terms_and_conditions' => optional($contents)['terms-and-conditions']
        ];

        return response()->view('sitemap.page', compact('data'))->header('Content-Type', 'text/xml');
    }
}
