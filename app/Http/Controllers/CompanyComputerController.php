<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyComputerRequest;
use App\Models\BookingDetail;
use App\Models\Category;
use App\Models\ComputerCompany;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyComputerController extends Controller
{

    public function index(Request $request)
    {

        $CompanyComputer = ComputerCompany::orderBy('id', 'desc')->paginate(10);
        return view('admin.CompanyComputer.index', compact('CompanyComputer'));
    }

    public function remove($id)
    {
        $CompanyComputer = ComputerCompany::find($id);
        $products = Product::where('CompanyComputer_id', '=', $id)->first();
        if (!empty($CompanyComputer)) {
            if (empty($products)) {
                ComputerCompany::where('id', $id)->delete();
                return redirect(route('CompanyComputer.index'))->with('success', 'Xóa thành công');
            } else {
                return redirect(route('CompanyComputer.index'))->with('error', 'Bạn không thể xóa khi đang còn sản phẩm');
            }
        } else {
            return redirect(route('CompanyComputer.index'))->with('error', 'Không tìm thấy danh mục');
        }
    }
    public function addForm()
    {

        $CompanyComputer = ComputerCompany::all();
        return view('admin.CompanyComputer.add', compact('CompanyComputer'));
    }
    public function saveAdd(CompanyComputerRequest $request)
    {
        $model = new ComputerCompany();
        if ($request->hasFile('anh')) {
            $imgPath = $request->file('anh')->store('products');
            $imgPath = str_replace('public/', 'storage/', $imgPath);
            $request->merge(['logo'=>$imgPath]);
        }
        $model->company_name = $request->company_name;
        $model->logo = $request->logo;
        // dd($model);
        $model->save();
        return redirect(route('CompanyComputer.index'))->with('success', 'Thêm thành công');
    }

    public function editForm($id)
    {
        $CompanyComputer = ComputerCompany::find($id);
        if (empty($CompanyComputer)) {
            return redirect(route('CompanyComputer.index'))->with('error', 'Không tìm thấy danh mục');
        }
        return view(
            'admin.CompanyComputer.edit',
            compact('CompanyComputer')
        );
    }
    public function saveEdit(CompanyComputerRequest $request, $id)
    {
        $model = ComputerCompany::find($id);
        if ($request->hasFile('anh')) {
            $imgPath = $request->file('anh')->store('products');
            $imgPath = str_replace('public/', 'storage/', $imgPath);
            $request->merge(['logo'=>$imgPath]);
        }
        $model->company_name = $request->company_name;
        $model->logo = $request->logo;
        $model->save();
        return redirect(route('CompanyComputer.index'))->with('success', 'Sửa thành công');
    }
    
}
