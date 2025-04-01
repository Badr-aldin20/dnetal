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


                <form class="forms-sample" action="{{ route('update_password')}} " method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="password" class="form-control form-control-lg" name="password" value="{{ old('password') }}">
                    </div>

                   
                    <div class="form-group">
                        <label for="exampleInputName1">password_new</label>
                        <input type="password" class="form-control form-control-lg" name="password_new" value="{{ old('password_new') }}">
                            
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName1">password_new_2</label>
                        <input type="password" class="form-control form-control-lg" name="password_new2" value="{{ old('password_new2') }}">

                    </div>

                   

                    <button type="submit" class="btn btn-primary mr-2">edit</button>
                    <button class="btn btn-light">Cancel</button>

                </form>
            </div>
        </div>
    @endsection
