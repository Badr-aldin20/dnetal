@extends('layout/Layout')

@section('search')
    <form class="d-flex align-items-center h-100" action="{{route('search_supplier') }}" method="post">
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
        <h4 class="card-title">All Supplier Table</h4>
       
    @if (session()->has('recavery'))
    <div class="alert alert-success" id="alert">
        {{ session('recavery') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById("alert").style.display = "none";
        }, [5000]);
    </script>
@endif
    
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
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th> User </th>
                    <th> name </th>
                    <th> Name Company </th>
                    <th> Email </th>
                    <th> phone Number </th>
                    <th> Delete </th>
                    <th> Show </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr>
                        <td class="py-1">
                            <img src="{{asset($i->image)}}" />
                        </td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->name_company }}</td>
                        <td>{{ $i->email }}</td>
                        <td>{{ $i->phone }}</td>
                        <td>
                            <form action=" {{ route('stope_supplier', [$i->id]) }} " method="post">
                                @method('put')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-rounded ">ايقاف المزود</button>

                            </form>
                        </td>
                        <td>
                            <a href=" {{ route('show_product_supplier', [$i->id]) }}" class="btn btn-primary btn-rounded ">عرض المنتجات </a>

                        </td>

                        <td>
                            <form id="resetForm{{$i->id}}" action="{{ route('Password_Recovery', $i->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="button" onclick="confirmReset(this, {{$i->id}})" class="btn btn-primary mr-2">استعادة كلمة المرور</button>
                            </form>  
                        </td> 
                        

                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>

    <script>
        function confirmReset(button, userId) {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من استخدام كلمة المرور القديمة، سيتم توليد كلمة مرور جديدة!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، استعد!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("resetForm" + userId).submit();
                }
            });
        }
    </script>
    
@endsection
