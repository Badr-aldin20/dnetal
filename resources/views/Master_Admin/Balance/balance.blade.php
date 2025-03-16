@extends('layout/Layout')

@section('search')
    <form class="d-flex align-items-center h-100" action="
    {{-- {{ route('search') }} --}}
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
        <h4 class="card-title">All  Product Wite </h4>
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
                    <th> Image </th>
                    <th> name </th>
                    <th> type </th>
                    <th> price Sell </th>
                    <th> price Buy </th>
                    <th colspan="2"> Event </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                <tr>
                    <td class="py-1">
                        <img src="{{asset('image_pro/'.$i->image)}}" />
                    </td>
                    <td>{{ $i->id }}</td>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->total_balance }}</td>
                    <td>{{ $i->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($i->created_at)->format('Y-m-d') }}</td>

                    <td>
                            <form action="
                            {{-- {{ route('requset_product_wait_active', [$i->id]) }} --}}
                             " method="post">
                                @method('put')
                                @csrf
                                <button type="submit" class="btn btn-info btn-rounded ">Acceptable</button>
                            </form>
                        </td>
                        <td>
                            <form id="deleteForm" action="
                            {{-- {{route('requset_product_wait_unactive',[$i->id])}} --}}
                            " method="post">
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
                text: "لن تتمكن من الموافقه على هذا العنصر!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، ارفض!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("deleteForm").submit();
                }
            });
        }
    </script>
@endsection

        