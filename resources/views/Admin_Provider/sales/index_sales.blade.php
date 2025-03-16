@extends('layout/Layout')
@section('content')
<div class="card-body">
    <h4 class="card-title">All Products Table</h4>
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
                <th> price Sell </th>
                <th> price Buy </th>
                <th> total Profit </th>
                <th> Date </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i)
          <tr>
                    <td class="py-1">
                        <img src="{{ asset('image_pro/'.$i->image) }}" />
                    </td>
                    <td>{{ $i->name}}</td>
                    <td>{{ $i->couner }}</td>
                    <td>{{ $i->price_sales }}</td>
                    <td>{{ $i->price_buy }}</td>
                    <td>{{ $i->Balance }}</td>
                    <td>{{ \Carbon\Carbon::parse($i->created_at)->format('Y-m-d') }}</td>

                   
                </tr>
            @endforeach
<tr style="background-color: rgba(128, 128, 128, 0.514)">
    <td colspan="3"><h4>Total Price</h4></td>
    <td colspan="4"><h4>
        {{$total_Balance}}
    </h4></td>
</tr>

        </tbody>
    </table>
</div>
@endsection