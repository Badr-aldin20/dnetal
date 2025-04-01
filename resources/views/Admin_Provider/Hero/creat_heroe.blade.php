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
                <form class="forms-sample" action=" {{ route('story_heroe') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                

                    <div class="form-group">
                        <label for="exampleInputEmail3">price_new</label>
                        <input type="number" name="price_new" value="{{ old('price_new') }}" class="form-control" id="exampleInputEmail3"
                            placeholder="price_new	">
                    </div>

                    <div class="form-group">
                    <div class="mb-3">
                        <label  class="form-label">product_name</label>
                        <select name="product_Id" class="form-control">
                        <option ></option
                       @foreach($prod as $pro)
                       >
                        <option value="{{$pro->id}}">{{$pro->name}}</option>
                        @endforeach
                        </select >
                      </div>
                    </div>
                    
                   
               


                    <div class="form-group">
                        <label for="exampleInputName1">End Time</label>
                        <input type="date" class="form-control" id="exampleInputName1" name="end_time"
                            placeholder="Name">
                    </div>
                 
                    <div class="form-group">
                        <label for="exampleInputName1">percentage</label>
                        <input type="text" class="form-control" name="percentage" value="{{ old('percentage') }}" id="exampleInputName1" placeholder="percentage">
                    </div>        
                    
                    <div class="form-group">
                        <label for="exampleInputName1">description</label>
                        <input type="text" class="form-control" name="description" value="{{ old('description') }}" id="exampleInputName1" placeholder="description	">
                    </div>      

                   

                    <button type="submit" class="btn btn-primary mr-2">Add</button>
                    <button class="btn btn-light">Cancel</button>

                </form>
            </div>
        </div>
    @endsection
