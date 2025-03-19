@extends('layout/Layout')
@section('search')

@endsection
@section('content')
    <div class="card-body">
        <h4 class="card-title">All Products on delet</h4>

 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Image </th>
                    <th> name </th>
                    <th> type </th>
                    <th> price Sell </th>
                    <th> price Buy </th>
                    <th> counter </th>
                    <th> Events </th>
                    <th> </th>
                </tr>
            </thead>
            @foreach ( $softdeletin as $i)
                
          
            <tbody>
           
                    <tr>
                        <td class="py-1">
                            <img src="{{asset($i->image)}}" />
                        </td>
                        <td>{{$i->name}}</td>
                        <td>{{$i->modeType}}</td>
                        <td>{{$i->price_buy}}</td>
                        <td>{{$i->price_sales}}</td>
                        <td>{{$i->counter}}</td>
                        <td>                             
                           {{-- <form id="deleteForm" action="{{route('forcedelete_pro',$i->id)}}" method="get">
                                @csrf
                        @method('delete')
                                <button type="button" onclick="confirmDelete()" class="btn btn-primary mr-2">حذف</button>
                            </form>   --}}

                            <form style="display:inline" action=
                            "{{route('forcedelete_pro',$i->id)}}"
                             method="get">
                             
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">حذف بشكل نهائي</button>
                            </form>
                        </td>             
                        <td> <a href="{{route('restor_pro',$i->id)}}" class="btn btn-warning">استعاده</a></td>

                    </tr>
              


            </tbody>
            @endforeach
        </table>
    </div>

    <script>
    

        function confirmDelete() {
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
                    document.getElementById("deleteForm").submit();
                }
            });
        }
    </script>
@endsection
