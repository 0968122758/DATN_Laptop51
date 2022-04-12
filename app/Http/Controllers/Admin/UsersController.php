<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\StatusCode;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Validator;
use Hash;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;
use DB;


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
    public function create(){
        return view('admin.user.create');
    }
    public function SaveCreate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'avatar' => 'required',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:30',
        ]
    );
        if ($validator->fails()) {
            $message = array_combine($validator->errors()->keys(), $validator->errors()->all());
            return response()->json(["message_validate" => $message], StatusCode::BAD_REQUEST);
        }
        DB::beginTransaction();
       try{
        Log::info($request->all());
        $user = new User();
        if($request->hasFile('avatar')){
            $file_name = time().'_'.$request->avatar->getClientOriginalName();
            $file_path = $request->file('avatar')->storeAs('uploads', $file_name, 'public');
            $user->avatar = $file_name;
        }
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->birthdate = $request->birthdate;
        $user->phone = $request->phone;
        $user->save();
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ];
        Mail::to($data['email'])
        ->queue(new Welcome($data));
        DB::commit();
        return response()->json(StatusCode::OK);
       }
           catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
           }
    }
    // public function sendMail(Request $request){
    //      $data = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ];
    //     Mail::send('mail',$data, function($message) use ($data){
    //         $message->to($data['email'])->subject('Wellcome to "Review appartment"');
    //         $message->from('osincun0308@gmail.com', 'Trương Tuấn');
    //     });
    //     return response()->json(['success'=>true]);
    // }
    public function unique(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user){
            if($user->id == $request->id){
                return response()->json(['result' => true]);
            }else{
                return response()->json(['result' => false]);
            }
        }else{
            return response()->json(['result' => true]);
        }

    }
    public function edit($id){
        $user = User::find($id);
        return view('admin.user.edit', ['user' => $user,]);
    }
    public function SaveEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            // 'avatar' => 'required',
            'email' => ['required', 'max:255',  Rule::unique('users')->where(function ($query) use($request) {
                return $query->where('id', '!=', $request->id)->whereNull('deleted_at');
            })]
        ]
    );
        if ($validator->fails()) {
            $message = array_combine($validator->errors()->keys(), $validator->errors()->all());
            return response()->json(["message_validate" => $message], StatusCode::BAD_REQUEST);
        }
        DB::beginTransaction();
        try{
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
            DB::commit();
            $user->update();
            return response()->json(StatusCode::OK);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
       
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
