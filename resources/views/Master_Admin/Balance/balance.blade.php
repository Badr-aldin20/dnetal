@extends('layout/Layout')
@section('search')
    <form class="d-flex align-items-center h-100" action="{{route('search_balance') }}"
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
        <div class="alert alert-success" id="alert">
            {{ session('success') }}
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
                        <td>{{$i->id_bala	}}</td>
                        <td>{{$i->name_clin	}}</td>
                        <td>{{$i->status}}</td>
                        <td>{{$i->totel_balance}}</td>
                        <td>{{$i->description}}</td>
                        <td>{{$i->deta	}}</td>


                        <td>
                            {{-- <form id="deleteForm" action="
                            {{route('del_categories',$i->id)}}
                            " method="POST">
                                @csrf
                                @method('delete')
                                <button type="button"onclick="confirmDelete(this)" class="btn btn-primary mr-2">حذف</button>
                            </form>   --}}
                        </td>             
                        <td>
                            @if ($i->status == "failure")
                            <a href="{{route('edit_balance',$i->id_bala)}}" class="btn btn-warning">عمليه مرفوضه</a>
                            @elseif ($i->status == "Success")
                            <a href="{{route('edit_balance',$i->id_bala)}}" class="btn btn-primary"> update</a>
                            @endif

                    </tr>
              


            </tbody>
            @endforeach
        </table>
    </div>

    <script>
    

        function confirmDelete(button) {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من استعادة هذا العنصر!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، احذف!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest("form").submit(); // ارسال النموذج الصحيح المرتبط بالزر
                }
            });
        }
    </script>
@endsection
