<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\NameModel;

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

        return response()->json(['names' => $names], 200);
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

        $nameCreated = DB::table('name_table')->insert(['name' => $name]);

        if(!$nameCreated)
            return response()->json(['error' => 'Name not created'], 500);

        return response()->json(['message' => 'Created', 'name' => $nameCreated], 200);
    }

    public function updateName(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
        ]);

        $name = $request->input('name');
        $code = $request->input('code');

        $nameUpdated = DB::table('name_table')->where('id', '=', $code)->limit(1)->update(['name' => $name]);

        if(!$nameUpdated)
            return response()->json(['error' => 'Name not updated'], 500);

        return response()->json(['message' => 'Updated', 'name' => $nameUpdated], 200);
    }

    public function deleteName(Request $request){
        $this->validate($request,[
            'code' => 'required',
        ]);

        $code = $request->input('code');

        $nameDeleted = DB::table('name_table')->where('id', '=', $code)->limit(1)->delete();

        if(!$nameDeleted)
            return response()->json(['error' => 'Name not deleted'], 500);

        return response()->json(['message' => 'Deleted', 'name' => $nameDeleted], 200);
    }
}
