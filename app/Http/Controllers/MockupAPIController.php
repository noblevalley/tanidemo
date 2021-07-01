<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockupAPIController extends Controller
{
	public function index(Request $req)
	{
	    //リクエスト失敗
		$success = false;
		$message = 'Error:E50012';
		$estimated_data = [];
		if (strpos($req->image_path,'.jpg') !== false)
		{
			//jpgファイルのみ
		    //リクエスト成功
			$success = true;
			$message = 'success';
			$estimated_data = [
				'class' => 3
				,'confidence' => 0.8683
			];
		}
		$json = [
		'success' => $success
		,'message' => $message
		,'estimated_data' => $estimated_data
		];
		return json_encode($json, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE |JSON_PRETTY_PRINT);
	}
}