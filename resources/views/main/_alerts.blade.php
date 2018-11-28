<script>
    window.validationErrors = @json($errors->getMessages());
</script>

@if(Session::has('success'))
    <div class="alert alert-success  main-font">
        {{ Session::get('success')}}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mb-3 main-font" id="validation-errors">
        <b>Errors found while validating your request:</b>
        <ul>
            {!! implode('', $errors->all('<li>:message</li>')) !!}
        </ul>
    </div>
@endif