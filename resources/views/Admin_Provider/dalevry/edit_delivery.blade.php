@extends('layout/Layout')

@section('content')
    <div class="col-8 grid-margin stretch-card " style="background-color: ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New delivery</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="forms-sample" action="{{ route('updata_delivery',$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" name="name" value="{{$data->name}}" id="exampleInputName1" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">email </label>
                        <input type="email" name="email" value="{{ $data->email }}" class="form-control" id="exampleInputEmail3"
                            placeholder="email ">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">password</label>
                        <input type="text" name="password" value="{{ $data->password}}" class="form-control" id="exampleInputEmail3"
                            placeholder="password">
                    </div>

                   

                    <button type="submit" class="btn btn-primary mr-2">edit</button>
                    <button class="btn btn-light">Cancel</button>

                </form>
            </div>
        </div>
    @endsection
