<div id='alert' class="alert ">
    @if (notify()->ready())
        <script>
            showAlert('{{ notify()->type() }}', '{{ notify()->message() }}');
        </script>
    @endif
</div>