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
                <form class="forms-sample" action="{{route('update_balance',$data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label  class="form-label">body_bos</label>
                        <select name="clinic_id" class="form-control">
                        <option value="{{$name_clinc->id}}">{{$name_clinc->name}}</option>
                        <option value=""></option>
                       @foreach($users as $user)
                       >
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                        </select >
                      </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">store_balance</label>
                        <input type="number" name="totel_balance" value="{{ $data->totel_balance }}" class="form-control" id="exampleInputEmail3"
                            placeholder="Price Buy">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName1">description</label>
                        <input type="text" class="form-control" name="description" value="{{ $data->description }}" id="exampleInputName1" >
                    </div>

                    <input  name="minc_balance" value="{{ $data->totel_balance }}">
           
                    <input  name="id_user" value="{{ $name_clinc->id }}">
       

                     
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>

                </form>
            </div>
        </div>
    @endsection
