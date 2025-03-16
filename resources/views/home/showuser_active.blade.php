@extends('layout/Layout')

@section('search')
    <form class="d-flex align-items-center h-100" action="
    {{-- {{ route('Search') }} --}}
     " method="post">

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
        <h4 class="card-title">All User in  </h4>
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
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th> name </th>
                    <th> Name Company </th>
                    <th> Email </th>
                    <th class="2"> Event </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->name_company }}</td>
                        <td>{{ $i->email }}</td>
                        <td>
                            <form action="
                            {{ route('request_active_user', [$i->id]) }}
                             " method="post">
                                @method('put')
                                @csrf
                                <button type="submit" class="btn btn-info btn-rounded ">Acceptable</button>
                            </form>
                        </td>
                        <td>
                            <form id="deleteForm" action="{{route('request_delete_user',[$i->id])}}" method="post">
                                @method('delete')
                                @csrf
                                <button type="button" onclick="confirmDelete()" class="btn btn-danger btn-rounded ">Unacceptable</button>
                            </form>
                            {{-- <form id="deleteForm" action="{{route('request_delete_user',$i->id)}}" method="get">
                                @csrf
                        @method('delete')
                                <button type="button" onclick="confirmDelete()" class="btn btn-primary mr-2">حذف</button>
                            </form>   --}}
                        </td>
                        

                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>

    
    <script>
    

        function confirmDelete() {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "سيتم حذف هذا المستخدم ",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، احذف!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("deleteForm").submit();
                }
            });
        }
    </script>
@endsection
