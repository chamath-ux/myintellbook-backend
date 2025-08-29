<?php

namespace App\Services;
use App\Http\Resources\ProfileResource;

class SearchService{

    public function searchKey($key)
    {

        $data = \App\Models\Profile::search($key)->get();

         return response()->json([
                'code' => 200,
                'status' => true,
                'data'=>ProfileResource::collection($data),
            ], 200);
    }
}