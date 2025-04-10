 {{-- @extends('layout.Layout')

@section('search')
<form class="d-flex align-items-center h-100" action="{{ route('search_ai_product') }}" method="get">
    @csrf
    <div class="input-group">
        <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
        </div>
        <input type="text" value="{{ session('result.class') }}" class="form-control bg-transparent border-0" name="txt" placeholder="أدخل اسم المنتج">
    </div>
</form>
@endsection

@section('content')
<div class="container" style="margin-top: 50px;">
    <h2>رفع الصورة للتنبؤ</h2>

    <form action="{{ route('predict_image') }}" method="POST" enctype="multipart/form-data" id="imageForm">
        @csrf
        <input type="file" name="image" required class="form-control mt-3" onchange="document.getElementById('imageForm').submit();">
    </form>

    @if(session('result'))
        <div class="alert alert-info mt-3">
            <strong>التنبؤ:</strong> {{ session('result.class') }} |
            <strong>نسبة الثقة:</strong> {{ session('result.confidence') * 100 }}%
        </div>
    @endif

    @if (session()->has('success'))
    <div class="alert alert-success" id="alert">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById("alert").style.display = "none";
        }, 2000);
    </script>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger" id="alert">
            {{ session('error') }}
        </div> 
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    @endif

    @if(isset($basket) && count($basket))
        <h4 class="mt-5">سلة المشتريات</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Image </th>
                    <th> name </th>
                    <th> اسم الصنف </th>
                    <th> counter </th> 
                    <th> price Buy </th>
                    <th> total_price </th>
                    <th> حذف </th>
                    <th> بيع </th>
                </tr>
            </thead>
            <tbody>
                @foreach($basket as $i)
                    <tr>
                        <td>{{$i->as_id}}</td>
                        <td class="py-1"><img src="{{ asset($i->image) }}" /></td>
                        <td>{{$i->name_prodect}}</td>
                        <td>{{$i->mode}}</td>
                        <td>
                            {{$i->number_prodect}} <br>
                            <button class="btn btn-sm btn-warning mt-2" data-toggle="modal" data-target="#updateModal{{$i->as_id}}">تعديل الكمية</button>
                        </td>
                        <td>{{$i->price_buy}}</td>
                        <td>{{$i->total_price}}</td>
                        <td>
                            <form id="deleteForm" action="{{route('delete_ai_cat',$i->as_id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="button" onclick="confirmDelete(this)" class="btn btn-primary mr-2">حذف</button>
                            </form>  
                        </td>             
                        <td> 
                            <form action="{{route('cart_ai_sales',$i->as_id)}}" method="POST">
                                @csrf
                                <button type="button" onclick="confirmDelete(this)" class="btn btn-primary mr-2">بيع المنتج</button>
                            </form>  
                        </td>
                    </tr>

                    <div class="modal fade" id="updateModal{{$i->as_id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel{{$i->as_id}}" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form method="POST" action="{{ route('update_ai_cat', $i->as_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel{{$i->as_id}}">تعديل الكمية</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="counter">الكمية الجديدة:</label>
                                    <input type="number" name="counter" class="form-control" min="1" value="{{$i->number_prodect}}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-success">حفظ التعديل</button>
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                @endforeach

                <tr style="background-color: rgba(128, 128, 128, 0.514)">
                    <td colspan="3"><h4>Total Price</h4></td>
                    <td colspan="6">
                        <h4>{{$total_Balance}}</h4>
                    </td>
                    <td>
                        <form action="{{ route('cart_ai_sales_all') }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="button" onclick="confirmDelete(this)" class="btn btn-primary mr-2">بيع من السلة</button>
                        </form>
                        <form action="{{ route('cart_ai_delete_all') }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="button" onclick="confirmDelete(this)" class="btn btn-danger mr-2">تفريغ السلة</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
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
                button.closest("form").submit();
            }
        });
    }
</script>
@endsection 

 --}}








 
 {{-- @extends('layout.Layout')
 

@section('search')
<form class="d-flex align-items-center h-100" action="{{ route('search_ai_product') }}" method="get">
    @csrf
    <div class="input-group">
        <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
        </div>
        <input type="text" value="{{ session('result.class') }}" class="form-control bg-transparent border-0" name="txt" placeholder="أدخل اسم المنتج">
    </div>
</form>
@endsection

@section('content')
<div class="container" style="margin-top: 50px;">
    <h2>التقاط صورة للتنبؤ</h2>

    <div class="mt-3">
        <video id="video" width="320" height="240" autoplay class="border rounded"></video>
        <canvas id="canvas" width="320" height="240" class="d-none"></canvas>
    </div>

    <div class="mt-3">
        <button id="startCamera" class="btn btn-success">فتح الكاميرا</button>
        <button id="stopCamera" class="btn btn-danger">إغلاق الكاميرا</button>
        <button id="capture" class="btn btn-primary">التقاط صورة</button>
    </div>

    <script>
        let video = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let startButton = document.getElementById('startCamera');
        let stopButton = document.getElementById('stopCamera');
        let captureButton = document.getElementById('capture');
        let stream;

        startButton.addEventListener('click', async () => {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        });

        stopButton.addEventListener('click', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        });

        captureButton.addEventListener('click', () => {
            let context = canvas.getContext('2d');
            canvas.classList.remove('d-none');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                let formData = new FormData();
                formData.append('image', blob, 'captured.jpg');
                formData.append('_token', '{{ csrf_token() }}');

                fetch("{{ route('predict_image') }}", {
                    method: "POST",
                    body: formData
                }).then(response => response.text())
                  .then(data => {
                    window.location.reload();
                  }).catch(error => {
                    alert("حدث خطأ أثناء إرسال الصورة.");
                    console.error(error);
                });
            }, 'image/jpeg');
        });
    </script>

    @if(session('result'))
        <div class="alert alert-info mt-3">
            <strong>التنبؤ:</strong> {{ session('result.class') }} |
            <strong>نسبة الثقة:</strong> {{ session('result.confidence') * 100 }}%
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success" id="alert">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger" id="alert">
            {{ session('error') }}
        </div> 
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    @endif

    @if(isset($basket) && count($basket))
        <h4 class="mt-5">سلة المشتريات</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Image </th>
                    <th> name </th>
                    <th> اسم الصنف </th>
                    <th> counter </th> 
                    <th> price Buy </th>
                    <th> total_price </th>
                    <th> حذف </th>
                    <th> بيع </th>
                </tr>
            </thead>
            <tbody>
                @foreach($basket as $i)
                    <tr>
                        <td>{{$i->as_id}}</td>
                        <td class="py-1"><img src="{{ asset($i->image) }}" /></td>
                        <td>{{$i->name_prodect}}</td>
                        <td>{{$i->mode}}</td>
                        <td>
                            {{$i->number_prodect}} <br>
                            <button class="btn btn-sm btn-warning mt-2" data-toggle="modal" data-target="#updateModal{{$i->as_id}}">تعديل الكمية</button>
                        </td>
                        <td>{{$i->price_buy}}</td>
                        <td>{{$i->total_price}}</td>
                        <td>
                            <form id="deleteForm" action="{{route('delete_ai_cat',$i->as_id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="button" onclick="confirmDelete(this)" class="btn btn-primary mr-2">حذف</button>
                            </form>  
                        </td>             
                        <td> 
                            <form action="{{route('cart_ai_sales',$i->as_id)}}" method="POST">
                                @csrf
                                <button type="button" onclick="confirmDelete(this)" class="btn btn-primary mr-2">بيع المنتج</button>
                            </form>  
                        </td>
                    </tr>

                    <div class="modal fade" id="updateModal{{$i->as_id}}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel{{$i->as_id}}" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <form method="POST" action="{{ route('update_ai_cat', $i->as_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel{{$i->as_id}}">تعديل الكمية</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="counter">الكمية الجديدة:</label>
                                    <input type="number" name="counter" class="form-control" min="1" value="{{$i->number_prodect}}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-success">حفظ التعديل</button>
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                @endforeach

                <tr style="background-color: rgba(128, 128, 128, 0.514)">
                    <td colspan="3"><h4>Total Price</h4></td>
                    <td colspan="6">
                        <h4>{{$total_Balance}}</h4>
                        <form action="{{ route('cart_ai_sales_all') }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="button" onclick="confirmDelete(this)" class="btn btn-primary mr-2">بيع من السلة</button>
                        </form>
                        <form action="{{ route('cart_ai_delete_all') }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="button" onclick="confirmDelete(this)" class="btn btn-danger mr-2">تفريغ السلة</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
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
                button.closest("form").submit();
            }
        });
    }
</script>
@endsection  --}}

{{-- 
@extends('layout.Layout')

@section('search')
<form class="d-flex align-items-center h-100" action="{{ route('search_ai_product') }}" method="get">
    @csrf
    <div class="input-group">
        <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
        </div>
        <input type="text" value="{{ session('result.class') }}" class="form-control bg-transparent border-0" name="txt" placeholder="أدخل اسم المنتج">
    </div>
</form>
@endsection

@section('content')
<div class="container" style="margin-top: 50px;">
    <h2>تحميل أو التقاط صورة للتنبؤ</h2>

    <form action="{{ route('predict_image') }}" method="POST" enctype="multipart/form-data" id="imageForm">
        @csrf
        <input type="file" name="image" accept="image/*" class="form-control mt-3" onchange="document.getElementById('imageForm').submit();">
        <small class="text-muted">أو استخدم الكاميرا بالأسفل</small>
    </form>

    <div class="mt-4">
        <video id="video" width="320" height="240" autoplay class="border rounded d-block mb-2"></video>
        <canvas id="canvas" width="320" height="240" class="d-none"></canvas>
        
        <div class="btn-group mt-2">
            <button id="startCamera" class="btn btn-success">تشغيل الكاميرا</button>
            <button id="stopCamera" class="btn btn-secondary">إغلاق</button>
            <button id="capture" class="btn btn-primary">التقاط</button>
        </div>
    </div>

    <script>
        let video = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let startButton = document.getElementById('startCamera');
        let stopButton = document.getElementById('stopCamera');
        let captureButton = document.getElementById('capture');
        let stream;

        startButton.addEventListener('click', async () => {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        });

        stopButton.addEventListener('click', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        });

        captureButton.addEventListener('click', () => {
            let context = canvas.getContext('2d');
            canvas.classList.remove('d-none');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                let formData = new FormData();
                formData.append('image', blob, 'captured.jpg');
                formData.append('_token', '{{ csrf_token() }}');

                fetch("{{ route('predict_image') }}", {
                    method: "POST",
                    body: formData
                }).then(response => response.text())
                  .then(data => {
                    window.location.reload();
                  }).catch(error => {
                    alert("حدث خطأ أثناء إرسال الصورة.");
                    console.error(error);
                });
            }, 'image/jpeg');
        });
    </script>

    @if(session('result'))
        <div class="alert alert-info mt-3">
            <strong>التنبؤ:</strong> {{ session('result.class') }} |
            <strong>نسبة الثقة:</strong> {{ session('result.confidence') * 100 }}%
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success" id="alert">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger" id="alert">
            {{ session('error') }}
        </div> 
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    @endif
</div>
@endsection--}}



@extends('layout.Layout')

@section('search')
<form class="d-flex align-items-center h-100" action="{{ route('search_ai_product') }}" method="get">
    @csrf
    <div class="input-group">
        <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
        </div>
        <input type="text" value="{{ session('result.class') }}" class="form-control bg-transparent border-0" name="txt" placeholder="أدخل اسم المنتج">
    </div>
</form>
@endsection

@section('content')
<div class="container" style="margin-top: 50px;">
    <h2>تحميل أو التقاط صورة للتنبؤ</h2>

    {{-- رفع صورة من الجهاز --}}
    <form action="{{ route('predict_image') }}" method="POST" enctype="multipart/form-data" id="imageForm">
        @csrf
        <input type="file" name="image" accept="image/*" class="form-control mt-3" onchange="document.getElementById('imageForm').submit();">
        <small class="text-muted">أو استخدم الكاميرا بالأسفل</small>
    </form>

    {{-- الكاميرا --}}
    <div class="mt-4">
        <video id="video" width="320" height="240" autoplay class="border rounded d-block mb-2"></video>
        <canvas id="canvas" width="320" height="240" class="d-none"></canvas>
        
        <div class="btn-group mt-2">
            <button id="startCamera" class="btn btn-success">تشغيل الكاميرا</button>
            <button id="stopCamera" class="btn btn-secondary">إغلاق</button>
            <button id="capture" class="btn btn-primary">التقاط</button>
        </div>
    </div>

    {{-- سكربت الكاميرا --}}
    <script>
        let video = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let startButton = document.getElementById('startCamera');
        let stopButton = document.getElementById('stopCamera');
        let captureButton = document.getElementById('capture');
        let stream;

        startButton.addEventListener('click', async () => {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        });

        stopButton.addEventListener('click', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        });

        captureButton.addEventListener('click', () => {
            let context = canvas.getContext('2d');
            canvas.classList.remove('d-none');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                let formData = new FormData();
                formData.append('image', blob, 'captured.jpg');
                formData.append('_token', '{{ csrf_token() }}');

                fetch("{{ route('predict_image') }}", {
                    method: "POST",
                    body: formData
                }).then(response => window.location.reload())
                .catch(error => {
                    alert("حدث خطأ أثناء إرسال الصورة.");
                    console.error(error);
                });
            }, 'image/jpeg');
        });
    </script>

    {{-- نتيجة التنبؤ --}}
    @if(session('result'))
        <div class="alert alert-info mt-3">
            <strong>التنبؤ:</strong> {{ session('result.class') }} |
            <strong>نسبة الثقة:</strong> {{ session('result.confidence') * 100 }}%
        </div>
    @endif

    {{-- رسائل النجاح أو الخطأ --}}
    @if (session()->has('success'))
        <div class="alert alert-success" id="alert">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger" id="alert">
            {{ session('error') }}
        </div> 
        <script>
            setTimeout(() => {
                document.getElementById("alert").style.display = "none";
            }, 2000);
        </script>
    @endif

    {{-- عرض سلة المشتريات --}}
    <div class="mt-5">
        <h3>سلة المشتريات</h3>
        @if(count($basket) > 0)
        <table class="table table-bordered mt-3 text-center">
            <thead class="table-light">
                <tr>
                    <th>المنتج</th>
                    <th>الصورة</th>
                    <th>العدد</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                    <th>التحكم</th>
                </tr>
            </thead>
            <tbody>
                @foreach($basket as $item)
                <tr>
                    <td>{{ $item->name_prodect }}</td>
                    <td><img src="{{ asset('storage/' . $item->image) }}" width="50"></td>
                    <td>
                        <form action="{{ route('update_ai_cat', $item->as_id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="number" name="counter" value="{{ $item->number_prodect }}" class="form-control" min="1">
                            <button class="btn btn-sm btn-primary mt-1">تحديث</button>
                        </form>
                    </td>
                    <td>{{ $item->price_buy }} ريال</td>
                    <td>{{ $item->total_price }} ريال</td>
                    <td>
                        <form action="{{ route('delete_ai_cat', $item->as_id) }}" method="post" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-3">
            <strong>الإجمالي الكلي: {{ $total_Balance }} ريال</strong>
            <div>
                <form action="{{ route('cart_ai_sales_all') }}" method="post" class="d-inline">
                    @csrf
                    <button class="btn btn-success">بيع الكل</button>
                </form>
                <form action="{{ route('cart_ai_delete_all') }}" method="post" class="d-inline">
                    @csrf
                    <button class="btn btn-danger">حذف الكل</button>
                </form>
            </div>
        </div>

        @else
            <p class="text-muted mt-3">لا توجد منتجات في السلة.</p>
        @endif
    </div>
</div>
@endsection
