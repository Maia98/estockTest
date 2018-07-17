@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4" >
          <div class="login-box">
              <div class="thumbnail">
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
                              <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                  {{ csrf_field() }}
                                  <div class="col-xs-12">
                                      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                          <div class="col-md-12">
                                              <div class="input-group">
                                                  <div class="input-group-addon" style="background: #fff;">
                                                      <i class="fa fa-envelope-o"></i>
                                                  </div>
                                                  <input placeholder="Email" id="email" type="email"  class="form-control" name="email" value="{{ old('email') }}" required>
                                              </div>
                                              @if ($errors->has('email'))
                                                  <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                              @endif
                                          </div>
                                      </div>

                                      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                          <div class="col-md-12">
                                              <div class="input-group">
                                                  <div class="input-group-addon" style="background: #fff;">
                                                      <i class="fa fa-key"></i>
                                                  </div>
                                                  <input placeholder="senha" id="password" type="password" class="form-control" name="password" required>
                                              </div>

                                              @if ($errors->has('password'))
                                                  <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                              @endif
                                          </div>
                                      </div>
                                      <br/>
                                      <div class="form-group">
                                          <div class="col-md-12">
                                              <button type="submit" class="btn btn-primary btn-flat btn-block" >
                                                  Login
                                              </button>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-md-12 text-center">
                                              <a class="btn btn-link" href="{{ route('password.request') }}">
                                                  Esqueceu sua Senha?
                                              </a>
                                          </div>
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
