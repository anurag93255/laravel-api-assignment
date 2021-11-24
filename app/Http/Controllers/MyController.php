<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{
    function show($id=0) {
        $start = (!empty($id)? $id * 10 : 0);

        $path = storage_path() . "/app/public/data.json";
        $json = json_decode(file_get_contents($path), true); 
        $res_arr = [];
        
        $sub_arr = array_slice($json, $start, 10);
        // return $sub_arr;
        $ids = $open = [];
        $closed = 0;
        foreach($sub_arr as $value) {
           $ids[] = $value['id'];
           if($value['disposition'] == 'open') {
               $open[] = $value;
           } elseif($value['disposition'] == 'closed') {
                ++$closed;
           }
        }
        $res_arr = [
            'Ids' => $ids, 
            'Open' => $open, 
            'ClosedCount' => $closed, 
            'PreviousPage' => (!empty($start) ? $id - 1 : null),
            'NextPage' => (count($json) <= $start ? null : ($id + 1))
        ];
        return (object) $res_arr;
    } 
}
