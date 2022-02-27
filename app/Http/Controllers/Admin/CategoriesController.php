<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = ['Category'];
        return view('admin.category.index', ['breadcrumbs' => $breadcrumbs,]);
    }

    public function getData(Request $request)
    {
        try {
            $data = Category::orderByDesc('updated_at')->paginate(10);
            return response()->json($data, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function deleteAll(Request $request)
    {
        try {
            Category::whereIn('id', $request)->delete();
            return response()->json(['status' => true], StatusCode::OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }
}
