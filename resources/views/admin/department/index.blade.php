<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello , {{ Auth::user()->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">ຂໍ້ມູນຕະລາງພະແນກ</div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ລໍາດັບ</th>
                                    <th scope="col">ຊື່ຜະແນກ</th>
                                    <th scope="col">UserID</th>
                                    <th scope="col">Create_At</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $row)
                                    <tr>
                                        <th>{{ $departments->firstItem() + $loop->index }}</th>
                                        <td>{{ $row->department_name }}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>
                                            @if ($row->created_at == null)
                                                ບໍ່ຖືກນິຍົມ
                                            @else
                                                {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('/department/edit/' . $row->id) }}"class="btn btn-primary">ແກ້ໄຂ</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/department/softdelete/' . $row->id) }}"class="btn btn-warning">ລົບຂໍ້ມູນ</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $departments->links() }}
                    </div>
                @if (count($trashDepartments)>0)
                <div class="card my-2">
                    <div class="card-header">Delete</div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ລໍາດັບ</th>
                                <th scope="col">ຊື່ຜະແນກ</th>
                                <th scope="col">UserID</th>
                                <th scope="col">Create_At</th>
                                <th scope="col">ກູ້ຂ້ມູນຄືນ</th>
                                <th scope="col">ລົບຂໍ້ມູນຖາວອນ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trashDepartments as $row)
                                <tr>
                                    <th>{{ $trashDepartments->firstItem() + $loop->index }}</th>
                                    <td>{{ $row->department_name }}</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>
                                        @if ($row->created_at == null)
                                            ບໍ່ຖືກນິຍົມ
                                        @else
                                            {{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/department/restore/' .$row->id)}}" class="btn btn-primary">ກູ້ຂໍ້ມູນຄືນ</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/department/delete/' .$row->id)}}" class="btn btn-danger">ລົບຂໍ້ມູນຖາວອນ</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$trashDepartments->links()}}
                </div>

                @endif

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">ແບບຟອມ</div>
                        <div class="card-body">
                            <form action="{{ route('addDepartment') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="departmen_name">ຊື່ພະແນກ</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger my-2">{{ $message }}</span>
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
