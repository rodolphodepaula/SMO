<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TipoUsuario;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\UserFormRequest;
use App\Http\Requests\Admin\UsuarioFormRequest;
use App\Http\Requests\Admin\PasswordFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;
    public function __construct(User $user, TipoUsuario $tipousuario)
    {
        $this->user = $user;
        $this->tipousuario = $tipousuario;
    }
    public function index()
    {
        $usuarios = $this->user
                ->orderBy('name', 'ASC')
                ->paginate(5);
        $tipousuarios = $this->tipousuario
                ->orderBy('nome', 'ASC')
                ->get();
        return view('admin.usuario.index', ['usuarios' => $usuarios, 'tipousuarios' => $tipousuarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipousuarios = $this->tipousuario
                ->orderBy('nome', 'ASC')->get();
        return view('admin.usuario.create', ['tipousuarios' => $tipousuarios]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $dataUser = $request->all();
        $dataUser['password'] = bcrypt($dataUser['password']);

        $insert = $this->user->insert([
            'name' => $dataUser['name'],
            'email' => $dataUser['email'],
            'password' => $dataUser['password'],
            'tipousuario_id' => $dataUser['tipousuario_id'],
            'status' => $dataUser['status']
        ]);
        if ( $insert )
            return redirect()
                    ->route('usuarios.index')
                    ->withInput();
        else
            return redirect('usuarios.create')
                 ->withErrors(['errors' => 'Erro no Insert'])
                 ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $tipousuarios = $this->tipousuario
                ->orderBy('nome', 'ASC')->get();
        return view('admin.usuario.edit', ['user' => $user, 'tipousuarios' => $tipousuarios]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioFormRequest $request, $id)
    {
        $user = $this->user->find($id);
        $dataForm = $request->all();

        if ($request->password){
            if ($dataForm['password'] != $dataForm['password_confirmation'])
            {
                return redirect()
                    ->route('usuarios.edit', $id)
                    ->withErrors(['errors' => 'Senha confirmada inválida !'])
                    ->withInput();
            }
            $c = strlen($dataForm['password']);
            if ($c < 6 || $c > 20){
                return redirect()
                    ->route('usuarios.edit', $id)
                    ->withErrors(['errors' => 'Senha deve ter entre 6 e 20 caracteres !'])
                    ->withInput();
            }
            $dataForm['password'] = bcrypt($dataForm['password']);
        }else{
            unset($dataForm['password']);
        }

        $update = $user->update($dataForm);
        if ( $update )
            return redirect()
                ->route('usuarios.index', $id)
                ->with(['success' => 'Dados alterados com sucesso']);
        else
            return redirect()
                ->route('usuarios.edit', $id)
                ->with(['errors' => 'Falha ao alterar']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $dataForm = $request->all();
        $name = '%' . $dataForm['name'] . '%';
        $usuarios = $this->user
        ->where('name', 'LIKE', $name)
        ->orderBy('name', 'ASC')
        ->paginate(5);

        return view('admin.usuario.index', ['usuarios' => $usuarios, 'dataForm'=> $dataForm]);
    }

    public function password()
    {
        $usuario = Auth::user();
        return view('admin.usuario.password', ['usuario' => $usuario]);
    }

    public function password_update(PasswordFormRequest $request, User $user)
    {
        $dataForm = $request->all();
        $id = Auth::user()->id;
        $user = $this->user->find($id);
        $dataForm['password'] = bcrypt($dataForm['password']);

        if (! Hash::check($dataForm['password_anterior'],Auth::user()->password)){
            return redirect()
            ->route('usuario.password')
            ->withErrors(['errors' => 'Senha anterior inválida!'])
                 ->withInput();
        }
        $update = $user->update($dataForm);
        if ( $update )
            return redirect()
                ->route('usuario.password')
                ->with(['success' => 'Senha alterada com sucesso']);
        else
            return redirect()
                ->route('usuario.password')
                ->with(['errors' => 'Falha ao alterar']);
    }
}
