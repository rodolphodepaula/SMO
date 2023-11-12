<nav class="navbar navbar-default">
    <div class="container-fluid">

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="{{ url('/home') }}">Home</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tabelas <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('funcoes.index') }}">Funções</a></li>
              <li><a href="{{ route('setores.index') }}">Setores</a></li>
              <li><a href="{{ route('exames.index') }}">Exames</a></li>
              <li><a href="{{ route('grupos.index') }}">Grupos Homogêneos</a></li>
              <li><a href="{{ route('riscos.index') }}">Riscos</a></li>
              <li><a href="{{ route('tipoatendimentos.index') }}">Tipos de Atendimentos</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('empregados.index') }}">Empregados</a></li>
              <li><a href="{{ route('coordenadores.index') }}">Coordenador de PCMSO</a></li>
              <li><a href="{{ route('atendimentos.index') }}">Atendimentos</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Segurança <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('tipousuarios.index') }}">Tipos de Usuários</a></li>
              <li><a href="{{ route('usuarios.index') }}">Usuários</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name}} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('usuario.password') }}">Mudança de Senha</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('logout') }}">Sair</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
