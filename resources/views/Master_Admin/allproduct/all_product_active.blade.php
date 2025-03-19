@extends('layout/Layout')

@section('content')
    <div class="card-body">
        <h4 class="card-title">All Products Table</h4>
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
            <tbody>
                @foreach ($data as $i)
                    <tr>
                        <td class="py-1">
                            <img src="{{ asset($i->image) }}" />
                        </td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->modeType }}</td>
                        <td>{{ $i->price_buy }}</td>
                        <td>{{ $i->price_sales }}</td>
                        <td>{{ $i->counter }}</td>
                        {{-- <td>
                             <form action="{{ route('deleteUser', [$i->id]) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-rounded btn-fw">Delete</button>

                            </form>
                        </td> --}}

                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection
