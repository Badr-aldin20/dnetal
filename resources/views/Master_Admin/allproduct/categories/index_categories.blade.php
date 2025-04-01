@extends('layout/Layout')
@section('search')

@endsection
@section('content')
    <div class="card-body">
        <h4 class="card-title">All Products Table</h4>
        <a href="{{route("create_categories")}}" id="btn-Add" class="btn btn-inverse-success btn-fw">
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
                    
                    <th> id </th>
                    <th> mode </th>

                </tr>
            </thead>
            @foreach($data as $i)
                
          
            <tbody>
           
                    <tr>
                        <td>{{$i->id}}</td>
                        <td>{{$i->mode}}</td>

                        <td>
                            <form id="deleteForm" action="{{route('del_categories',$i->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="button"onclick="confirmDelete(this)" class="btn btn-primary mr-2">حذف</button>
                            </form>  
                        </td>             
                        <td> <a href="
                            {{route('edit_categories',$i->id)}}
                            " class="btn btn-warning">update</a></td>

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
