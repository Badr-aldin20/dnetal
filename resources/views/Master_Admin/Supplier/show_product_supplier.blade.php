@extends('layout/Layout')
@section('search')

@endsection
@section('content')
    <div class="card-body">
        <h4 class="card-title">All Products is supplier </h4>

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
                    <th> Image </th>
                    <th> name </th>
                    <th> type </th>
                    <th> price Sell </th>
                    <th> price Buy </th>
                    <th> counter </th>
                    
                 
                </tr>
            </thead>
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
          
          
            @foreach($data as $i)
                
          
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
                              
                            {{-- <form id="deleteForm" action="{{route('delete_pro',$i->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                
                                <button type="button" onclick="confirmDelete()" class="btn btn-primary mr-2">حذف</button>
                            </form>  
                        </td>             
                        <td> <a href="{{route('edit_pro',$i->id)}}" class="btn btn-warning">update</a></td> --}}

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
