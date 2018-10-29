<?php

use App\Entities\Group;
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

Route::group(['middleware' => 'auth', 'prefix' => 'Admin'], function () {
    /*
    ///////////////////////////////////////////
    /////////////////Administrador/////////////
    ///////////////////////////////////////////
     */
    Route::get('', 'AdminController@index');
    Route::get('Preferencias', 'AdminController@preferences');
    Route::post('Preferencias/Editar', 'AdminController@editar');
    /*
    ///////////////////////////////////////////
    /////////////////Alunos////////////////
    ///////////////////////////////////////////
     */
    Route::get('Alunos', 'StudentController@index');

    Route::post('Aluno/Cadastrar', 'StudentController@store');

    Route::post('Aluno/Editar', 'StudentController@update');

    Route::post('Aluno/Excluir', 'StudentController@destroy');

    /*
    ///////////////////////////////////////////
    /////////////////Duplas////////////////
    ///////////////////////////////////////////
     */
    Route::get('Duplas', 'DoubleStudentController@index');

    Route::post('Dupla/Cadastrar', 'DoubleStudentController@store');

    Route::post('Dupla/Editar', 'DoubleStudentController@update');

    Route::post('Dupla/Excluir', 'DoubleStudentController@destroy');

    /*
    ///////////////////////////////////////////
    /////////////////Professores////////////////
    ///////////////////////////////////////////
     */
    Route::get('Professores', 'TeacherController@index');

    Route::post('Professor/Cadastrar', 'TeacherController@store');

    Route::post('Professor/Editar', 'TeacherController@update');

    Route::post('Professor/Excluir', 'TeacherController@destroy');
    /*
    ///////////////////////////////////////////
    /////////////////Grupos////////////////
    ///////////////////////////////////////////
     */
    Route::get('Grupos', 'GroupController@index');

    Route::post('Grupo/Cadastrar', 'GroupController@store');

    Route::post('Grupo/Editar', 'GroupController@update');

    Route::post('Grupo/Excluir', 'GroupController@destroy');
    /*
    ///////////////////////////////////////////
    /////////////////Defensores////////////////
    ///////////////////////////////////////////
     */
    Route::get('Defensores', 'DefenderController@index');

    Route::post('Defensor/Cadastrar', 'DefenderController@store');

    Route::post('Defensor/Editar', 'DefenderController@update');

    Route::post('Defensor/Excluir', 'DefenderController@destroy');

    /*
    ///////////////////////////////////////////
    /////////////////Logs//////////////////////
    ///////////////////////////////////////////
     */
    Route::get('Logs', 'LogController@index');

    /*
    ///////////////////////////////////////////
    /////////////////Assistidos////////////////
    ///////////////////////////////////////////
     */
    Route::resource('Assistidos', 'AssistedController');

});

Route::group(['middleware' => 'auth', 'prefix' => 'Aluno'], function () {

    /*
    ///////////////////////////////////////////
    /////////////////Painel de Controle/////////////
    ///////////////////////////////////////////
     */
    Route::get('', 'StudentController@index');
    Route::get('Preferencias', 'StudentController@preferences');
    Route::post('Preferencias/Editar', 'StudentController@preferencesEditar');

//Escolher Template
    Route::post('Template/Escolher', 'PetitionController@escolherTemplate');

    /*
    ///////////////////////////////////////////
    /////////////////Peticoes////////////////
    ///////////////////////////////////////////
     */
    Route::get('Peticoes', 'PetitionController@index'); //ver suas peticoes
    Route::get('Peticao/Add', 'PetitionController@add');
    Route::post('Peticao/MudarPeticao', 'PetitionController@changePetition');
    Route::post('Peticao/CopiarPeticao', 'PetitionController@copyPetition');
    Route::post('Peticao/save', 'PetitionController@save');
    Route::post('Peticao/Cadastrar', 'PetitionController@store');

    Route::get('Peticao/Edit/{id}', 'PetitionController@edit');

    Route::post('Peticao/Editar', 'PetitionController@update');

    Route::get('Peticao/Show/{id}', 'PetitionController@show');

    Route::post('Peticao/Delete', 'PetitionController@delete');

    Route::get('Peticao/Edit/{petition_id}/DeletePhoto/{photo_id}', 'PetitionController@deletePhoto');


    /*
    ///////////////////////////////////////////
    /////////////////Assistidos////////////////
    ///////////////////////////////////////////
     */
    Route::resource('Assistidos', 'AssistedController');

});

//-----------------------------------------------------------------------------

Route::group(['middleware' => 'auth', 'prefix' => 'Professor'], function () {
    /*
    ///////////////////////////////////////////
    /////////////////Painel de Controle/////////////
    ///////////////////////////////////////////
     */
    Route::get('', 'TeacherController@index');
    Route::get('Preferencias', 'TeacherController@preferences');
    Route::post('Preferencias/Editar', 'TeacherController@preferencesEditar');

    /*
    ///////////////////////////////////////////
    /////////////////Duplas////////////////
    ///////////////////////////////////////////
     */
    Route::get('Duplas', 'DoubleStudentController@index'); //Ver as duplas do seu grupo

    /*
    ///////////////////////////////////////////
    /////////////////Templates////////////////
    ///////////////////////////////////////////
     */

    Route::get('Templates', 'TemplateController@index');
    Route::get('Template/Add', 'TemplateController@add');
    Route::post('Template/Cadastrar', 'TemplateController@store');
    Route::get('Template/Edit/{id}', 'TemplateController@edit');
    Route::post('Template/Editar', 'TemplateController@update');
    Route::post('Template/Excluir', 'TemplateController@destroy');
    Route::get('Template/Show/{id}', 'TemplateController@show');

    Route::post('Template/Status', 'TemplateController@editStatus');

    /*
    ///////////////////////////////////////////
    /////////////////Peticoes////////////////
    ///////////////////////////////////////////
     */
    Route::get('Peticoes', 'PetitionController@index'); //ver as peticoes do grupo
    Route::get('Peticao/Avaliar/{id}', 'PetitionController@avaliar');
    Route::post('Peticao/Template', 'PetitionController@template'); //ver as peticoes do grupo
    Route::get('Peticao/Show/{id}', 'PetitionController@show');

    // falta metodos de editar petição que o professor deve poder

    Route::delete('Peticao/Edit/{petition_id}/DeletePhoto/{photo_id}', 'PetitionController@deletePhoto');

    /*
    ///////////////////////////////////////////
    /////////////////Comentarios////////////////
    ///////////////////////////////////////////
     */
    Route::post('Comentario/Cadastrar', 'CommentController@store'); //O professor pode cadastrar comentario
});

Route::group(['middleware' => 'auth', 'prefix' => 'Defensor'], function () {
    /*
    ///////////////////////////////////////////
    /////////////////Painel de Controle/////////////
    ///////////////////////////////////////////
     */
    Route::get('', 'DefenderController@index');
    Route::get('Preferencias', 'DefenderController@preferences');
    Route::post('Preferencias/Editar', 'DefensorController@preferencesEditar');

    /*
    ///////////////////////////////////////////
    /////////////////Peticoes////////////////
    ///////////////////////////////////////////
     */
    Route::get('Peticoes', 'PetitionController@index'); //ver as peticoes das quais ele pertence

    Route::get('Peticao/Show/{id}', 'PetitionController@show');

    Route::get('Peticao/Emitir/{id}', 'PetitionController@emitir');
    //Ao ver as peticoes, ele irá ver também todos os comentarios que ele fez referentes aquela peticao
    Route::get('Peticao/Avaliar/{id}', 'PetitionController@avaliar');

    Route::post('Peticao/Emitir', 'PetitionController@emitir');

    Route::post('Comentario/Cadastrar', 'CommentController@store'); //O defensor pode cadastrar comentario
});

//Route::post('Login', 'LoginController@index')->name('home');

Route::get('Sair', function () {
    if (!Auth::guest()) {
        Auth::logout();
    }
    return redirect('/');
});

Auth::routes();

Route::get('/', 'HomeController@index');
