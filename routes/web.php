<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/teste', 'App\Http\Controllers\Admin\TesteController@index')->name('teste');

Route::get('/logout', 'App\Http\Controllers\Auth\AuthenticatedSessionController@destroy')->name('logout');

Route::get('/funcoes', 'App\Http\Controllers\Admin\FuncaoController@index')->middleware(['auth'])->name('funcoes.index');
Route::get('/funcoes/search', 'App\Http\Controllers\Admin\FuncaoController@search')->middleware(['auth'])->name('funcoes.search');
Route::get('/funcoes/create', 'App\Http\Controllers\Admin\FuncaoController@create')->middleware(['auth'])->name('funcoes.create');
Route::any('/funcoes/store', 'App\Http\Controllers\Admin\FuncaoController@store')->middleware(['auth'])->name('funcoes.store');
Route::get('funcoes/{id}/edit', 'App\Http\Controllers\Admin\FuncaoController@edit')->middleware(['auth'])->name('funcoes.edit');
Route::any('funcoes/{id}/update', 'App\Http\Controllers\Admin\FuncaoController@update')->middleware(['auth'])->name('funcoes.update');
Route::get('funcoes/{id}/show', 'App\Http\Controllers\Admin\FuncaoController@show')->middleware(['auth'])->name('funcoes.show');
Route::get('funcoes/{id}/destroy', 'App\Http\Controllers\Admin\FuncaoController@destroy')->middleware(['auth'])->name('funcoes.destroy');

Route::get('/setores', 'App\Http\Controllers\Admin\SetorController@index')->middleware(['auth'])->name('setores.index');
Route::get('/setores/search', 'App\Http\Controllers\Admin\SetorController@search')->middleware(['auth'])->name('setores.search');
Route::get('/setores/create', 'App\Http\Controllers\Admin\SetorController@create')->middleware(['auth'])->name('setores.create');
Route::any('/setores/store', 'App\Http\Controllers\Admin\SetorController@store')->middleware(['auth'])->name('setores.store');
Route::get('setores/{id}/edit', 'App\Http\Controllers\Admin\SetorController@edit')->middleware(['auth'])->name('setores.edit');
Route::any('setores/{id}/update', 'App\Http\Controllers\Admin\SetorController@update')->middleware(['auth'])->name('setores.update');
Route::get('setores/{id}/show', 'App\Http\Controllers\Admin\SetorController@show')->middleware(['auth'])->name('setores.show');
Route::get('setores/{id}/destroy', 'App\Http\Controllers\Admin\SetorController@destroy')->middleware(['auth'])->name('setores.destroy');

Route::get('/exames', 'App\Http\Controllers\Admin\ExameController@index')->middleware(['auth'])->name('exames.index');
Route::get('/exames/search', 'App\Http\Controllers\Admin\ExameController@search')->middleware(['auth'])->name('exames.search');
Route::get('/exames/create', 'App\Http\Controllers\Admin\ExameController@create')->middleware(['auth'])->name('exames.create');
Route::any('/exames/store', 'App\Http\Controllers\Admin\ExameController@store')->middleware(['auth'])->name('exames.store');
Route::get('exames/{id}/edit', 'App\Http\Controllers\Admin\ExameController@edit')->middleware(['auth'])->name('exames.edit');
Route::any('exames/{id}/update', 'App\Http\Controllers\Admin\ExameController@update')->middleware(['auth'])->name('exames.update');
Route::get('exames/{id}/show', 'App\Http\Controllers\Admin\ExameController@show')->middleware(['auth'])->name('exames.show');
Route::get('exames/{id}/destroy', 'App\Http\Controllers\Admin\ExameController@destroy')->middleware(['auth'])->name('exames.destroy');

Route::get('/grupos', 'App\Http\Controllers\Admin\GrupoController@index')->middleware(['auth'])->name('grupos.index');
Route::get('/grupos/create', 'App\Http\Controllers\Admin\GrupoController@create')->middleware(['auth'])->name('grupos.create');
Route::any('/grupos/store', 'App\Http\Controllers\Admin\GrupoController@store')->middleware(['auth'])->name('grupos.store');
Route::get('grupos/{id}/edit', 'App\Http\Controllers\Admin\GrupoController@edit')->middleware(['auth'])->name('grupos.edit');
Route::any('grupos/{id}/update', 'App\Http\Controllers\Admin\GrupoController@update')->middleware(['auth'])->name('grupos.update');
Route::get('grupos/{id}/show', 'App\Http\Controllers\Admin\GrupoController@show')->middleware(['auth'])->name('grupos.show');
Route::get('grupos/{id}/destroy', 'App\Http\Controllers\Admin\GrupoController@destroy')->middleware(['auth'])->name('grupos.destroy');

Route::get('grupofuncao/{id}/index', 'App\Http\Controllers\Admin\GrupoFuncaoController@index')->middleware(['auth'])->name('grupofuncao.index');
Route::any('grupofuncao/{id}/store', 'App\Http\Controllers\Admin\GrupoFuncaoController@store')->middleware(['auth'])->name('grupofuncao.store');
Route::get('grupofuncao/{id}/destroy', 'App\Http\Controllers\Admin\GrupoFuncaoController@destroy')->middleware(['auth'])->name('grupofuncao.destroy');

Route::get('gruporisco/{id}/index', 'App\Http\Controllers\Admin\GrupoRiscoController@index')->middleware(['auth'])->name('gruporisco.index');
Route::any('gruporisco/{id}/store', 'App\Http\Controllers\Admin\GrupoRiscoController@store')->middleware(['auth'])->name('gruporisco.store');
Route::get('gruporisco/{id}/destroy', 'App\Http\Controllers\Admin\GrupoRiscoController@destroy')->middleware(['auth'])->name('gruporisco.destroy');

Route::get('grupoexame/{id}/index', 'App\Http\Controllers\Admin\GrupoExameController@index')->middleware(['auth'])->name('grupoexame.index');
Route::any('grupoexame/{id}/store', 'App\Http\Controllers\Admin\GrupoExameController@store')->middleware(['auth'])->name('grupoexame.store');
Route::get('grupoexame/{id}/destroy', 'App\Http\Controllers\Admin\GrupoExameController@destroy')->middleware(['auth'])->name('grupoexame.destroy');

Route::get('/riscos', 'App\Http\Controllers\Admin\RiscoController@index')->middleware(['auth'])->name('riscos.index');
Route::get('/riscos/search', 'App\Http\Controllers\Admin\RiscoController@search')->middleware(['auth'])->name('riscos.search');
Route::get('/riscos/create', 'App\Http\Controllers\Admin\RiscoController@create')->middleware(['auth'])->name('riscos.create');
Route::any('/riscos/store', 'App\Http\Controllers\Admin\RiscoController@store')->middleware(['auth'])->name('riscos.store');
Route::get('riscos/{id}/edit', 'App\Http\Controllers\Admin\RiscoController@edit')->middleware(['auth'])->name('riscos.edit');
Route::any('riscos/{id}/update', 'App\Http\Controllers\Admin\RiscoController@update')->middleware(['auth'])->name('riscos.update');
Route::get('riscos/{id}/show', 'App\Http\Controllers\Admin\RiscoController@show')->middleware(['auth'])->name('riscos.show');
Route::get('riscos/{id}/destroy', 'App\Http\Controllers\Admin\RiscoController@destroy')->middleware(['auth'])->name('riscos.destroy');

Route::get('/tipoatendimentos', 'App\Http\Controllers\Admin\TipoAtendimentoController@index')->middleware(['auth'])->name('tipoatendimentos.index');
Route::get('/tipoatendimentos/create', 'App\Http\Controllers\Admin\TipoAtendimentoController@create')->middleware(['auth'])->name('tipoatendimentos.create');
Route::any('/tipoatendimentos/store', 'App\Http\Controllers\Admin\TipoAtendimentoController@store')->middleware(['auth'])->name('tipoatendimentos.store');
Route::get('tipoatendimentos/{id}/edit', 'App\Http\Controllers\Admin\TipoAtendimentoController@edit')->middleware(['auth'])->name('tipoatendimentos.edit');
Route::any('tipoatendimentos/{id}/update', 'App\Http\Controllers\Admin\TipoAtendimentoController@update')->middleware(['auth'])->name('tipoatendimentos.update');
Route::get('tipoatendimentos/{id}/show', 'App\Http\Controllers\Admin\TipoAtendimentoController@show')->middleware(['auth'])->name('tipoatendimentos.show');
Route::get('tipoatendimentos/{id}/destroy', 'App\Http\Controllers\Admin\TipoAtendimentoController@destroy')->middleware(['auth'])->name('tipoatendimentos.destroy');

Route::get('/tipousuarios', 'App\Http\Controllers\Admin\TipoUsuarioController@index')->middleware(['auth'])->name('tipousuarios.index');
Route::get('/tipousuarios/create', 'App\Http\Controllers\Admin\TipoUsuarioController@create')->middleware(['auth'])->name('tipousuarios.create');
Route::any('/tipousuarios/store', 'App\Http\Controllers\Admin\TipoUsuarioController@store')->middleware(['auth'])->name('tipousuarios.store');
Route::get('tipousuarios/{id}/edit', 'App\Http\Controllers\Admin\TipoUsuarioController@edit')->middleware(['auth'])->name('tipousuarios.edit');
Route::any('tipousuarios/{id}/update', 'App\Http\Controllers\Admin\TipoUsuarioController@update')->middleware(['auth'])->name('tipousuarios.update');
Route::get('tipousuarios/{id}/show', 'App\Http\Controllers\Admin\TipoUsuarioController@show')->middleware(['auth'])->name('tipousuarios.show');
Route::get('tipousuarios/{id}/destroy', 'App\Http\Controllers\Admin\TipoUsuarioController@destroy')->middleware(['auth'])->name('tipousuarios.destroy');

Route::get('permissoes/{id}/index', 'App\Http\Controllers\Admin\PermissaoController@index')->middleware(['auth'])->name('permissoes.index');
Route::get('permissoes/{id}/edit', 'App\Http\Controllers\Admin\PermissaoController@edit')->middleware(['auth'])->name('permissoes.edit');
Route::any('permissoes/{id}/update', 'App\Http\Controllers\Admin\PermissaoController@update')->middleware(['auth'])->name('permissoes.update');
Route::get('permissoes/{id}/destroy', 'App\Http\Controllers\Admin\PermissaoController@destroy')->middleware(['auth'])->name('permissoes.destroy');
Route::any('permissoes/{id}/store', 'App\Http\Controllers\Admin\PermissaoController@store')->middleware(['auth'])->name('permissoes.store');

Route::resource('usuarios', 'App\Http\Controllers\Admin\UserController');
Route::get('/usuarios/search', 'App\Http\Controllers\Admin\UserController@search')->middleware(['auth'])->name('usuarios.search');
Route::get('usuario/password', 'App\Http\Controllers\Admin\UserController@password')->middleware(['auth'])->name('usuario.password');
Route::any('usuario/password/update', 'App\Http\Controllers\Admin\UserController@password_update')->middleware(['auth'])->name('usuario.password.update');

Route::get('/empregados', 'App\Http\Controllers\Admin\EmpregadoController@index')->middleware(['auth'])->name('empregados.index');
Route::get('/empregados/search', 'App\Http\Controllers\Admin\EmpregadoController@search')->middleware(['auth'])->name('empregados.search');
Route::get('/empregados/create', 'App\Http\Controllers\Admin\EmpregadoController@create')->middleware(['auth'])->name('empregados.create');
Route::get('empregados/{id}/edit', 'App\Http\Controllers\Admin\EmpregadoController@edit')->middleware(['auth'])->name('empregados.edit');
Route::any('/empregados/store', 'App\Http\Controllers\Admin\EmpregadoController@store')->middleware(['auth'])->name('empregados.store');
Route::any('empregados/{id}/update', 'App\Http\Controllers\Admin\EmpregadoController@update')->middleware(['auth'])->name('empregados.update');
Route::get('load_funcoes', 'App\Http\Controllers\Admin\EmpregadoController@loadFuncoes')->middleware(['auth'])->name('load_funcoes');
Route::get('load_grupos', 'App\Http\Controllers\Admin\EmpregadoController@loadGrupos')->middleware(['auth'])->name('load_grupos');

Route::get('/coordenadores', 'App\Http\Controllers\Admin\CoordenadorController@index')->middleware(['auth'])->name('coordenadores.index');
Route::get('/coordenadores/create', 'App\Http\Controllers\Admin\CoordenadorController@create')->middleware(['auth'])->name('coordenadores.create');
Route::any('/coordenadores/store', 'App\Http\Controllers\Admin\CoordenadorController@store')->middleware(['auth'])->name('coordenadores.store');
Route::get('coordenadores/{id}/edit', 'App\Http\Controllers\Admin\CoordenadorController@edit')->middleware(['auth'])->name('coordenadores.edit');
Route::any('coordenadores/{id}/update', 'App\Http\Controllers\Admin\CoordenadorController@update')->middleware(['auth'])->name('coordenadores.update');
Route::get('coordenadores/{id}/show', 'App\Http\Controllers\Admin\CoordenadorController@show')->middleware(['auth'])->name('coordenadores.show');
Route::get('coordenadores/{id}/destroy', 'App\Http\Controllers\Admin\CoordenadorController@destroy')->middleware(['auth'])->name('coordenadores.destroy');

Route::get('/atendimentos', 'App\Http\Controllers\Admin\AtendimentoController@index')->middleware(['auth'])->name('atendimentos.index');
Route::get('/atendimentos/search', 'App\Http\Controllers\Admin\AtendimentoController@search')->middleware(['auth'])->name('atendimentos.search');
Route::get('/atendimentos/create', 'App\Http\Controllers\Admin\AtendimentoController@create')->middleware(['auth'])->name('atendimentos.create');
Route::any('/atendimentos/store', 'App\Http\Controllers\Admin\AtendimentoController@store')->middleware(['auth'])->name('atendimentos.store');
Route::get('atendimentos/{id}/edit', 'App\Http\Controllers\Admin\AtendimentoController@edit')->middleware(['auth'])->name('atendimentos.edit');
Route::any('atendimentos/{id}/update', 'App\Http\Controllers\Admin\AtendimentoController@update')->middleware(['auth'])->name('atendimentos.update');
Route::get('atendimentos/{id}/show', 'App\Http\Controllers\Admin\AtendimentoController@show')->middleware(['auth'])->name('atendimentos.show');
Route::get('atendimentos/{id}/destroy', 'App\Http\Controllers\Admin\AtendimentoController@destroy')->middleware(['auth'])->name('atendimentos.destroy');
Route::get('atendimentos/{id}/rel_aso', 'App\Http\Controllers\Admin\AtendimentoController@rel_aso')->name('atendimentos.rel_aso');


Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->middleware(['auth'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';