<?php

namespace App\Http\Controllers;

use App\AiAnalysisLog;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    /**
     * フォーム表示画面
     * 
     */
    public function add(Request $req)
    {
        return view('add');
    }
    /**
     * フォームから取得した情報をDBへ保存
     * 
     */
    public function result(Request $req)
    {
    	// 入力チェック
        $validate = $this->createValidator($req->all());
        if ($validate->fails()) {
        	// エラー
	        $data = [
	            'msg'  => $validate->errors(),
	        ];
	        return view('result', $data);
        }
        // 画像解析APIをPOSTリクエスト
		$request_timestamp = new Carbon();
        //$server = 'localhost/api/mockup';	// ローカルテスト用
        $server = 'example.com';	// リモート用
        $url = 'http://'. $server .'?image_path=' . $req->image_path  ;
        $method = "POST";
        $client = new Client();
        $response = $client->request($method, $url);
        $postjson = $response->getBody();
        $post = json_decode($postjson, true);

        //レスポンス情報をDBへ追加更新
        $aiLog = new AiAnalysisLog();
        $aiLog->image_path = $req->image_path;
        $aiLog->success = $post['success'];
        $aiLog->message = $post['message'];
        if (NULL != $post['estimated_data'])
        {
	        $aiLog->class = $post['estimated_data']['class'];
	        $aiLog->confidence = $post['estimated_data']['confidence'];
        }
        $aiLog->request_timestamp = $request_timestamp->format('ymdHi');
		$response_timestamp = new Carbon();
        $aiLog->response_timestamp = $response_timestamp->format('ymdHi');
        $aiLog->save();
        
    	// 正常終了
        $data = [
            'msg'  => $post['message'] ,
        ];
        return view('result', $data);
	}

    /**
     * 入力チェック
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createValidator(array $data)
    {
        return Validator::make($data, [
            'image_path' => 'required|string|max:255',
        ]);
    }
}