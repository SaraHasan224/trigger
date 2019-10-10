<div class="alert alert-danger dismissible-alert {{ (Session::has('errors') ? '' : ' hide') }}" role="alert">
    <b>Error(s)!</b><br>
    @if (gettype($errors) == 'object')
        {{-- @foreach (array_unique($errors->all()) as $msg) --}}
        @foreach ($errors->all() as $msg)
            {{ $msg }} <br>
        @endforeach
    @elseif (Session::has('errors'))
        @foreach (Session::get('errors') as $error)
            {{ $error }}  <br>
        @endforeach
    @endif
</div>
<div class="alert alert-warning dismissible-alert{{ (Session::has('warning_msg') ? '' : ' hide') }}" role="alert">
    <b>Warning:</b>
    @if (Session::has('warning_msg'))
        {{ Session::get('warning_msg') }}
    @endif
</div>
<div class="alert alert-info dismissible-alert{{ (Session::has('info_msg') ? '' : ' hide') }}" role="alert">
    <b>Info:</b>
    @if (Session::has('info_msg'))
        {{ Session::get('info_msg') }}
    @endif
</div>
<div class="alert alert-success dismissible-alert{{ (Session::has('success') ? '' : ' hide') }}" role="alert">
    <b>Success:</b>
    @if (Session::has('success'))
        {!! Session::get('success') !!}
    @endif
</div>
<div class="alert alert-success dismissible-alert{{ (Session::has('status') ? '' : ' hide') }}" role="alert">
    <b>Status:</b>
    @if (Session::has('status'))
        {!! Session::get('status') !!}
    @endif
</div>