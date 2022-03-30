<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\StatusCode;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Exception;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = ['Users'];
        return view('admin.user.index', ['breadcrumbs' => $breadcrumbs,]);
    }
    public function edit($id){
        $user = User::find($id);
        return response()->json($user);
    }
    public function saveEdit(Request $request){
        // dd($request->all());
        $user = User::find($request->id);
        if($request->hasFile('avatar')){
            $file_name = time().'_'.$request->avatar->getClientOriginalName();
            $file_path = $request->file('avatar')->storeAs('uploads', $file_name, 'public');
            $user->avatar = $file_name;
        }
        $user->email = $request->email;
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->birthdate = $request->birthdate;
        $user->update();
        return response()->json(StatusCode::OK);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        try {
            $data = User::where(function ($datasearch) use($request) {
                if ($request->name) {
                    $datasearch->where('name', 'like', '%' . $request->name . '%');
                }
            })->orderByDesc('updated_at')->paginate(10);
            
            return response()->json($data, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        try {
            Log::info($request->all());
            User::whereIn('id', $request)->delete();
            return response()->json(['status' => true], StatusCode::OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function delete_record($id){
        $record = User::find($id)->delete();
        return 'ok';
    }

    public function postSearch(Request $request)
    {
    	$search = $request->name;
    	$dataName = User::where('name', 'LIKE', "%$search%")->get();
    	return $dataName;
    }
}
