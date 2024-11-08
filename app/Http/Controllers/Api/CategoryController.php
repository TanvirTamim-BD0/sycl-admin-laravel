<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MiddleCategory;

class CategoryController extends Controller
{
    
    //get all category data...........
    public function GetAllCategory()
    {
        $categoryData = Category::orderBy('id','desc')->get();

        if(!empty($categoryData)){
            return response()->json([
                'message'   =>  'success',
                'categoryData'   =>  $categoryData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }
    }


    //get category wise middle category & subcategory data...........
    public function getCateWiseMiddlecateAndSubCate($id){

        $middleCategoryData = MiddleCategory::where('category_id',$id)->with('subCategoryData')->get();

        if(!empty($middleCategoryData)){
            return response()->json([
                'message'   =>  'success',
                'middleCategoryData'   =>  $middleCategoryData,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }

    }

}
