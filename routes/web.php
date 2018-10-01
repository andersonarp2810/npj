<?php

use App\Entities\Petition;
use App\Entities\Comment;
use App\Entities\Group;
use App\Entities\Photo;
use App\Entities\Template;
use App\Entities\DoubleStudent;

use App\Entities\Human;
use Illuminate\Support\Facades\DB;


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

  Route::group(['middleware'=>'auth','prefix'=>'Admin'],function(){
    /*
    ///////////////////////////////////////////
    /////////////////Administrador/////////////
    ///////////////////////////////////////////
    */
    Route::get('','AdminController@index');
    Route::get('Preferencias','AdminController@preferences');
    Route::post('Preferencias/Editar','AdminController@editar');
    /*
    ///////////////////////////////////////////
    /////////////////Alunos////////////////
    ///////////////////////////////////////////
    */
    Route::get('Alunos','StudentController@index');

    Route::post('Aluno/Cadastrar','StudentController@store');

    Route::post('Aluno/Editar','StudentController@update');

    Route::post('Aluno/Excluir','StudentController@destroy');

    /*
    ///////////////////////////////////////////
    /////////////////Duplas////////////////
    ///////////////////////////////////////////
    */
    Route::get('Duplas','DoubleStudentController@index');

    Route::post('Dupla/Cadastrar','DoubleStudentController@store');

    Route::post('Dupla/Editar','DoubleStudentController@update');

    Route::post('Dupla/Excluir','DoubleStudentController@destroy');

    /*
    ///////////////////////////////////////////
    /////////////////Professores////////////////
    ///////////////////////////////////////////
    */
    Route::get('Professores','TeacherController@index');

    Route::post('Professor/Cadastrar','TeacherController@store');

    Route::post('Professor/Editar','TeacherController@update');

    Route::post('Professor/Excluir','TeacherController@destroy');
    /*
    ///////////////////////////////////////////
    /////////////////Grupos////////////////
    ///////////////////////////////////////////
    */
    Route::get('Grupos','GroupController@index');

    Route::post('Grupo/Cadastrar','GroupController@store');

    Route::post('Grupo/Editar','GroupController@update');

    Route::post('Grupo/Excluir','GroupController@destroy');
    /*
    ///////////////////////////////////////////
    /////////////////Defensores////////////////
    ///////////////////////////////////////////
    */
    Route::get('Defensores','DefenderController@index');

    Route::post('Defensor/Cadastrar','DefenderController@store');

    Route::post('Defensor/Editar','DefenderController@update');

    Route::post('Defensor/Excluir','DefenderController@destroy');

  });


Route::group(['middleware'=>'auth','prefix'=>'Aluno'],function(){

  /*
  ///////////////////////////////////////////
  /////////////////Painel de Controle/////////////
  ///////////////////////////////////////////
  */
  Route::get('','StudentController@index');
  Route::get('Preferencias','StudentController@preferences');
  Route::post('Preferencias/Editar','StudentController@preferencesEditar');

//Escolher Template
Route::post('Template/Escolher','PetitionController@escolherTemplate');



  /*
  ///////////////////////////////////////////
  /////////////////Peticoes////////////////
  ///////////////////////////////////////////
  */
  Route::get('Peticoes','PetitionController@index');//ver suas peticoes
  Route::get('Peticao/Add','PetitionController@add');
  Route::post('Peticao/MudarPeticao','PetitionController@changePetition');
  Route::post('Peticao/CopiarPeticao','PetitionController@copyPetition');
  Route::post('Peticao/save','PetitionController@save');
  Route::post('Peticao/Cadastrar','PetitionController@store');

  Route::get('Peticao/Edit/{id}', function($id)
  {
    $petition = Petition::find($id);

    if($petition != null){
      $hu = Human::all()->where('user_id',Auth::user()->id)->first();
      $DoubleHu1 = DoubleStudent::all()->where('student_id',$hu->id)->where('id',$petition->doubleStudent_id)->first();
      $DoubleHu2 = DoubleStudent::all()->where('student2_id',$hu->id)->where('id',$petition->doubleStudent_id)->first();

      if(($DoubleHu1 != null || $DoubleHu2 != null) && $petition->visible == 'true'){

        $templates = Template::all();
        $photos = Photo::all()->where('petition_id',$petition->id);
        if($petition->student_ok != 'true'){
          if($photos->count() != 0){
            $IsPhotos = 'true';
            $comments = Comment::all()->where('petition_id',$petition->id);
            return view('student.petitionEditar')->with(['petition'=>$petition,'templates'=>$templates,'photos'=>$photos,'IsPhotos'=>$IsPhotos,'comments'=>$comments]);
          }else {
            $IsPhotos = 'false';
            $comments = Comment::all()->where('petition_id',$petition->id);
            return view('student.petitionEditar')->with(['petition'=>$petition,'templates'=>$templates,'IsPhotos'=>$IsPhotos,'comments'=>$comments]);
          }
        }else{
          return redirect()->back();
        }
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }

  });

  Route::post('Peticao/Editar','PetitionController@update');

  Route::get('Peticao/Show/{id}', function($id)
  {
    $petition = Petition::find($id);

    if($petition != null){
      $hu = Human::all()->where('user_id',Auth::user()->id)->first();
      $DoubleHu1 = DoubleStudent::all()->where('student_id',$hu->id)->where('id',$petition->doubleStudent_id)->first();
      $DoubleHu2 = DoubleStudent::all()->where('student2_id',$hu->id)->where('id',$petition->doubleStudent_id)->first();

      if($DoubleHu1 != null || $DoubleHu2 != null){//se o usuario estiver consultando a sua peticao entoa OK
        $humans = Human::all()->where('status','active');
        $temps = Template::all();
        $petitions = Petition::all()->where('petitionFirst',$petition->petitionFirst);
        $photos = Photo::all()->where('petition_id',$petition->id);
        $comments = Comment::all()->where('petition_id',$petition->id);
        return view('student.petitionShow')->with(['petition'=>$petition,'humans'=>$humans,'temps'=>$temps,'petitions'=>$petitions,'photos'=>$photos,'comments'=>$comments]);
      }else{
        return redirect()->back();
      }
    }else{
      return redirect()->back();
    }
  });

  Route::post('Peticao/Delete','PetitionController@delete');

  /*
  ///////////////////////////////////////////
  /////////////////Preferências///////////////////
  ///////////////////////////////////////////
  */
  Route::get('Preferencias','StudentController@update');

});



//-----------------------------------------------------------------------------



Route::group(['middleware'=>'auth','prefix'=>'Professor'],function(){
  /*
  ///////////////////////////////////////////
  /////////////////Painel de Controle/////////////
  ///////////////////////////////////////////
  */
  Route::get('','TeacherController@index');

  /*
  ///////////////////////////////////////////
  /////////////////Duplas////////////////
  ///////////////////////////////////////////
  */
  Route::get('Duplas','DoubleStudentController@index');//Ver as duplas do seu grupo


  /*
  ///////////////////////////////////////////
  /////////////////Templates////////////////
  ///////////////////////////////////////////
  */

  Route::get('Templates','TemplateController@index');
  Route::get('Template/Add','TemplateController@add');
  Route::post('Template/Cadastrar','TemplateController@store');
  Route::get('Template/Edit/{id}', function($id)
  {
      $template = Template::find($id);
      $hu = Human::all()->where('user_id',Auth::user()->id)->first();

      if($template != null && ($hu->id == $template->teacher_id)){//se template pertencer ao usuario corrente
        return view('teacher.templateEditar')->with(['template'=>$template]);
      }else{
        return redirect()->back();
      }
  });
  Route::post('Template/Editar','TemplateController@update');
  Route::post('Template/Excluir','TemplateController@destroy');
  Route::get('Template/Show/{id}', function($id)
  {
      $template = Template::find($id);
      $hu = Human::all()->where('user_id',Auth::user()->id)->first();

      if($template != null && ($hu->id == $template->teacher_id)){//se tempalte pertencer ao usuario corrente
        $humans = Human::all()->where('status','active');
        return view('teacher.templateShow')->with(['template'=>$template,'humans'=>$humans]);
      }else{
        return redirect()->back();
      }
  });

  Route::post('Template/Status','TemplateController@editStatus');


  /*
  ///////////////////////////////////////////
  /////////////////Peticoes////////////////
  ///////////////////////////////////////////
  */
  Route::get('Peticoes','PetitionController@index');//ver as peticoes do grupo
  Route::get('Peticao/Avaliar/{id}', function($id)
  {
      if(Auth::user()->type == 'teacher'){
        $petition = Petition::find($id);
        $hu = Human::all()->where('user_id',Auth::user()->id)->first();
        $group = Group::find($petition->group_id);

        if($petition != null && $petition->visible == 'true' && ($hu->id == $group->teacher_id)){
          $photos = Photo::all()->where('petition_id',$petition->id);
          $humans = Human::all()->where('status','active');
          $template = Template::find($petition->template_id);
          $group = Group::find($petition->group_id);
          $comments = Comment::all()->where('petition_id',$petition->id);
          return view('teacher.petitionAvaliable')->with(['petition'=>$petition,'photos'=>$photos,'humans'=>$humans,'template'=>$template,'comments'=>$comments]);
        }else{
            return redirect()->back();
        }
      }else{//caso o usuario nao seja um professor
        return redirect()->back();
      }

  });
  Route::post('Peticao/Template','PetitionController@template');//ver as peticoes do grupo


  /*
  ///////////////////////////////////////////
  /////////////////Comentarios////////////////
  ///////////////////////////////////////////
  */
  Route::post('Comentario/Cadastrar','CommentController@store');//O professor pode cadastrar comentario


  /*
  ///////////////////////////////////////////
  /////////////////Preferências///////////////////
  ///////////////////////////////////////////
  */
  Route::get('Preferencias','TeacherController@update');//Campo de mudança de senhas e de parâmetros

});


Route::group(['middleware'=>'auth','prefix'=>'Defensor'],function(){
  /*
  ///////////////////////////////////////////
  /////////////////Painel de Controle/////////////
  ///////////////////////////////////////////
  */
  Route::get('','DefenderController@index');


  /*
  ///////////////////////////////////////////
  /////////////////Peticoes////////////////
  ///////////////////////////////////////////
  */
  Route::get('Peticoes','PetitionController@index');//ver as peticoes das quais ele pertence

  Route::get('Peticao/Show/{id}', function($id)
  {
    $petition = Petition::find($id);
    $hu = Human::all()->where('user_id',Auth::user()->id)->first();

    if($petition != null){//se o usuario estiver consultando a sua peticao entoa OK
      $humans = Human::all()->where('status','active');
      $temps = Template::all();
      $photos = Photo::all()->where('petition_id',$petition->id);
      $comments = Comment::all()->where('petition_id',$petition->id)->where('human_id',$hu->id);
      return view('defender.petitionShow')->with(['petition'=>$petition,'humans'=>$humans,'temps'=>$temps,'photos'=>$photos,'comments'=>$comments]);
    }else{
      return redirect()->back();
    }
  });

  Route::get('Peticao/Emitir/{id}', function($id)
  {

      $defender = Human::all()->where('user_id',Auth::user()->id)->first();
      $humans = Human::all()->where('status','active');
      $temps = Template::all()->where('status','active');
      $petition = Petition::find($id);
      if($petition != null && $petition->defender_id == $defender->id && $petition->visible == 'true'){
        $photos = Photo::all()->where('petition_id',$petition->id);
        $comments = Comment::all()->where('petition_id',$petition->id);
        return view('defender.petitionEmitir')->with(['humans'=>$humans,'temps'=>$temps,'petition'=>$petition,'photos'=>$photos,'comments'=>$comments]);
      }else{
        return redirect()->back();
      }
  });
  //Ao ver as peticoes, ele irá ver também todos os comentarios que ele fez referentes aquela peticao
  Route::get('Peticao/Avaliar/{id}', function($id)
  {
      if(Auth::user()->type == 'defender'){
        $defender = Human::all()->where('user_id',Auth::user()->id)->first();
        $petition = Petition::find($id);
        if($petition != null && $petition->visible == 'true'){
          $photos = Photo::all()->where('petition_id',$petition->id);
          $humans = Human::all()->where('status','active');
          $template = Template::find($petition->template_id);
          //$group = Group::find($petition->group_id);
          $comments = Comment::all()->where('petition_id',$petition->id);
          return view('defender.petitionAvaliable')->with(['petition'=>$petition,'photos'=>$photos,'humans'=>$humans,'template'=>$template,'comments'=>$comments]);
        }else{
            return redirect()->back();
        }
      }else{//caso o usuario nao seja um professor
        return redirect()->back();
      }

  });

  Route::post('Peticao/Emitir','PetitionController@emitir');

  Route::post('Comentario/Cadastrar','CommentController@store');//O defensor pode cadastrar comentario


  /*
  ///////////////////////////////////////////
  /////////////////Preferências///////////////////
  ///////////////////////////////////////////
  */
  Route::get('Preferencias','DefenderController@update');//Campo de mudança de senhas e de parâmetros

});


//Route::post('Login', 'LoginController@index')->name('home');

Route::get('/', function () {
    return view('auth.login');
});

Route::get('Sair', function () {
    if(!Auth::guest()){
        Auth::logout();
    }
    return redirect('/');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
