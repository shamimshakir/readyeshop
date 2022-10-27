<?php

namespace App\Http\Controllers\admin\api;

use App\Models\TreeEntry;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TreeEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
       if($user!=''){
        $treeentrys = TreeEntry::with('statuses')->get();
        if($treeentrys) {
            return response()->json(["status" => "success", "error" => false, "count" => count($treeentrys),"data" => $treeentrys], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
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
        $validator = Validator::make($request->all(), [
            "NodeName" => "required|min:3|unique:tree_entries,NodeName",
            "route_name" => "required",
            "route_location" => "required",
            "view_status" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }
        try {
            $treeentrys = TreeEntry::create([
                "pid" => $request->pid,
                "NodeName" => $request->NodeName,
                "others_lan" => $request->others_lan,
                "route_name" => $request->route_name,
                "route_location" => $request->route_location,
                "icon" => $request->icon,
                "view_status" => $request->view_status,
                "sl" => $request->sl,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! tree entries created."], 201);
        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
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

        $treeentrys = TreeEntry::with('statuses')->where('tree_entries.id', '=', $id)->get();
        if($treeentrys) {
            return response()->json(["status" => "success", "error" => false, "count" => count($treeentrys),"data" => $treeentrys], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
    }

    public function treemenu()
    {
        $user = Auth::user();
       if($user!=''){

        // $treeentrys = TreeEntry::with("children")->where('pid',0)->where('view_status','=',1)->orderBy('sl')->get();


        $profile_id=$user->user_profile_id;
        $treeentrys = TreeEntry::join(DB::raw('( SELECT
                                            view
                                        FROM
                                            profile_permissions
                                        WHERE
                                            profile_id = '.$profile_id.')
                               t1'), 
                        function($join)
                        {
                           $join->on('tree_entries.id', '=', 't1.view');
                        })
                        ->where('pid',0)
                        ->where('view_status','=',1)
                        ->orderBy('sl')
                        ->with([
                            'children' => function($q)  use ($profile_id) {
                                $q
                                ->join(DB::raw('( SELECT
                                              view
                                            FROM
                                                profile_permissions
                                            WHERE
                                                profile_id = '.$profile_id.')
                                           t1'), 
                                    function($join)
                                    {
                                       $join->on('tree_entries.id', '=', 't1.view');
                                    });
                            }
                        ])
                        ->get();

        if($treeentrys) {
            return response()->json(["status" => "success", "error" => false, "data" => $treeentrys], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
    }

    public function treemenu_new()
    {
       $user = Auth::user();
       
       if($user!=''){

        $profile_id=$user->user_profile_id;
        $treeentrys = TreeEntry::join(DB::raw('( SELECT
                                            view
                                        FROM
                                            profile_permissions
                                        WHERE
                                            profile_id = '.$user->user_profile_id.')
                               t1'), 
                        function($join)
                        {
                           $join->on('tree_entries.id', '=', 't1.view');
                        })
                        ->where('pid',0)
                        ->where('view_status','=',1)
                        ->orderBy('sl')
                        ->with([
                            'children' => function($q)  use ($profile_id) {
                                $q
                                ->join(DB::raw('( SELECT
                                              view
                                            FROM
                                                profile_permissions
                                            WHERE
                                                profile_id = '.$profile_id.')
                                           t1'), 
                                    function($join)
                                    {
                                       $join->on('tree_entries.id', '=', 't1.view');
                                    });
                            }
                        ])
                        ->get();

                        

        if($treeentrys) {
            return response()->json(["status" => "success", "error" => false, "data" => $treeentrys], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no tree entries found."], 404);
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
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $treeentrys = TreeEntry::find($id);
        if($user!='' && $treeentrys){
            $validator = Validator::make($request->all(), [
                "NodeName" => "required",

                "view_status" => "required"
                ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }

            $treeentrys['pid'] = $request->pid;
            $treeentrys['NodeName'] = $request->NodeName;
            $treeentrys['route_name'] = $request->route_name;
            $treeentrys['route_location'] = $request->route_location;
            $treeentrys['icon'] = $request->icon;
            $treeentrys['view_status'] = $request->view_status;
            $treeentrys['sl'] = $request->sl;
            $treeentrys->save();

            return response()->json(["status" => "success", "error" => false, "message" => "Success! tree entries updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no tree entries found."], 404);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $treeentrys = Auth::user()->treeentrys->find($id);
        if($treeentrys) {
            $treeentrys->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! tree entries deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no tree entries found."], 404);
    }
}
