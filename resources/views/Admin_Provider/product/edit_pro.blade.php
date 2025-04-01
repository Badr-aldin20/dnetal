@extends('layout/Layout')
@section('content')
    <div class="col-8 grid-margin stretch-card " style="background-color: ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">تعديل المنتج</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="forms-sample" action="{{route('updata_pro',$sel)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $sel->name }}" id="exampleInputName1" >
                    </div>

                    <div class="mb-3">
                        <label  class="form-label">catagory</label>
                        <select name="catagory_id" class="form-control">
                        <option value="{{$catagory->id}}">{{$catagory->mode}}</option>
                        <option value=""></option>
                       @foreach($catagory_all as $catagory_all)
                       >
                        <option value="{{$catagory_all->id}}">{{$catagory_all->mode}}</option>
                        @endforeach
                        </select >
                      </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Mode Type</label>
                        <input type="text" name="modeType" value="{{$sel->modeType}}" class="form-control" id="exampleInputEmail3">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Price Buy</label>
                        <input type="number" name="price_buy" value="{{ $sel->price_buy  }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Price Buy">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Price Sell</label>
                        <input type="number" name="price_sales" value="{{ $sel->price_sales  }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Price Sell">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Counter</label>
                        <input type="number" name="counter" value="{{ $sel->counter  }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Counter">
                    </div>

                    <input type="file" style="display: none" value="{{$sel->image  }}" name="image" id="image" class="file-upload-default">

                    <label for="image">
                        <div class="form-group">
                            <h5>Image upload</h5>
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" value="{{$sel->image  }}"
                                 disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <div class="file-upload-browse btn btn-primary"type="button">Upload</div>
                                </span>
                            </div>
                    </label>


                    <div class="form-group">

                        <label for="exampleInputEmail3">Description</label>
                        <input type="text" name="description" value="{{$sel->description}}" class="form-control" id="exampleInputEmail3">
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>

                </form>
            </div>
        </div>
    @endsection
