@extends('layout/Layout')
@section('search')

@endsection
@section('content')
    <div class="card-body">
        <h4 class="card-title">All Products Table</h4>
        <a href="{{route("creat_heroe")}}" id="btn-Add" class="btn btn-inverse-success btn-fw">
            Add New heroe
        </a>


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
                    <th> image </th>
                    <th>name_Manger</th>
                    <th> name </th>
                    <th>  price_old </th>
                    <th>  price_new </th>
                    <th> الخصم</th>
                    <th> percentage </th>
                    <th> end_time </th>
                    <th> Events </th>
                </tr>
            </thead>
            @foreach($data as $i)
                
          
            <tbody>
           
                    <tr>
                        <td class="py-1">
                            <img src="{{ asset($i->image) }}" />
                        </td>
                        <td>{{$i->name_Manger}}</td>
                        <td>{{$i->name}}</td>
                        <td>{{$i->price_old}}</td>
                        <td>{{$i->price_new}}</td>
                        <td>{{$i->perce}}</td>
                        <td>{{$i->percentage}}</td>
                        <td>{{$i->end_time}}</td>

                        <td>
                            <form id="deleteForm" action="{{route('delete_hero_status',$i->id_heroe)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="button"onclick="confirmDelete(this)" class="btn btn-primary mr-2">حذف</button>
                            </form>  
                        </td>             
                        <td>
                            <form id="deleteForm" action="{{route('Active_hero_status',$i->id_heroe)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="button"onclick="confirmPUT(this)" class="btn btn-primary mr-2">قبول</button>
                            </form>  
                            <th>
                                {{-- @if ($i->Active == 0)
                                <label class="badge badge-danger">Finish</label>
                                @else
                              <label class="badge badge-success">Not Finish</label>
                                @endif  --}}

                                {!! $i->Active == 0
                                    ? '<label class="badge badge-danger">Finish</label>'
                                    : '<label class="badge badge-success">Not Finish</label>' !!}
                            </th>

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

        function confirmPUT(button) {
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
