<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\TreeEntry;
use App\Models\ProfilePermission;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfilePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
       $user = Auth::user();
       if($user!=''){
        $profilePermission =DB::select("SELECT id,
                                   pid,
                                   nodename,
                                   (SELECT Count(pid)
                                    FROM   tree_entries AS test
                                    WHERE  test.pid = tree_entries.id
                                           AND test.nodename <> '') AS haschild,
                                   per.view,
                                   per.add,
                                   per.edit,
                                   per.delete
                            FROM   tree_entries
                                   LEFT JOIN(SELECT view AS sid,
                                                    IFNULL(`view`, 0 ) as `view` ,
                                                    IFNULL(`add`, 0 ) as `add`,
                                                    IFNULL(`edit`, 0 ) as `edit`,
                                                    IFNULL(`delete`, 0 )as `delete`
                                             FROM   profile_permissions
                                             WHERE  profile_id = $id) AS per
                                          ON per.sid = tree_entries.id
                            WHERE  tree_entries.nodename <> ''
                            ORDER  BY tree_entries.sl ");
        
        if($profilePermission) {
            return response()->json(["status" => "success", "error" => false, "data" => $profilePermission], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Profile Profile found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Profile Profile found."], 404);


        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pupdate(Request $request)
    {
        //
        $user = Auth::user();       
        if($user!=''){

            $validator = Validator::make($request->all(), [
                "profile_id" => "required"
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

             DB::table('profile_permissions')
            ->where('profile_id',$request->profile_id)
            ->delete();
            $views=$request->views;
            sort($views);
            foreach($views as $i => $view){
                $pp = ProfilePermission::create([
                "profile_id" =>$request->profile_id,
                "view" =>$view,
                "add" => $request->adds[$i] ?? 0,
                "edit" => $request->edits[$i] ?? 0,
                "delete" => $request->deletes[$i] ?? 0,
                "user_id" => Auth::user()->id,
                ]);
            }
           
             return response()->json(["status" => "success", "error" => false, "message" => "Success! Update Permission."], 201);
                      
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed To update permission."], 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
