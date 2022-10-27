<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class NewsController extends Controller
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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/news/';
        $News = News::with('Status')->get();
        if($News) {
            return response()->json(["status" => "success", "error" => false, "count" => count($News),'url'=>$bdimageurl,"data" => $News], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no News found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no News found."], 404);
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
            "news_title" => "required",
            "news_header" => "required",
            "news_detail" => "required",
            "news_status" => "required",
            "news_image" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors())->setStatusCode(422);
        }

        try {
            $image=ImageUpload($request->file('news_image'),'images/news/',612,445);
            $News = News::create([
                "news_title" => $request->news_title,
                "news_header" => $request->news_header,
                "news_detail" => $request->news_detail,
                "news_status" => $request->news_status,
                "news_image" => $image,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! News created."], 201);

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
        $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/news/';
        $News = News::with('Status')->where('news.id', '=', $id)->get();
        if($News) {
            return response()->json(["status" => "success", "error" => false, "count" => count($News),'url'=>$bdimageurl,"data" => $News], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no News found."], 404);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no News found."], 404);
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
        $News = News::find($id);
        if($user!='' && $News){

            $validator = Validator::make($request->all(), [
                "news_title" => "required",
                "news_header" => "required",
                "news_detail" => "required",
                "news_status" => "required",
                ]);
            if($validator->fails()) {
                return $this->validationErrors($validator->errors())->setStatusCode(422);
            }
            if($request->file('news_image')!=''){
               $image=ImageUpload($request->file('news_image'),'images/news/',612,445);
               $News['news_image'] = $image;
            }

            $News['news_title'] = $request->news_title;
            $News['news_header'] = $request->news_header;
            $News['news_detail'] = $request->news_detail;
            $News['news_status'] = $request->news_status;
            $News->save();

             return response()->json(["status" => "success", "error" => false, "message" => "Success! News updated."], 201);

        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no News found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $News = Auth::user()->Newss->find($id);
        if($News) {
            $News->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! News deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no News found."], 404);
    }


public function param(Request $request)
    {

    $bdimageurl= url($_SERVER['SERVER_NAME']).'/images/news/';
        $News = News::with('Status');
        if($request->id>0){
            $News = $News->where('news.id', '=', $request->id);
        }
        if($request->news_title!=''){
            $News = $News->where('news.news_title', 'like', '%' . $request->title .'%');
        }
        if($request->news_status>0){
            $News = $News->where('news.news_status', '=', $request->news_status);
        }
        $News = $News->get();    
        if($News) {
            return response()->json(["status" => "success", "error" => false, "count" => count($News),'url'=>$bdimageurl,"data" => $News], 200);
        }
            return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no News found."], 404);
    }

}
