<?php
namespace App\Http\Controllers\Admin;
use App\Enums\StatusCode;
use App\Enums\UploadFilePath;
use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Exception;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = ['Admins'];
        return view('admin.admins.index', ['breadcrumbs' => $breadcrumbs,]);
    }

    public function getData(Request $request)
    {
        try {
            $data = Admins::where(function ($q) use($request) {
                if ($request->email) {
                    $q->where('email', 'like', '%' . $request->email . '%');
                }
            })->orderByDesc('updated_at')->paginate(10);
            
            return response()->json($data, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function deleteAll(Request $request)
    {
        try {
            Admins::whereIn('id', $request)->delete();
            return response()->json(['status' => true], StatusCode::OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }
    public function deleteItem($id){
        $record = Admins::find($id)->delete();
        return response()->json(['status' => true], StatusCode::OK);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = ['Create Admins'];
        return view('admin.admins.create', ['breadcrumbs' => $breadcrumbs]);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|max:255',
            'rule' => 'required|max:1|alpha_num',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), StatusCode::BAD_REQUEST);
        }
        try {
            $admins = new Admins();
            $admins->fill($request->all());
            $admins->password = Hash::make($request->password);
            $admins->save();
            return response()->json(["status" => true], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function checkUniqueEmail(Request $request)
    {
        $valid = !Admins::where(function ($query) use ($request) {
            if (isset($request['id'])) {
                $query->where('id', '!=', $request["id"]);
            }
            $query->where('email', $request["value"]);
        })->exists();
        return response()->json([
            'valid' => $valid,
        ], StatusCode::OK);
    }
}
