@extends('layout/Layout')
@section('search')
    <form class="d-flex align-items-center h-100" action="{{route('search_balanc_clint') }}"
     method="post">

        @csrf
        <div class="input-group">
            <div class="input-group-prepend bg-transparent">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
            </div>
            <input type="text" class="form-control bg-transparent border-0" name="txt" placeholder="Search Users">
        </div>
    </form>
@endsection
@section('content')
<div class="card-body">
    <h4 class="card-title">All Products Table</h4>
    <a href="{{route("create_balance")}}" id="btn-Add" class="btn btn-inverse-success btn-fw">
        Add New heroe
    </a>   
        @if (session()->has('edit'))
        <div class="alert alert-success" id="alert">
            {{ session('edit') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, [2000]);
        </script>
    @endif
        @if (session()->has('success'))
        <div class="alert alert-success" id="alert">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, [2000]);
        </script>
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
        <table class="table table-striped">
            <thead>
                <tr>
                    
                    <th> # </th>
                    <th> name </th>
                    <th> status </th>
                    <th> totel_balance </th>
                    <th> description </th>
                    <th> deta </th>

                </tr>
            </thead>
            @foreach($data as $i)
                
          
            <tbody>
           
                    <tr>
                        <td>{{$i->clinic_id	}}</td>
                        <td>{{$i->name_clin	}}</td>
                        <td>{{$i->status}}</td>
                        <td>{{$i->totel_balance}}</td>
                        <td>{{$i->description}}</td>
                        <td>{{$i->deta	}}</td>


                        <td>
                            <form id="deleteForm" action="{{route('cincal_balanc_clint',$i->id_bala)}}" method="POST">
                                @csrf
                                @method('put')
                                <button type="button"onclick="confirmPUT(this)" class="btn btn-danger btn-rounded ">الغاء العمليه</button>
                            </form>  
                        </td>       
                        <td>
                            <form id="deleteForm" action="{{route('Asess_balanc_clint',$i->id_bala)}}" method="POST">
                                @csrf
                                @method('put')
                                <button type="button"onclick="confirmAcsses(this)" class="btn btn-primary btn-rounded ">قبول العمليه</button>
                            </form>      
                        </td>      
                        {{-- <td> <a href=" {{route('Asess_balanc_clint',$i->id_bala)}}" class="btn btn-primary btn-rounded ">update</a></td> --}}

                    </tr>
              


            </tbody>
            @endforeach
        </table>
    </div>

    <script>
    

        function confirmPUT(button) {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من الموافقه على هذا العمليه ولن يتم اضافه رصيد للحساب!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، الغاء!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest("form").submit(); // ارسال النموذج الصحيح المرتبط بالزر
                }
            });
        }

        function confirmAcsses(button) {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من الغاء هذا العمليه وسيتم ااضافه رصيد للحساب!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، اضافه رصيد للحساب!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest("form").submit(); // ارسال النموذج الصحيح المرتبط بالزر
                }
            });
        }
    </script>
@endsection
