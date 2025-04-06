@extends('layout/Layout')

@section('content')
    <div class="col-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h4 class="card-title">ُEdite Profile</h4>
                @if (session()->has('error'))
                    <div class="alert alert-danger" id="alert">
                        {{ session('error') }}
                    </div>
                    <script>
                        setTimeout(() => {
                            document.getElementById("alert").style.display = "none";
                        }, [2000]);
                    </script>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-danger`" id="alert">
                        {{ session('success') }}
                    </div>
                    <script>
                        setTimeout(() => {
                            document.getElementById("alert").style.display = "none";
                        }, [2000]);
                    </script>
                @endif
                <form class="forms-sample" method="POST" action="{{ route('profile_up',[$data_user->id]) }}"

                 
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" value="{{$data_user->name}}"
                         name="name" class="form-control"
                            id="exampleInputName1" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName1">phone</label>
                        <input type="text" value="{{$data_user->phone}}"
                         name="phone" class="form-control"
                            id="exampleInputName1" placeholder="Name">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName1">Location</label>
                        <input type="text" value="{{$data_user->Location}}" name="Location" class="form-control"
                            id="exampleInputName1" placeholder="Location">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName1">email</label>
                        <input type="text" value="{{$data_user->email}}" name="email" class="form-control"
                            id="exampleInputName1" placeholder="email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName1">name_company</label>
                        <input type="text" value="{{$data_user->name_company}}" name="name_company" class="form-control"
                            id="exampleInputName1" placeholder="name_company">
                    </div>



                    <input type="file"  style="display: none" value="{{$data_user->image}}" name="image" id="image" class="file-upload-default">

                    <label for="image">
                        <div class="form-group">
                            <h5>Image upload</h5>
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                value="{{$data_user->image}}"  placeholder="Upload Image">
                                <span class="input-group-append">
                                    <div class="file-upload-browse btn btn-primary"type="button">Upload</div>
                                </span>
                            </div>
                    </label>


                    <br>
                    <br>

                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <a href="{{route("edit_password")}}"
                     class="btn btn-light">تغير كلمه المرور</a>
                </form>
            </div>
        </div>
    </div>
@endsection
