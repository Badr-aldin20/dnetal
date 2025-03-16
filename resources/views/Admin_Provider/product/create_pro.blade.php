@extends('layout/Layout')
@section('content')
    <div class="col-8 grid-margin stretch-card " style="background-color: ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Product</h4>
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <form class="forms-sample" action="{{route('store_pro')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="exampleInputName1" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Mode Type</label>
                         <select name="modeType" id="" class="form-control">
                            <option value="{{ old('modeType') }}"></option>
                            <option value="مستلزمات">مستلزمات</option>
                            <option value="ادوات جرحيه تستخدم لمره واحده">ادوات جراحيه تستخدم لمره واحده</option>
                            <option value="معدات كبيره">معدات كبيره</option>
                            <option value="اخرى">....اخرى</option>
                         </select>
                        {{-- <input type="text" name="modeType" value="{{ old('modeType') }}" class="form-control" id="exampleInputEmail3"> --}}
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Price Buy</label>
                        <input type="number" name="price_buy" value="{{ old('price_buy') }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Price Buy">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Price Sell</label>
                        <input type="number" name="price_sales" value="{{ old('price_sales') }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Price Sell">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Counter</label>
                        <input type="number" name="counter" value="{{ old('counter') }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Counter">
                    </div>

                    <input type="file" style="display: none" value="{{ old('image') }}" name="image" id="image" class="file-upload-default">

                    <label for="image">
                        <div class="form-group">
                            <h5>Image upload</h5>
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                     placeholder="Upload Image">
                                <span class="input-group-append">
                                    <div class="file-upload-browse btn btn-primary"type="button">Upload</div>
                                </span>
                            </div>
                    </label>


                    <div class="form-group">

                        <label for="exampleTextarea1">Description</label>
                        <textarea class="form-control" id="exampleTextarea1" value="{{ old('description') }}" name="description" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>

                </form>
            </div>
        </div>
    @endsection
