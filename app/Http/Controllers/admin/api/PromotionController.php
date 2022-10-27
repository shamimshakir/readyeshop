<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
         $user = Auth::user();
         $advimageurl = url($_SERVER['SERVER_NAME']) . '/images/promotion/';
       if($user!=''){
        $promotion = Promotion::with('pstatus')->get();
        if($promotion) {
            return response()->json(["status" => "success", "error" => false, "count" => count($promotion), 'url' => $advimageurl, "data" => $promotion], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no promotion found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no promotion found."], 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [            
            "image" => 'required| image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=672,height=310',
            "status" => 'required',
        ],
        [
          'image.required' => 'The : Image field can not be empty value.',
          'image.mimes' => 'Please upload valid image. Valid Image type jpeg,png,jpg,gif,svg ',
          'image.max'  => 'The maximun Size of The Image must not exceed :max ',
          'image.dimensions' => 'The dimensions of The Image must not exceed Width: :width,Height: :height',
        ]);

        if ($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(406);
        }

        try {
            if ($image = $request->file('image')) {
                $image = ImageUpload($request->file('image'), 'images/promotion/',672,310);
            }
                $promotion = Promotion::create([
                    "name" => $request->name,
                    "promotionpercent" => $request->promotionpercent,
                    "url" => $request->url,
                    "image" => $image,
                    "status" => $request->status,
                    "user_id" => Auth::user()->id,
                ]);
                return response()->json(["status" => "success", "error" => false, "message" => "Success! promotion created."], 201);
            
        } catch (Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = Auth::user();
        $advimageurl = url($_SERVER['SERVER_NAME']) . '/images/promotion/';
       if($user!=''){
        $promotion = Promotion::with('pstatus')->find($id);
        if($promotion) {
            return response()->json(["status" => "success", "error" => false,'url' => $advimageurl, "data" => $promotion], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Promotion found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no Promotion found."], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $promotion = Promotion::find($id);
        if ($promotion) {

            $validator = Validator::make($request->all(), [                
                "status" => 'required',
               //"image" => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=672,height=310',
            ]            
            );
            if ($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(406);
            }
            $images = $request->file('image');

            if ($images != '') {                
                $image = ImageUpload($request->file('image'), 'images/promotion/',672,310);
                $promotion['image'] = $image;
            }
            //return $request->name;
 
            $promotion['name'] = ($request->name==null) ? '' : $request->name;
            $promotion['promotionpercent'] =($request->promotionpercent==null) ? '' : $request->promotionpercent; 
            $promotion['status'] = $request->status;
            $promotion['url'] =($request->url==null) ? '' : $request->url;
            $promotion->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! promotion updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no promotion found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $promotion = Auth::user()->Promotion->find($id);
        if ($promotion) {
            $promotion->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! promotion deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no promotion found."], 404);
    }

    public function param(Request $request)
    {
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/promotion/';
        $promotion = Promotion::with('pstatus');

        if($request->id>0){
            $promotion = $promotion->where('promotions.id', '=', $request->id);
        }
        if($request->status>0){
            $promotion = $promotion->Where('promotions.status', '=', $request->status);
        }
        
        $promotion = $promotion->get();
        
        if($promotion) {
            return response()->json(["status" => "success", "error" => false, "count" => count($promotion),'url'=>$bdimageurl,"data" => $promotion], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no home page configs found."], 404);
        
    }
}
