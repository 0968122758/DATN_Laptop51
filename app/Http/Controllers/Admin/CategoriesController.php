<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Enums\UploadFilePath;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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

    public function getData()
    {
        try {
            $data = Category::orderByDesc('updated_at')->paginate(10);
            return response()->json($data, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
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



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = ['Create Categories'];
        return view('admin.category.create', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), StatusCode::BAD_REQUEST);
        }
        try {
            $category = new Category();
            $category->name = $request->name;
            $category->overview = $request->overview;
            $category->views = 0;
            if ($request->icon && $request->icon != null) {
                $imageName = time() . '.' . $request->icon->extension();
                $request->icon->move(public_path(UploadFilePath::CATEGORY . '/' . $category->id), $imageName);
                $category->icon = url(UploadFilePath::CATEGORY . '/' . $category->id . '/' . $imageName);
                $category->save();
            }
            $category->save();
            return response()->json(["status" => true], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
