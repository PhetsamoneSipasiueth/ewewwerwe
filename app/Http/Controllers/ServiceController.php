<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index(){
        $services=Service::paginate(5);
        return view('admin.service.index',compact('services'));
    }

    public function edit($id){
        $service = Service::find($id);
        return view('admin.service.edit',compact('service'));
    }

    public function update(Request $request , $id){
        //ตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name'=>'required|max:255',
            ],
            [
                'service_name.required'=>"ກະລຸນາປ້ອນຊື່ບໍລິການນຳເຈົ້າ",
                'service_name.max' => "ຫ້າມປ້ອນເກີນ 255 ໂຕອັກສອນ",
            ]
        );

        $service_image = $request->file('service_image');
        //อัพเดตภาพและชื่อ
        if($service_image){

            //Generate ชื่อภาพ
            $name_gen=hexdec(uniqid());
             // ดึงนามสกุลไฟล์ภาพ
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;


            //อัพโหลดและอัพเดตข้อมูล
            $upload_location = 'image/services/';
            $full_path = $upload_location.$img_name;


            //อัพเดตข้อมูล
            Service::find($id)->update([
                'service_name'=>$request->service_name,
                'service_image'=>$full_path,
            ]);

            //ลบภาพเก่าและอัพภาพใหม่แทนที่
            $old_image = $request->old_image;
            unlink($old_image);
            $service_image->move($upload_location,$img_name);

            return redirect()->route('services')->with('success',"ອັບເດດຮູບພາບຮຽບຮ້ອຍ");

        }else{
            //อัพเดตชื่ออย่างเดียว
            Service::find($id)->update([
                'service_name'=>$request->service_name,
            ]);
            return redirect()->route('services')->with('success',"ອັບເດດຊື່ບໍລິການຮຽບຮ້ອຍ");
        }

    }

    public function store(Request $request){
        //ตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name'=>'required|unique:services|max:255',
                'service_image'=>'required|mimes:jpg,jpeg,png'
            ],
            [
                'service_name.required'=>"ກະລຸນາປ້ອນຊື່ຮູບພາບນຳເຈົ້າ",
                'service_name.max' => "ຫ້າມປ້ອນເກີນ 255 ໂຕອັກສອນ",
                'service_name.unique'=>" ມີຊື່ຂໍ້ມູນຊື່ບໍລິການນີ້ໃນຖານຂໍ້ມູນແລ້ວ ",
                'service_image.required'=>" ກະລຸນາເລືອກນຳເຈົ້າ",
            ]
        );

        //การเข้ารหัสรูปภาพ
        $service_image = $request->file('service_image');

        //Generate ชื่อภาพ
        $name_gen=hexdec(uniqid());
        // ดึงนามสกุลไฟล์ภาพ
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;


        //อัพโหลดและบันทึกข้อมูล
        $upload_location = 'image/services/';
        $full_path = $upload_location.$img_name;

        Service::insert([
            'service_name'=>$request->service_name,
            'service_image'=>$full_path,
            'created_at'=>Carbon::now()
        ]);
        $service_image->move($upload_location,$img_name);
        return redirect()->back()->with('success',"ບັນທຶກຂໍ້ມູນຮຽບຮ້ອຍ");
    }

    public function delete($id){
        // ลบภาพ
        $img = Service::find($id)->service_image;
        unlink($img);

        //ลบข้อมูลจากฐานข้อมูล
        $delete=Service::find($id)->delete();
        return redirect()->back()->with('success',"ລົບຂໍ້ມູນຮຽບຮ້ອຍ");
}
}
