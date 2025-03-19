@extends('layout/Layout')
@section('content')
    <div class="card-body">
        <h4 class="card-title">All Orders</h4>

        <div style="display: flex; color: #000;">
            <div class="div-status" style="background-color: rgba(18, 177, 18, 0.445)"></div>
            <h5>The Sale has been Completed</h5>
        </div>

        <div style="display: flex; color: #000;gab:5px">
            <div class="div-status" style="background-color: rgba(255, 255, 0, 0.411)"></div>
            <h5>Need Delivery</h5>
        </div>

        <div style="display: flex; color: #000;gab:5px">
            <div class="div-status" style="background-color: rgba(255, 166, 0, 0.486)"></div>
            <h5>Connecting</h5>
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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Image </th>
                    <th> name </th>
                    <th> Counter </th>
                    <th> Delivery </th>
                    <th> Status </th>
                    <th> Date </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i)
                    <tr @if ($i->StatusOrder == 'A') onclick="ShowHiddenDiv({{ $i->id }} )" @endif
                        style="background-color: {{ $i->StatusOrder == 'A' ? '#ffff96' : ($i->StatusOrder == 'B' ? '#ffd483' : '#96dc96') }};">
                        <td class="py-1">
                            <img src="{{ asset($i->image) }}" />
                        </td>
                        <td>{{ $i->name }}</td>
                        <td>{{ $i->counter }}</td>
                        <td>{{ $i->delivaryName }}</td>

                        <td>
                            @switch($i->StatusOrder)
                                @case('A')
                                    Need Delivery
                                @case('B')
                                    Connecting
                                @break

                                @case('C')
                                    Completed
                                @break
                            @endswitch
                        </td>
                        <td>{{ $i->created_at }}</td>


                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div id="div-add-hero">
        <div id="card-add-hero">
            <div class=" ">
                <div class="card">
                    <div class="card-body">
                        <h3>Chose Delivery</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="forms-sample" method="POST" action="
                        {{-- {{ route('product.Order.status') }} --}}
                         ">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" name="id_Sales" id="inputProductId">
                                <select name="id_delivery" class="form-control" id="exampleSelectGender">
                                    @foreach ($deliveries as $i)
                                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>


                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                    <br>
                    <div class="btn btn-light" onclick="ShowHiddenDiv()">Cancel</div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        const form = document.getElementById("div-add-hero");
        const inputProductId = document.getElementById("inputProductId");

        function ShowHiddenDiv(id) {
            form.style.display = form.style.display == "flex" ? "none" : "flex";
            inputProductId.value = id;
        }
    </script>
    <style>
        #div-add-hero {
            width: 100%;
            height: 100vh;
            background-color: #00000060;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            display: none;
            justify-content: center;
            align-items: center;
        }

        #card-add-hero {
            width: 40%;
            height: 60vh;
            background-color: #fff;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            gap: 10;
            align-items: center
        }

        #card-add-hero h3 {
            color: #34af32;
            font-weight: bold;
            font-size: 22px;
        }
    </style>
    <script>
        setTimeout(() => {
            location.reload();
        }, [10000]);
    </script>
@endsection
