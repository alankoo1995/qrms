<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\CodeModel;
use App\Http\Model\User;
include('resources/org/qrcode/phpqrcode.php');

class IndexController extends Controller
{	
	static function create_url($data){
		$str = 'http://'.$data['ga_original_url'].'?'.'utm_tag='.$data['tag'].'&'.'utm_source='.$data['ga_source'].'&'.'utm_medium='.$data['ga_medium'].'&'.'utm_name='.$data['ga_name'].'&'.'utm_term='.$data['ga_term'].'&'.'utm_content='.$data['ga_content'];
		return $str;
	}
	// public function crypt(){
	// 	$users = User::all();
	// 	$str = '123456';
	// 	echo Crypt::encrypt($str);
	// }
	public function login(){
		if($input = Input::all()){
			$name = $input['username'];
			$users = new User();
			if($user = $users->where('name',$name)->first()){
				if($user->flag !=1)
					return back()->with('msg','incorrect');
				if(Crypt::decrypt($user->pwd) != $input['password'])
					return back()->with('msg','incorrect');
				session(['user'=>$user]);
				// dd(session('user'));
				return redirect('/'); #跳转页面
			}
			return back()->with('msg','incorrect');
		}
		return view('login');
	}
	public function logout(){
		session(['user'=>null]);
		return redirect('login');
	}
	public function index(){
		$qr_code = new CodeModel;
		$code_list = $qr_code->get();
		// dd($code_list);
		return view('index')->with('code_list',$code_list);
	}
	public function add(){
		if($input=Input::all()){
			$rules = ['tag'=>'required','ga_original_url'=>'required','ga_source'=>'required','ga_medium'=>'required','ga_name'=>'required','ga_term'=>'required','ga_content'=>'required'];
			$message=['required'=>'Every fields(except Note) should be filled.'];
			$validator = Validator::make($input,$rules,$message);
			if($validator->passes()){
				$created_url = self::create_url($input);
				$qr_code = new CodeModel;
				$qr_code->insertGetId([
				'tag'=>$input['tag'],
				'ga_original_url'=>$input['ga_original_url'],
				'ga_source'=>$input['ga_source'],
				'ga_medium'=>$input['ga_medium'],
				'ga_name'=>$input['ga_name'],
				'ga_term'=>$input['ga_term'],
				'ga_content'=>$input['ga_content'],
				'note'=>$input['note']?$input['note']:'', #不能不存在，至少空字符串..
				'created_url'=>$created_url,
				'created_date'=>date('y-m-d h:i:s',time()),
				]);
				return back()->with('success','success');
				// dd($_qr_code);
			}else{
				return back()->withErrors($message);
			}
			
		}
		else{
			return view('add');
		}
	}
	public function update($id){
		$qr_code = new CodeModel;
		$code_list = $qr_code->get();
		$classN = 'active';
		// dd($code_list);
		if($input=Input::all()){
			$rules = ['tag'=>'required','ga_original_url'=>'required','ga_source'=>'required','ga_medium'=>'required','ga_name'=>'required','ga_term'=>'required','ga_content'=>'required'];
			$validator = Validator::make($input,$rules);
			if($validator->passes()){
				$created_url = self::create_url($input);
				CodeModel::where('id',$id)->update(Input::except('_token','note'));
				CodeModel::where('id',$id)->update(['note'=>$input['note']?$input['note']:'','created_url'=>$created_url]);
				#这里数据对象还没更新
				$qr_code = new CodeModel; 
				$code_list = $qr_code->get();
				// dd($code_list);
				#blade 一旦生成就会产生缓存，后面都是从这里读的
				// Cache::flush();
				return back()->with('success','success');
			}else{
				return back()->withErrors('error');
			}
		}else{
			return view('update',compact('code_list','id'));
		}
	}
	// public function test(){
	// 	return CodeModel::where('id',1)->update(["ga_source"=>'e']); #将$timestamps 置为false就可以正常运作了
	// }
	public function delete($id){
		if(empty(CodeModel::where('id',$id)))
			return back();
		CodeModel::where('id',$id)->update(['flag'=>0]);
		return back();
	}
	public function download($id){
		if(empty(CodeModel::where('id',$id)))
			return back();
		$qr_code = CodeModel::where('id',$id)->get();
		$url = $qr_code[0]->created_url;#因为返回的是一个数组($qr_code)，所以需要先指定
		// dd($url);
		// require_once 'resources/org/qrcode/phpqrcode.php'; #引入第三方库
		#链接需要加http才可以在微信中直接访问
		// dd($qr_code->created_url->get());
		// $url=$qr_code->created_url;
		// $file_id=$id;
		$errorCorrectionLevel = 'H';
		$matrixPointsize = 6;
		// $filename = 'resources/files/'.$file_id.'.png';
		#使用 \ 才可以正常使用...
		\QRcode::png($url,false,$errorCorrectionLevel,$matrixPointsize,2);
		exit();
		// $logo_path = 'resources/files/logo/logo.png';
		// if(file_exists($logo_path)){
		// 	$file = imagecreatefromstring(file_get_contents($filename));
		// 	$logo = imagecreatefromstring(file_get_contents($logo_path));
		// 	$qr_width = imagesx($file);
		// 	$qr_height = imagesy($file);
		// 	$logo_width = imagesx($logo);
		// 	$logo_height = imagesy($logo);
		// 	$logo_qr_width = $qr_width/4;
		// 	$scale = $logo_width/$logo_qr_width;
		// 	$logo_qr_height = $logo_height/$scale;
		// 	$logo_origin_width = ($qr_width - $logo_qr_width)/2;
		// 	imagecopyresampled($file,$logo,$logo_origin_width,$logo_origin_width,0,0,$logo_qr_width,$logo_qr_height,$logo_width,$logo_height);
		// }
		// imagepng($file,'qrcode.png'); #文件地址
		// // imagedestroy($file);
		// imagedestroy($logo);
	}
	// public function download($id){
	// 	\QRcode::png('PHP QR Code','123.png');
	// }
	public function recycle(){
		return view('recycle')->with('code_list',CodeModel::get());
	}
	public function rollback($id){
		if(empty(CodeModel::where('id',$id)))
			return back()->withErrors('error');
		CodeModel::where('id',$id)->update(['flag'=>1]);
		return back()->with('success','success');
	}
	public function uac(){
		$users = new User();
		if($input=Input::all()){
			$user = $users->where('id',$input['id'])->first(); #first()很重要
			if(Crypt::decrypt($user->pwd) != $input['cur_password'])
				return back()->with('msg','incorrect password');
			$new_md5_password = Crypt::encrypt($input['new_password']);
			User::where('id',$input['id'])->update(['pwd'=>$new_md5_password]); #update只能用静态方法取得
			return back()->with('msg','update success');
		}else{
			return view('uac')->with('users',$users->get()); #get() 才能取得数据，不然只是空数组
		}
	}
	public function deleteUser($id){
		if($id==1)
			return back()->with('msg','admin can not be deleted');
		if(empty(User::where('id',$id)))
			back();
		User::where('id',$id)->update(['flag'=>0]);
		return back();
	}
	public function rollbackUser($id){
		if(empty(User::where('id',$id)))
			return back();
		User::where('id',$id)->update(['flag'=>1]);
		return back();
	}
	public function addUser(){
		if($input=Input::all()){
			$rule = ['username'=>'required','password'=>'required'];
			$validator = Validator::make($input,$rule);
			if(!$validator->passes()){
				return back()->with('msg','username or password is required');
			}
			User::insertGetId([
				'name'=>$input['username'],
				'pwd'=>Crypt::encrypt($input['password']),
				'date'=>date('y-m-d, h:i:s',time())
				]);
			return back()->with('msg','added');
		}
	}
}
