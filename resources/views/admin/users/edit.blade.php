@extends('admin.layouts.main')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

<div class="container">
    <h5 class="alert alert-danger  text-center">EDIT USER</h5>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Avatar</label>
                    <input type="file" name="avatar" value="{{$user->avatar}}" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Phone Number</label>
                    <input type="number" name="phone" value="{{$user->phone}}" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="address" value="{{$user->address}}" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <input type="text" name="description" value="{{$user->description}}" class="form-control"
                        placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Role</label>
                    <select name="role_id" class="form-control select2_init">
                        @foreach($roles as $roleItem)
                        <option value="{{$roleItem->id}}">{{$roleItem->name}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <br>
                <ahref="{{route('user.index')}}" class="btn btn-danger">Hủy</ahref=>
                    &nbsp;
                    <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </form>
</div>
@endsection