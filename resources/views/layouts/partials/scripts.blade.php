<!-- REQUIRED JS SCRIPTS -->
<!-- InputMask -->
<script src="{{ asset('/plugins/input-mask/inputmask.dependencyLib.jquery.js') }}"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.numeric.extensions.js') }}"></script>
<script src="{{ asset('/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('/plugins/priceFormat/jquery.priceformat.min.js') }}"></script>
<script src="{{ asset('/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/plugins/jQuerySlimScrollMaster/jquery.slimscroll.min.js') }}"></script>

<!-- Load and c3.js -->
<script src="{{ url('/') }}/plugins/c3/c3.min.js"></script>
<script src="{{ url('/') }}/plugins/c3/d3.v3.min.js"></script>

<!-- PhotoSwipe -->
<script src="{{ url('/') }}/js/photoswipe/photoswipe.js"></script>
<script src="{{ url('/') }}/js/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="{{ asset('/plugins/jQueryRotate/jQueryRotate.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>




