<?php

namespace Ajifatur\FaturHelper\Http\Controllers\API;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Ajifatur\FaturHelper\Models\Visitor;

class VisitorLocationController extends \App\Http\Controllers\Controller
{
    /**
     * Get visitor label and data.
     * 
     * @param  string $category
     * @return array
     */
    function getVisitorLabelAndData($category)
    {
        $locations = []; $data = [];

        // Get known visitors
        $knownVisitors = Visitor::has('user')->where('location','!=',null)->where('location','!=','')->pluck('location');
        if(count($knownVisitors)) {
            foreach($knownVisitors as $visitor) {
                $visitor = json_decode($visitor, true);
                if(array_key_exists($category, $visitor)) {
                    if($visitor[$category] != null) array_push($locations, $visitor[$category]);
                }
            }
        }

        // Get unknown visitors
        $unknownVisitors = Visitor::has('user')->where('location','=',null)->orWhere('location','=','')->count();

        // Array count values
        $locations = array_count_values($locations);

        // Push
        $locations['Tidak Diketahui'] = $unknownVisitors;

        // Sort Array
        arsort($locations);

        // Loop locations
        foreach($locations as $key=>$value) {
            // Push to data
            $data[] = [
                'name' => $key,
                'y' => $value
            ];
        }

        return $data;
    }

    /**
     * Get visitor city location.
     * 
     * @return \Illuminate\Http\Response
     */
    public function city()
    {
        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $this->getVisitorLabelAndData('cityName')
        ], 200);
    }

    /**
     * Get visitor region location.
     * 
     * @return \Illuminate\Http\Response
     */
    public function region()
    {
        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $this->getVisitorLabelAndData('regionName')
        ], 200);
    }

    /**
     * Get visitor country location.
     * 
     * @return \Illuminate\Http\Response
     */
    public function country()
    {
        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $this->getVisitorLabelAndData('countryName')
        ], 200);
    }
}
