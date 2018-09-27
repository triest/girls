<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Input;
use App\Region;
use App\City;
use App\Girl;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome-test', function () {
    return view('welcome-test');
});

Route::get('/girls', 'GirlsController@index')->name('main');
Route::get('/girls2','GirlsController@index2')->name('main2');
Route::get('/girls/{id}', 'GirlsController@showGirl')->name('showGirl');

Route::get('/test','GirlsController@test');

Route::get('/test2','GirlsController@test2');

Route::post('/test2','GirlsController@test2');

//пользователь соглашение
Route::get('/Terms','GirlsController@showTerms')->name('showTerms');
Route::get('/createGirlPage','GirlsController@createGirl')->name('createGirlPage');
Route::post('/girls/create','GirlsController@Store')->name('girlsCreate');



Route::post('/girls/payer','GirlsController@payeer')->name('payeer');
Route::post('/success','GirlsController@payeerSucces')->name('payeer');
Route::post('/obr','GirlsController@obr')->name('payeer');

//яндекс денги
//Route::post('/recivedYandexMoney','GirlsController@reciverYandex')->name('recivedYandex');
//Route::post('/yandex','GirlsController@reciverYandexGet')->name('recivedYandexGet');
/*Route::get('/yandex',function (){return response('hello Word',200)
    ->header('Content-Type','text/plain');
});*/
/*
Route::post('/yandex',function (){return response('hello Word',200)
    ->header('Content-Type','text/plain');
});*/

Route::post('/yandex','GirlsController@reciverYandex')->name('yandexPost');

//форма таетирования
Route::get('/testpost',function (){
    return view('testPost');
});



//аутентииакация
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('autorization');
Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('auth/logout', 'Auth\AuthController@logout')->name('logout')->middleware('auth');;
Route::get('/user/anketa', 'GirlsController@girlsShowAuchAnket')->name('girlsShowAuchAnket');

// Маршруты регистрации...
Route::get('auth/register', 'Auth\RegisterController@getRegister')->name('registration');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Auth::routes();

//тут для работы с анкетой за деньги
Route::get('/firtPlase/{id}', 'GirlsController@toFirstPlace')->name('TofirstPlase');
Route::post('/toTop/', 'GirlsController@toTop')->name('ToTop');

Route::get('/testmail','GirlsController@testMail');




// для администратора
Route::get('/adminPanel', 'GirlsController@getAdminPanel')->name('adminPanel');
Route::post('/SetPriceToFirstPlase/', 'GirlsController@SetPriceToFirstPlase')->name('SetToFirstPlase');
Route::post('/SetPriceToTop/', 'GirlsController@SetPriceToTop')->name('SetToTopPrice');


//почта
Route::get('/testmail', 'GirlsController@testemail');


//Route::get('/confirnEmail','GirlsController@confirm')->name('confirm-email');

Route::get('/confirnEmail','GirlsController@MailtoConfurn')->name('sendConfurmEmail');

Route::get('/user/confernd/{token}','GirlsController@conferndEmail')->name('conferndEmail');

//смс
Route::get('/sms', 'GirlsController@sendmail');

//ввод номера телефона
Route::get('/inputphone',function (){return view('inputphone');})->name('inputMobile');

Route::post('/inputPhone', 'GirlsController@inputPhone')->name('inputMobilePhone');
Route::post('/inputCode', 'GirlsController@inputActiveCode')->name('inputActiveCode');

//тут путь для правил
Route::get('/rules',function (){return view('rules');})->name('rules');
Route::post('/rules2','GirlsController@akceptRules')->name('aceptRules');

//ввод телефона без ререхода
//Route::get('/inputPhone2', 'GirlsController@inputPhone2')->name('inputMobilePhone2');

Route::get('/user/anketa/edit/', 'GirlsController@girlsEditAuchAnket')->name('girlsEditAuchAnket');
Route::post('/user/anketa/edit/', 'GirlsController@edit')->name('girlsEdit');

//бот
Route::get('/bot', 'GirlsController@bot')->name('bot');

//галерея
Route::get('/galeray','GirlsController@galarayView')->name('galeray');
Route::get('/image/delete/{imege}','GirlsController@deleteimage')->name('deleteImage');
Route::post('/image/upload','GirlsController@uploadimage')->name('uploadImage');
Route::post('/image/main/upload','GirlsController@uploadMainimage')->name('uploadMainImage');

Route::get('/message','MessagesController@GetMessagesPage');

Route::get('/cityes','GirlsController@getSearch');

//for dropdown
Route::get('/prodview','TestController@prodfunct');
Route::get('/findProductName','TestController@findProductName');
Route::get('/findPrice','TestController@findPrice');

//Route::get('/findRegions/{id}','GirlsController@findRegions');
Route::get('/findRegions',function (){
    $id=Input::get('country_id');
   // dump($id);
    //   $user_code=collect(DB::select('select actice_code from users where id like ?',[$id]))->first();
    // $cities=collect(DB::select('select name from region where id_country like ?',[$id]))->take(100);
  /*  $regions=Region::select('name')
        ->where('id_country',$id)
        ->get();*/
    $regions=Region::where('id_country','=',$id)
        ->orderBy('id')
        ->get();

 //   dump($regions);
    return Response::json($regions);
}
    );

Route::get('/findCitys',function (){
    $id=Input::get('region_id');
  //   dump($id);

  //  $regions=Region::where('id_country','=',$id)->get();
    $region=Region::where('id','=',$id)->first();
  //  dump($region);
    $region_id=$region->id_region;
  //  dump($region_id);



         $citys=City::where('id_region','=',$region_id)->get();
    //     dump($citys);
    /*$citys=null;*/
    //   dump($regions);*/
   return Response::json($citys);
});

Route::get('/inputPhone2',function (){
    $serveses=null;
    //   echo 'test';
    $user=Auth::user();
    if (Auth::guest()){
        return redirect('/login');
    }
    $girl = Girl::select(['name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age'])
        ->where('user_id', $user->id)->first();

    //  dump($girl);

    if($girl!=null){
        //  die();
        $rewest=new Request();
        return  $this->girlsShowAuchAnket($rewest);
    }

    //   dump($user);
    // die();
    // $user=Auth::user();
    if (Auth::guest()){
        return redirect('/login');
    }
    if($user->akcept==0){
        return view('rules');
    }

    //    dump($user);
    if($user->is_conferd==0)
    {
        return view('conferntEmail')->with(['email'=>$user->email]);
    }

    if($user->phone==null){
        return view('inputphone2');
    }
    if($user->phone_conferd==0){
        return view('inputphone2');
    }
    //  dump($user);

    //проверяем, вдруг анкета уже есть.


    //  dump($girl);

    if($girl!=null){
        return $this->index();
    }


    $phone=$user->phone;
    //  die();
    $countries=collect(DB::select('select * from countries')); //получаем города
    //получили цену


    $title="Создание анкеты";
    return view('createGirl')->with(['servises' => $serveses, 'title' => $title,'phone'=>$phone,'countries'=>$countries]
    )->name('inputMobilePhone2');



    //
    //  dump($serveses);
    // return view('createGirl');


});

Route::get('/inpotMobilePhoneAjax',function (){
        $phone=Input::get('phone');
     //  dump($phone);
        $ansver="test";


        return Response::json($ansver);
    });
;

//тестирование верстки
Route::get('/bladetest',function (){return view('bladetest');})->name('bladetest');
//Route::get('/inputphone',function (){return view('inputphone');})->name('inputMobile');

//поиск анкет
Route::post('/search', 'GirlsController@search')->name('search');
Route::get('/reset', 'GirlsController@index2')->name('reset');