<?php

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});





Route::get('record/{id}',function($id){
	$record = App\Record::findOrFail($id);
	return json_encode(["record"=>$record,"message"=>"Record consultado con id = {$id}"]);
});


Route::post('rec',function(Request $request){

		$rules =[
	    'temp' => 'required|digits_between:1,5|numeric',
	    'humidity' => 'required|digits_between:1,5|numeric',
	    'co2' => 'required|digits_between:1,5|numeric',
		];

       $validator = \Validator::make($request->all(),$rules);

		if ($validator->fails()) {
		   return response()->json($validator->errors(), 422);
		}

	$record = new App\Record;
	$record->temp = $request->input('temp');
	$record->humidity = $request->input('humidity');
	$record->co2 = $request->input('co2');
	$record->save();
	return json_encode(["record"=>$record,"message"=>"Registrado correctamente!"]);
});




Route::get('records',function(){
	$records = App\Record::orderBy('id', 'ASC')->get();
	return json_encode($records);
});





Route::put('record/{id}',function(Request $request,$id){

	$rules =[
	    'temp' => 'required|digits_between:1,5|numeric',
	    'humidity' => 'required|digits_between:1,5|numeric',
	    'co2' => 'required|digits_between:1,5|numeric',
		];

       $validator = \Validator::make($request->all(),$rules);

		if ($validator->fails()) {
		   return response()->json($validator->errors(), 422);
		}


	$record = App\Record::findOrFail($id);
	$record->temp = $request->input('temp');
	$record->humidity = $request->input('humidity');
	$record->co2 = $request->input('co2');
	$record->update();
	return json_encode($record);
});

Route::delete('record/{id}',function($id){
	$record = App\Record::findOrFail($id);
	$record->delete();
	return json_encode(['message'=>"Tu record fue eliminado!"]);
});



Route::middleware(['jwt.auth'])->group(function(){
	Route::get('users','UserController@index');

});


Route::post('login','AuthenticateController@authenticate');