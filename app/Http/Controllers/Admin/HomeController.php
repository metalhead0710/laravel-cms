<?php

namespace PyroMans\Http\Controllers\Admin;

use Illuminate\Http\Request;
use PyroMans\Http\Controllers\ControllerBase;
use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;


class HomeController extends ControllerBase
{
    private function getPeriod(Carbon $start, Carbon $end)
    {
        $period = Period::create($start, $end);

        return $period;
    }

    public function index(Request $request)
    {
        $dateFrom = Carbon::now()->today();
        if ($request->input('period') != null) {
            $dateFrom = Carbon::createFromFormat('d.m.Y', $request->input('period'));
            $dateFrom->endOfDay();
        }

        $dateTo = Carbon::now();
        $period = $this->getPeriod($dateFrom, $dateTo);
        /*$pageViews = Analytics::fetchTotalVisitorsAndPageViews($period);
        $topRefferers = Analytics::fetchTopReferrers($period, $maxResults = 20);

        $popPages = Analytics::fetchMostVisitedPages($period, $maxResults = 5);

        $topBrowsers = Analytics::fetchTopBrowsers($period, $maxResults = 10);
        $users = Analytics::performQuery($period,
            'ga:sessions',
            ['dimensions' => 'ga:userType']
        )->rows;
        $countries = Analytics::performQuery($period,
            'ga:sessions',
            ['dimensions' => 'ga:country', 'sort' => '-ga:sessions']
        )->rows;

        $topBrowsers = $topBrowsers->toJson();
        $pageViews = $pageViews->toJson();
        $countries = collect($countries)->toJson();
        $users = collect($users)->toJson();*/
        $popPages = null;
        $topBrowsers = null;
        $topRefferers = null;
        $pageViews = null;
        $users = null;
        $countries = null;

        return view('admin.home.index', [
            'period' => $request->input('period'),
            'popPages' => $popPages,
            'topRefferers' => $topRefferers,
            'pageViews' => $pageViews,
            'users' => $users,
            'topBrowsers' => $topBrowsers,
            'countries' => $countries,
        ]);
    }
}