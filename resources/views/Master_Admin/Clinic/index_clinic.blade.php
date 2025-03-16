@extends('layout/Layout')
@section('search')
    <form class="d-flex align-items-center h-100" action="{{route('search_clinic') }}"
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
@if (session()->has('sussess'))
<div class="alert alert-success" id="alert">
    {{ session('sussess') }}
</div>
<script>
    setTimeout(() => {
        document.getElementById("alert").style.display = "none";
    }, [2000]);
</script>
@endif
    <div class="card-body">
        <h4 class="card-title">All Clinics Table</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> User </th>
                    <th> name </th>
                    <th> Name Company </th>
                    <th> Email </th>
                    <th> phone Number </th>
                </tr>
            </thead>
            <tbody>

                @if (session()->has('error'))
                <div class="alert alert-success" id="alert">
                    {{ session('error') }}
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById("alert").style.display = "none";
                    }, [2000]);
                </script>
            @endif

                @foreach ($data as $i)
                    <tr>
                        <td class="py-1">
                            <img src="{{asset('image_user/'.$i->image)}}" />
                        </td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->name_company }}</td>
                        <td>{{ $i->email }}</td>
                        <td>{{ $i->phone }}</td>
                        <td>
                            <form id="deleteForm" action="{{route('stope_clinic',[$i->id])}}" method="post">
                                @method('PUT')
                                @csrf
                                <button type="button" onclick="confirmDelete()" class="btn btn-danger btn-rounded ">Unacceptable</button>
                            </form>
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
            text: "سيتم ايقاف التطبيق",
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