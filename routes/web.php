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
//Auth::routes();

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'sistema'], function () {
        
        Route::get('/', function () {

            return view('pages.sistema.index');
        });
        
        Route::get('/tabelas', function () {
            return view('pages.sistema.index');
        });

        require_once 'Routes/regional.php';
        require_once 'Routes/funcionario.php';
        require_once 'Routes/tipo-apoio.php';
        require_once 'Routes/tipo-entrada.php';
        require_once 'Routes/tipo-obra.php';
        require_once 'Routes/tipo-prioridade.php';
        require_once 'Routes/tipo-status-medicao.php';
        require_once 'Routes/tipo-setor-obra.php';
        require_once 'Routes/tipo-unidade-medida.php';
        require_once 'Routes/status-obra.php';
        require_once 'Routes/almoxarifado.php';
        require_once 'Routes/tipo-material.php';
        require_once 'Routes/tipo-saida.php';
        require_once 'Routes/cidade.php';
        require_once 'Routes/permissoes.php';
        require_once 'Routes/funcoes.php';
        require_once 'Routes/apontamento-medicao.php';

        //Form and List-Item
        require_once 'RouteForm/list.php';
        require_once 'RouteForm/item.php';

    });
    
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    require_once 'Routes/estoque.php';
    require_once 'Routes/obra.php';
    require_once 'Routes/entrada-estoque.php';
    require_once 'Routes/medicao.php';
    require_once 'Routes/saida-estoque.php';
    require_once 'Routes/gerencial.php';
    require_once 'Routes/empresa.php';
    require_once 'Routes/usuarios.php';
    require_once 'Routes/transferencia-estoque.php';
	
});










// Route::get('admin', function () {
//     return view('admin_template');
// });

