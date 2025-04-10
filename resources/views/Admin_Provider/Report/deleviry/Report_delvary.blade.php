@extends('layout/Layout')

@section('content')
    <div class="card-body">
        <h4 class="card-title">All Orders</h4>

        <div style="display: flex; color: #000;">
            <div class="div-status" style="background-color: #96dc96"></div>
            <h5>Success</h5>
        </div>

        <div style="display: flex; color: #000;gab:5px">
            <div class="div-status" style="background-color: #ffff96"></div>
            <h5>Underway</h5>
        </div>

        <div style="display: flex; color: #000;gab:5px">
            <div class="div-status" style="background-color: #ff7777"></div>
            <h5>failure</h5>
        </div>

        <style>
            .div-status {
                width: 20px;
                height: 20px;
                margin-right: 5px;
            }
        </style>
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

        {{-- select Delivery --}}
      <div style="display: flex;justify-content: space-between;width: 100%;">
        <form action="{{ route('search_Report_delivery') }}
         " method="POST">
            @csrf
            <div style="display: flex; color: #000;gab:10px;align-items: center">
                <label for="">Delivery</label>
                <select name="id_delivery"  style="margin-left: 10px ;height: 40px; font-size: 15px;width: 200px;">
                    <option value="0">الكل</option>
                    @foreach ($delivery as $i)
                    <option value="{{$i->id}}">{{$i->name}}</option>
                        
                    @endforeach
                </select>
                
                <button type="submit" class="btn btn-dribbble m-2">Filter</button>
            </div>
         

        </form>

      </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> رقم الفاتوره </th>
                    <th> Deliver </th>
                    <th> Name Clinic</th>
                    <th> Location </th>
                    <th> قيمه الفاتوره </th>
                    <th> data </th>
                    <th> status </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr>
                        <td>{{ $i->bill_id }}</td>
                        <td>{{ $i->deliver_name }}</td>
                        <td>{{ $i->clinic_name }}</td>
                        <td>{{ $i->Location }}</td>
                        <td>{{ $i->total_amount }}</td>
                        <td>{{ $i->created_at }}</td>
                        {{-- <td>{{ $i->status }}</td> --}}

                         <td>
                       @switch($i->status)
                           @case("Success")
                           <label class="badge badge-success">العمليه ناجحه</label>
                               @break
                           @case("failure")
                           <label class="badge badge-danger">العمليه فاشله </label>
                               @break
                           @default
                           <label class="badge badge-warning"> قيد الانتظار</label>
                       @endswitch
                    </td>

                    <td>
                        <a href=" {{route('index_order_delivery',[$i->bill_id])}}" class="btn btn-primary btn-rounded ">عرض المنتجات </a>

                    </td>
                    </tr>
                @endforeach

                <tr>
                    <th colspan="2" style="background-color: #96dc96">Success
                         {{ $Success }}
                        </th>
                    <th></th>
                    <th colspan="2"style="background-color: #ff7777">failure 
                        {{ $fail }}
                    </th>
                </tr>

            </tbody>
        </table>
    </div>
@endsection
