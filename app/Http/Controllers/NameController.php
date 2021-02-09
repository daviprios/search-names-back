<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NameController extends Controller
{
    public function getNames(Request $request){
        $name = $request->input('name');
        $names = [];
        
        if(!$name){
            $names = $this->_getAllNames();
        }
        else{
            $names = $this->_getAlikeNames($name);
        }

        return response()->json(['code' => 'success', 'message' => 'Searched', 'names' => $names], 200);
    }
    
    function _getAllNames(){
        $names = DB::table('name_table')->get('*');
        return [...$names];
    }

    function _getAlikeNames($name){
        $names = DB::table('name_table')->where('name', 'like', "%{$name}%")->get('*');
        return [...$names];
    }

    public function createName(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);

        $name = $request->input('name');

        $nameCreated = DB::table('name_table')->insert(['name' => $name, 'updated_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')]);

        if(!$nameCreated)
            return response()->json(['code' => 'error', 'message' => 'Name not created'], 500);

        return response()->json(['code' => 'success', 'message' => 'Created'], 200);
    }

    public function updateName(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
        ]);

        $name = $request->input('name');
        $code = $request->input('code');

        $nameUpdated = DB::table('name_table')->where('id', '=', $code)->limit(1)->update(['name' => $name, 'updated_at' => date('Y-m-d H:i:s')]);

        if(!$nameUpdated)
            return response()->json(['code' => 'error', 'message' => 'Name not updated'], 500);

        return response()->json(['code' => 'success', 'message' => 'Updated'], 200);
    }

    public function deleteName(Request $request){
        $this->validate($request,[
            'code' => 'required',
        ]);

        $code = $request->input('code');

        $nameDeleted = DB::table('name_table')->where('id', '=', $code)->limit(1)->delete();

        if(!$nameDeleted)
            return response()->json(['code' => 'error', 'message' =>'Name not deleted'], 500);

        return response()->json(['code' => 'success', 'message' => 'Deleted'], 200);
    }
}
