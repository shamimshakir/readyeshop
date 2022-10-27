<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;
use Image;

class AboutUsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = Auth::user();
		if ($user != '') {
			$advimageurl = url($_SERVER['SERVER_NAME']) . '/images/about_us/';
			$aboutUs = AboutUs::select("about_us.id",
				"about_us.au_description",
				"about_us.short_description",
				"about_us.au_image",
				"about_us.user_id",
				"about_us.created_at",
				"about_us.updated_at"
			)
				->get();
			if ($aboutUs) {
				return response()->json(["status" => "success", "error" => false, "count" => count($aboutUs), 'url' => $advimageurl, "data" => $aboutUs], 200);
			}
			return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no aboutUs found."], 404);
		}
		return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no aboutUs found."], 404);
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
			"au_description" => "required|min:3|unique:about_us,au_description",
			"short_description" => "required",
			"au_image" => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		if ($validator->fails()) {
			return $this->validationErrors($validator->errors())->setStatusCode(406);
		}

		try {
			if ($image = $request->file('au_image')) {
				$comp_image = ImageUpload($request->file('au_image'), 'images/about_us/');

				$aboutUs = AboutUs::create([
					"au_description" => $request->au_description,
					"short_description" => $request->short_description,
					"au_image" => $comp_image,
					"user_id" => Auth::user()->id,
				]);
				return response()->json(["status" => "success", "error" => false, "message" => "Success! aboutUs created."], 201);
			}
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
		if ($user != '') {
			$advimageurl = url($_SERVER['SERVER_NAME']) . '/images/about_us/';
			$aboutUs = AboutUs::select("about_us.id",
				"about_us.au_description",
				"about_us.short_description",
				"about_us.au_image",
				"about_us.user_id",
				"about_us.created_at",
				"about_us.updated_at"
			)
				->where('about_us.id', '=', $id)
				->get();
			if ($aboutUs) {
				return response()->json(["status" => "success", "error" => false, 'url' => $advimageurl, "count" => count($aboutUs), "data" => $aboutUs], 200);
			}
			return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no aboutUs found."], 404);
		}
		return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no aboutUs found."], 404);
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
		$aboutUs = AboutUs::find($id);
		if ($aboutUs) {

			$validator = Validator::make($request->all(), [
				"au_description" => "required",
				"short_description" => "required",

			]);
			if ($validator->fails()) {
				return $this->validationErrors($validator->errors())->setStatusCode(406);
			}
			$image = $request->file('au_image');

			if ($image != '') {
				$files = glob($_SERVER['SERVER_NAME'].'images/about_us/*');
				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					}
				}
				$comp_image = ImageUpload($request->file('au_image'), 'images/about_us/');
				$aboutUs['au_image'] = $comp_image;
			}

			$aboutUs['au_description'] = $request->au_description;
			$aboutUs['short_description'] = $request->short_description;
			$aboutUs->save();
			return response()->json(["status" => "success", "error" => false, "message" => "Success! aboutUs updated."], 201);

		}
		return response()->json(["status" => "failed", "error" => true, "message" => "Failed no aboutUs found."], 404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$aboutUs = Auth::user()->about_us->find($id);
		if ($aboutUs) {
			$aboutUs->delete();
			return response()->json(["status" => "success", "error" => false, "message" => "Success! aboutUs deleted."], 200);
		}
		return response()->json(["status" => "failed", "error" => true, "message" => "Failed no aboutUs found."], 404);
	}

	public function param() {
		
			$advimageurl = url($_SERVER['SERVER_NAME']) . '/images/about_us/';
			$aboutUs = AboutUs::select("about_us.id",
				"about_us.au_description",
				"about_us.short_description",
				"about_us.au_image",
				"about_us.user_id",
				"about_us.created_at",
				"about_us.updated_at"
			)
				->get();
			if ($aboutUs) {
				return response()->json(["status" => "success", "error" => false, "count" => count($aboutUs), 'url' => $advimageurl, "data" => $aboutUs], 200);
			}
			return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no aboutUs found."], 404);
		
	}
}
