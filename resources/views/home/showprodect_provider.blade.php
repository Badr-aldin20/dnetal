@extends('layout/Layout')

@section('content')
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Image </th>
                    <th> name </th>
                    <th> type </th>
                    <th> price Sell </th>
                    <th> price Buy </th>
                    <th> counter </th>
                    <th> status </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr
                        style="background-color: {{ $i->status == 'Active'  ? 'rgba(18, 177, 18, 0.445)'
                            : ($i->status == 'Wait' ? 'rgba(255, 255, 0, 0.411)'
                                : 'rgba(255, 0, 0, 0.384)') }}">
                        <td class="py-1">
                            <img src="{{ asset("image_pro/".$i->image) }}" />
                        </td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->modeType }}</td>
                        <td>{{ $i->price_buy }}</td>
                        <td>{{ $i->price_sales }}</td>
                        <td>{{ $i->counter }}</td>
                        <td>
                            @switch($i->status)
                                @case('Active')
                                    <button type="button" class="btn btn-facebook">Active</button>
                                @break

                                @case('Unactive')
                                    <button type="button" class="btn btn-danger">Unactive</button>
                                @break

                                @case('Wait')
                                    <button type="button" class="btn btn-warning">Wait</button>
                                @break
                            @endswitch
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection
