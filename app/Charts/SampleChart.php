<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SampleChart extends BaseChart
{
    /**
     * Determines the chart name to be used on the
     * route. If null, the name will be a snake_case
     * version of the class name.
     */
    public ?string $name = 'SampleChart';

    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directrive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'SampleChart';


    /**
     * Determines the middlewares that will be applied
     * to the chart endpoint.
     */
    public ?array $middlewares = ['auth'];

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */


    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     * @param Request $request
     * @return Chartisan
     */
    public function handler(Request $request): Chartisan
    {
        dd($request);
        $eventos = DB::table('events_activities')
            ->where('created_by', '=', Auth::user()->id)
            ->where('type', '=', 1)
            ->where('nit', '=', $request->client)
            ->where('start','>=', $request->start)
            ->where('end', '<=', $request->end)
            ->count();

        $actividades = DB::table('events_activities')
            ->where('created_by', '=', Auth::user()->id)
            ->where('type', '=', 0)
            ->where('nit', '=', $request->client)
            ->where('start','>=', $request->start)
            ->where('end', '<=', $request->end)
            ->count();

        return Chartisan::build()
            ->labels(['Eventos', 'Actividades'])
            ->dataset('Eventos', [$eventos])
            ->dataset('SActividades', [$actividades]);
    }
}
