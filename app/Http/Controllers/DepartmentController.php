<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(){
        $departments=Department::paginate(5);
        $trashDepartments=Department::onlyTrashed()->paginate(3);
       return view( 'admin.department.index' ,compact( 'departments' ,'trashDepartments'));
    }

     public function store(Request $request) {

           $request->validate([
            'department_name' => 'required | unique:departments|max:255'

           ],
        [
          'department_name.required'=>"ປ້ອນຊື່ພະແນກ",
          'department_name.max'=>"ຫ້າາມປ້ອນກາຍ 255 ໂຕ",
          'department_name.unique'=>"ມີຊື່ແຜນຂ້ມູນນີ້ໃນຖານໍ້ມູນແລ້ວ"
        ]
        );
        //bun thue khr moun
        $data = array();
        $data ["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        //queery builder
        DB::table('departments')->insert($data);

        return redirect()->back()->with ('success',"ຂໍ້ມູນໄດ້ຖືກບັນທຶກແລ້ວ");
      }
            public function edit($id){
                 $department=Department::find($id);
                return view ('admin.department.edit',compact('department'));

            }

            public function update(Request $request ,$id){
                           //  dd($id,$request->department_name);
                           $request->validate([
                            'department_name' => 'required | unique:departments|max:255'

                           ],
                        [
                          'department_name.required'=>"ກາລຸນາປ້ອນຊື່ພະແນກ",
                          'department_name.max'=>"ຫ້າາມປ້ອນກາຍ 255 ໂຕ",
                          'department_name.unique'=>"ມີຊື່ແຜນຂ້ມູນນີ້ໃນຖານໍ້ມູນແລ້ວ"
                        ]
                        );
                       $update = Department::find($id)->update([
                            'department_name'=>$request->department_name,
                            'user_id'=>Auth::user()->id
                        ]);
                        return redirect()->route('department')->with('success'," ອັບເດດມູນຮຽບຮ້ອຍ");
            }
            public function softdelete($id){
                          $delete = Department::find($id)->delete();
                          return redirect()->route('department')->with('success',"ລົບຂ້ມູນຮຽບຮ້ອຍ");

            }
            public function restore($id){
                       $restore = Department::withTrashed()->find($id)->restore();
                       return redirect()->back()->with('success',"ກູ້ຄືນຂ້ມູນຮຽບຮ້ອຍ");


            }
            public function delete($id){
                $delete=Department::onlyTrashed()->find($id)->forceDelete();
                return redirect()->back()->with('success',"ລົບຂ້ມູນຖາວອນຮຽບຮ້ອຍ");
            }

    }


