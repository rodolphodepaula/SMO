<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang='pt-br'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Gerenciamento Ocupacional</title>
<link rel="shortcut icon" href="{{ URL::asset('img/favicon.png') }}" type="image/x-icon" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/estilos.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<div class="container-fluid">

    <div id="corpo">
        <div id="title">Sistema de Medicina Ocupacional</div>
        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="form-group row">
                <label class="control-label col-sm-3" for="email">E-Mail:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" autofocus autocomplete="email"
                    required name="email">
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group row">
                <label class="control-label col-sm-3" for="password">Senha:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" autocomplete="current-password" required
                    id="password" name="password">
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <input type="submit" value="Entrar" class="btn btn-primary">
        </form>
    </div>

</div>
</body>
</html>
