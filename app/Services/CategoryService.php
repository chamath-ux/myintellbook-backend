<?php

namespace App\Services;
use App\Models\Category;
use App\Models\Profession;


class CategoryService{

    public function getCategories(){
        try{
            $categories = Category::all();
            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => $categories->toArray(),
            ], 200);
        }catch(\Exception $e){ 
            log::error('CategoryService @getCategories: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'category not found',
            ], 500);
        }
        
    }

    public function getProfessions($category_id){
        try{
            $professions = Profession::where('category_id', $category_id)->get();
            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => $professions->toArray(),
            ], 200);
        }catch(\Exception $e){ 
            log::error('CategoryService @getProfessions: '.$e->getMessage());
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'category not found',
            ], 500);
        }
        
    }
}