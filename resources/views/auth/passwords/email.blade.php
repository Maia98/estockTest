@extends('layouts.app')

@section('content')
    <style>
        body{
            background-image: url({{ URL::asset('img/logo-lg.png') }});
            background-color: #f7f7f7;
            background-repeat: no-repeat;
            background-position: right;
            background-size: 73vh 61vh;
            background-position-y: bottom;
        }
    </style>
    <div class="container">
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4" style="margin-top: 10%;">
                <div class="login-box" style="border: 5px solid rgba(202,224,252,0.5);border-radius:  8px; box-shadow: 0 5px 6px -2px #3c8dbc;">
                    <div class="thumbnail" style="background-color: #fff; border-radius: 0px; margin-bottom: 0;">
                        <div class="login-logo">
                            <center>
                              @if(file_exists(public_path().'/storage/imagens/empresa/') && isset(\File::allFiles(public_path().'/storage/imagens/empresa/')[0]))
                                <img src="{{  url('storage/imagens/empresa/').'/'.\File::allFiles(public_path().'/storage/imagens/empresa/')[0]->getfilename() }}" alt="eStock" class="img-responsive" style="width: 250px;">
                              @else
                                  <span>eStock</span>
                              @endif
                          </center>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="login-form">
                                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-addon" style="background: #fff;">
                                                        <i class="fa fa-envelope-o"></i>
                                                    </div>
                                                    <input placeholder="Email" id="email" type="email"  class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                                </div>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary btn-flat btn-block">
                                                    Enviar link de reset
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection