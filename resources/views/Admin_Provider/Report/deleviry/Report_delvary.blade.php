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

        {{-- <form action="{{ route('Delivery.PDF') }}" method="POST">
            @csrf
            <input type="hidden" value="" name="id_delivery">
            <button type="submit" class="btn btn-google btn-icon-text"> PDF <i
                    class="mdi mdi-printer btn-icon-append"></i>
            </button>
        </form> --}}
      </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Deliver </th>
                    <th> Name Clinic</th>
                    <th> Location </th>
                    <th> status </th>
                    <th> data </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr
                        style="background-color: {{ $i->status == 'Success' ? '#96dc96' : ($i->status == 'Underway' ? '#ffff96' : '#ff7777') }}">
                        <td>{{ $i->deliver_name }}</td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->Location }}</td>
                        <td>{{ $i->status }}</td>
                        </td>
                        <td>{{ $i->created_at }}</td>
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
