<!DOCTYPE html>
<html lang="pt_BR">

@section('htmlheader')
    @include('layouts.partials.htmlheader')
@show
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini" style="overflow: hidden;">
<div class="wrapper">
    
  @include('layouts.partials.mainheader')

  @include('layouts.partials.sidebar')
  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="overflow: auto">
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div id="style-2" style="height: 85vmin; overflow-x: hidden; padding-right: 5px;">
        @yield('main-content')
        </div>
    </section>
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    var urlBase = '{{ url('') }}/';
</script>

@include('layouts.partials.footer')

@include('layouts.photoswipe-form')

@section('scripts')
    @include('layouts.partials.scripts')
    @yield('scripts-footer')
@show

</body>
</html>