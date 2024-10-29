<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
     // size list 
     public function List(){
        $data['list']=DB::table('size')->get();
        return view("admin.size.list")->with($data);
    }

    //show size create page
    public function create(){
        
        // return $data['category_list'];exit;
        return view('admin.size.create');
    }

    // store category
    public function store(Request $request){
        
       
        $size = $request->size;
       
        
        
       $insert= DB::table('size')->insert([
            'size' =>$size,
            
            
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'size created successfully!',
           ]);

        }
       
        

        


    }

    // size update page
    public function update_page($id){
        $data['size_info']=DB::table('size')->where('id', $id)->first();
        return view('admin.size.edit')->with($data);
    }

    // update size
    public function update(Request $request){
        
        $size = $request->size;
        $update = DB::table('size')->where('id', $request->id)->update([
            'size' => $size,
        ]);
       
        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'size updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete size
    public function delete($id){
       
        $delete=DB::table('size')->where('id', $id)->delete();
        if ($delete) {
            return response([
                'status' =>true,
                'message'=>"Successfully Delete"
            ]);
        } else {
            return response([
                'status' =>false,
                'message'=>"Not deleted"
            ]);
        }
        
    }

    //size status update
    public function status($id){
        $size_id=DB::table('size')->where('id', $id)->first();
        if ($size_id->status==1) {
            
           $update= DB::table('size')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($size_id->status==0) {
            $get_status=DB::table('size')->where('status',1)->get();
            if (!$get_status->isEmpty()) {
              
                return response([
                    'status' =>false,
                    'message' =>'Unable to activate this item because another one is already active.'
                   
                ]);
            } else {
                $update= DB::table('size')->where('id', $id)->update([
                    'status'    =>1,
               ]);
            }
            
            
            
        }
        if ($update) {
            return response([
                'status' =>true,
                'message' =>'successfully Update'
               
            ]);
        }else {
            return response([
                'status' =>false,
                'message' =>'Update Fail',
               
            ]);
        }

    }
}
