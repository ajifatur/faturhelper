<?php

namespace Ajifatur\FaturHelper\Http\Controllers\API;

use Illuminate\Http\Request;
use Ajifatur\FaturHelper\Models\Visitor;

class VisitorController extends \App\Http\Controllers\Controller
{
    /**
     * Get visitor label and data.
     * 
     * @param  string $field
     * @param  string $category
     * @return array
     */
    function getVisitorLabelAndData($field, $category)
    {
        $data = [];
        $array = [];

        // Get visitors
        $visitors = Visitor::has('user')->get();

        // Loop visitors
        foreach($visitors as $visitor) {
            // Decode the visitor content
            $decode = json_decode($visitor->{$field}, true);

            // Push to array
            if(is_array($decode))
                array_push($array, $decode[$category]);
        }

        // Loop array
        foreach(array_count_values($array) as $key=>$value) {
            // Push to data
            $data[] = [
                'name' => $key,
                'y' => $value
            ];
        }

        return $data;
    }

    /**
     * Get visitor device type.
     * 
     * @return \Illuminate\Http\Response
     */
    public function deviceType()
    {
        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $this->getVisitorLabelAndData('device', 'type')
        ], 200);
    }

    /**
     * Get visitor device family.
     * 
     * @return \Illuminate\Http\Response
     */
    public function deviceFamily()
    {
        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $this->getVisitorLabelAndData('device', 'family')
        ], 200);
    }

    /**
     * Get visitor browser.
     * 
     * @return \Illuminate\Http\Response
     */
    public function browser()
    {
        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $this->getVisitorLabelAndData('browser', 'family')
        ], 200);
    }

    /**
     * Get visitor platform.
     * 
     * @return \Illuminate\Http\Response
     */
    public function platform()
    {
        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $this->getVisitorLabelAndData('platform', 'family')
        ], 200);
    }
}
