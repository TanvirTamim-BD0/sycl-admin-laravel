<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopBanner;
use App\Models\SquareBanner;
use App\Models\BottomBannner;
use App\Models\BannerCategory;
use Auth;

class BannerController extends Controller
{
    
     //get all category data...........
     public function GetAllBannerCategory()
     {
         $bannerCategoryData = BannerCategory::orderBy('id','desc')->get();
 
         if(!empty($bannerCategoryData)){
             return response()->json([
                 'message'   =>  'success',
                 'bannerCategoryData'   =>  $bannerCategoryData,
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Sorry you have no data.'
             ], 500);
         }
     }
 
 
     //get all category data...........
     public function GetAllTopBanner()
     {
         $topBannerData = TopBanner::orderBy('id','desc')->with('bannerCategoryData')->get();
 
         if(!empty($topBannerData)){
             return response()->json([
                 'message'   =>  'success',
                 'topBannerData'   =>  $topBannerData,
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Sorry you have no data.'
             ], 500);
         }
     }
 
 
     //get all category data...........
     public function GetAllSquareBanner()
     {
         $squareBannerData = SquareBanner::orderBy('id','desc')->with('bannerCategoryData')->get();
 
         if(!empty($squareBannerData)){
             return response()->json([
                 'message'   =>  'success',
                 'squareBannerData'   =>  $squareBannerData,
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Sorry you have no data.'
             ], 500);
         }
     }
 
 
     //get all category data...........
     public function GetAllBottomBannner()
     {
         $bottomBannnerData = BottomBannner::orderBy('id','desc')->with('bannerCategoryData')->get();
 
         if(!empty($bottomBannnerData)){
             return response()->json([
                 'message'   =>  'success',
                 'bottomBannnerData'   =>  $bottomBannnerData,
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Sorry you have no data.'
             ], 500);
         }
     }
 

     
}
