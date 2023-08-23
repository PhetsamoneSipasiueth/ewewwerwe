<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ສະບາຍດີ , {{Auth::user()->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session("success"))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">ຕາຕະລາງຂໍ້ມູນບໍລິການ</div>
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">ລຳດັບ</th>
                            <th scope="col">ຮູບພາບ</th>
                            <th scope="col">ຊື່ບໍລິການ</th>
                            <th scope="col">Created_At</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $row)
                            <tr>
                                <th>{{$services->firstItem()+$loop->index}}</th>
                                <td>
                                    <img src="{{asset($row->service_image)}}" alt="" width="100px" height="100px">
                                </td>
                                <td>{{$row->service_name}}</td>
                                <td>
                                    @if($row->created_at == NULL)
                                         ບໍ່ຖືກນິຍາມ
                                    @else
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('/service/edit/'.$row->id)}}" class="btn btn-primary">ແກ້ໄຂ</a>
                                </td>
                                <td>
                                    <a href="{{url('/service/delete/'.$row->id)}}"
                                    class="btn btn-warning"
                                    onclick="return confirm(' ເຈົ້າຕ້ອງການລົບຂໍ້ມູນບໍລິການນີ້ແທ້ບໍ່ ?')"
                                    >ລົບຂໍ້ມູນ</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        {{$services->links()}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">ແບບຟ້ອມບໍລິການ</div>
                        <div class="card-body">
                            <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ຊື່ບໍລິການ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="service_image">ພາບປະກອບ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <br>
                                <input type="submit" value="ບັນທຶກ" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
