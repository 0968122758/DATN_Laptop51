<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Exception;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $breadcrumbs = ['Review'];
        return view('admin.review.index', ['breadcrumbs' => $breadcrumbs,]);
    }
    public function getData()
    {
        try {
            $data = Review::orderByDesc('updated_at')->paginate(10);
            return response()->json($data, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function deleteAll(Request $request)
    {
        try {
            Review::whereIn('id', $request)->delete();
            Review::whereIn('id', $request->id)->delete();
            return response()->json(['status' => true], StatusCode::OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }
    public function deleteItem(Request $request) {
        try {
            Review::whereIn('id', [$request->id])->delete();
        return response()->json(['status' => true], StatusCode::OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
        }

    
}
