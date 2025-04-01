@extends('layout/Layout')
@section('content')
    <div class="col-8 grid-margin stretch-card " style="background-color: ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Product</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="forms-sample" action="{{route('store_balance')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label  class="form-label">body_bos</label>
                        <select name="clinic_id" class="form-control">
                        <option ></option
                       @foreach($users as $user)
                       >
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                        </select >
                      </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">store_balance</label>
                        <input type="number" name="totel_balance" value="{{ old('totel_balance') }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Price Buy">
                    </div>


                    <div class="form-group">

                        <label for="exampleTextarea1">description</label>
                        <textarea class="form-control" id="exampleTextarea1" value="{{ old('description') }}" name="description" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>

                </form>
            </div>
        </div>
    @endsection
