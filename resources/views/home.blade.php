@extends('layouts.default')

@section('main-content')

    <style>
        .teste{
            overflow: hidden!important;
        }
    </style>
 <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <h2><strong>eStock</strong></h2>
                </div>
                <div class="col-md-12" style="overflow: hidden;">
                    <div class="col-lg-3">
                        <div class="info-box bg-light-blue" style="width: 106%;overflow: hidden;">
                            <span class="info-box-icon" style="width: 70px;"><i class="fa fa-gavel"></i></span>
                            <div class="info-box-content" style="margin:0px 70px 0px 64px; padding: 5px 10px; width: 100%;">
                              <h2><a href="{{url('/obra/gerenciador')}}" style="color: #fff; font-weight: bold;">Obras</a></h2>
                                <div class="progress" style="margin: 5px -15px 5px -4px">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box bg-light-blue" style="width: 106%; overflow: hidden;">
                            <span class="info-box-icon" style="width: 70px;"><i class="glyphicon glyphicon-save"></i></span>
                            <div class="info-box-content" style="margin:0px 70px 0px 64px; padding: 5px 10px; width: 100%;">
                              <h2><a href="{{url('/entrada-estoque/gerenciador')}}" style="color: #fff; font-weight: bold;">Entrada</a></h2>
                                <div class="progress" style="margin: 5px -15px 5px -4px">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box bg-light-blue" style="width: 106%; overflow: hidden;">
                            <span class="info-box-icon" style="width: 70px;"><i class="glyphicon glyphicon-transfer"></i></span>
                            <div class="info-box-content" style="margin:0px 70px 0px 64px; padding: 5px 10px; width: 100%;">
                              <h2><a href="{{url('/transferencia-estoque/gerenciador')}}" style="color: #fff; font-weight: bold;">Transferência</a></h2>
                                <div class="progress" style="margin: 5px -15px 5px -4px">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box bg-light-blue" style="width: 106%;overflow: hidden;">
                            <span class="info-box-icon" style="width: 70px;"><i class="glyphicon glyphicon-open"></i></span>
                            <div class="info-box-content" style="margin:0px 70px 0px 64px; padding: 5px 10px; width: 100%;">
                              <h2><a href="{{url('/saida-estoque/gerenciador')}}" style="color: #fff; font-weight: bold;">Saída</a></h2>
                                <div class="progress" style="margin: 5px -15px 5px -4px">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box bg-light-blue" style="width: 106%;overflow: hidden;">
                            <span class="info-box-icon" style="width: 70px;"><i class="fa fa-pencil-square-o"></i></span>
                            <div class="info-box-content" style="margin:0px 70px 0px 64px; padding: 5px 10px; width: 100%;">
                              <h2><a href="{{url('/medicao/gerenciador')}}" style="color: #fff; font-weight: bold;">Medição</a></h2>
                                <div class="progress" style="margin: 5px -15px 5px -4px">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box bg-light-blue" style="width: 106%;overflow: hidden;">
                            <span class="info-box-icon" style="width: 70px;"><i class="fa fa-cubes"></i></span>
                            <div class="info-box-content" style="margin:0px 70px 0px 64px; padding: 5px 10px; width: 100%;">
                              <h2><a href="{{url('/estoque')}}" style="color: #fff; font-weight: bold;">Estoque</a></h2>
                                <div class="progress" style="margin: 5px -15px 5px -4px">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box bg-light-blue" style="width: 106%;overflow: hidden;">
                            <span class="info-box-icon" style="width: 70px;"><i class="fa fa-pie-chart"></i></span>
                            <div class="info-box-content" style="margin:0px 70px 0px 64px; padding: 5px 10px; width: 100%;">
                              <h2><a href="{{url('/gerencial')}}" style="color: #fff; font-weight: bold;">Gerencial</a></h2>
                                <div class="progress" style="margin: 5px -15px 5px -4px">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
