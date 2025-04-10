@extends('layout/Layout')
@section('search')

@endsection
@section('content')
    <div class="card-body">
        <h4 class="card-title">All Products Table in Bill</h4>
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
                    <th> Counter </th>
                    <th> name clinc  </th>
                    <th> Location clinc </th>
                    <th> Delivery </th>
                    <th> Status </th>
                    <th> Date </th>
                </tr>
            </thead>
            @foreach($data as $i)
                
            <td class="py-1">
                <img src="{{ asset($i->image) }}" />
            </td>
            <td>{{ $i->name }}</td>
            <td>{{ $i->counter }}</td>
            <td>{{ $i->company_clinc }}</td>
            <td>{{ $i->Location_clinc }}</td>
            <td>{{ $i->delivaryName }}</td>
             
            <td>
                @switch($i->StatusOrder)
                    @case('A')
                        Need Delivery
                    @case('B')
                        Connecting
                    @break

                    @case('c')
                        Completed
                    @break
                @endswitch
            </td>
            <td>{{ $i->created_at }}</td>
            
            <tbody>
           <tr>
 
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
