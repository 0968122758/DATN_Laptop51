@extends('admin.layouts.main')
@section('content')
<form action="" class="row-8" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="col-4">
    <label for="">Họ Tên</label>
    <input type="text" class="form-control " value="{{ $booking->full_name}}" name="full_name" id=""
      aria-describedby="helpId" placeholder="">
    @error('full_name')
    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
    @enderror</small>
  </div>
  <div class="col-4">
    <label for="">SDT</label>
    <input type="text" class="form-control" name="phone" value="{{ $booking->phone}}" id="" aria-describedby="helpId"
      placeholder="">
    @error('phone')
    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
    @enderror</small>
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="">Loại máy tính</label>

      <select class="form-control" name="company_computer_id" id="">
        @foreach ($computers as $item)
        <option value="{{ $item->id }}">{{ $item->company_name }}</option>
        @endforeach


      </select>
    </div>
  </div>
  <div class="col-4">
    <label for="">Hinh thuc</label> <br>

    <div class="form-check form-check-inline">
      <label class="form-check-label">
        <input class="form-check-input" type="radio" name="repair_type" @if ($booking->repair_type=='CH')
        checked
        @endif checked id="" value="CH"> Cửa hàng
      </label>
      <label class="form-check-label">
        <input class="form-check-input" type="radio" name="repair_type" @if ($booking->repair_type=='TN')
        checked
        @endif value="TN"> Tại nhà
      </label>

    </div>
    @error('repair_type')
    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
    @enderror</small>gfn
  </div>
  <div class="col-4">
    <div class="form-group">
      <label for="">Thời gian</label>
      <select class="form-control" name="interval" id="">
        <option value="1">8h-10h</option>
        <option value="2">10h-12h</option>
        <option value="3">12h-14h</option>
        <option value="4">14h-16h</option>
        <option value="5">16h-18h</option>
        <option value="6">18h-20h</option>


      </select>
    </div>
  </div>
  <div class="">

    <div class="form-group">
      <label for="">Mô tả</label>
      <textarea class="form-control" name="description" id="ckeditor1" rows="3">{{ $booking->description }}</textarea>
    </div>
  </div>
  <input name="" id="" class="btn btn-primary" type="submit" value="Lưu  ">

</form>
<script src="{{asset('ckeditor')}}/ckeditor.js"></script>
<script type="text/javascript">
  CKEDITOR.replace('ckeditor');
  CKEDITOR.replace('ckeditor1');

</script>
@endsection