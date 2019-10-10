@extends('layouts.admin')
@section('contents')
    <div class="viewport-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb has-arrow">
                <li class="breadcrumb-item">
                    <a href="{{ route("admin-dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Emails</li>
            </ol>
        </nav>
    </div>
    <div class="content-viewport">
        @include("admin/includes/alerts")
        {!! Form::open([ 'url' => route('email-save'), 'files' => true]) !!}
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <div class="grid-header">
                        <div class="title">Send a new mail</div>
                        <div class="actions">
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <button type="submit" class="btn btn-success has-icon"><i class="fa fa-mail-forward"></i>Send</button>
                                    <button type="button" onClick="location.href='{{ route("admin-dashboard") }}'" class="btn btn-danger has-icon"><i class="fa fa-times"></i>Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="item-wrapper">
                                <div class="form-group">
                                    <label for="recipient">Recipients:</label>
                                    <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::email('recipient',  old("recipient"), ['id' => 'recipient', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                {!! Form::text('subject',  old("subject"), ['id' => 'subject', 'class' => 'form-control', 'maxlength' => '100']) !!}
                            </div>
                            <div class="form-group">
                                <label for="attachment">Attachements:</label>
                                {!! Form::file('attachment', null, ['id' => 'attachment', 'class' => 'form-control', 'multiple' => true]) !!}
                            </div>
                            <div class="form-group">
                                <label for="message">Message:</label>
                                {!! Form::textarea('message', old("message"), ['id' => 'message', 'class' => 'form-control', 'rows' => 10, 'cols' => 54]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! FORM::close() !!}
    </div>
@endsection
@section('js_plugins')
    <script src="{{asset('public/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script>
		CKEDITOR.replace( 'message' );
    </script>
@endsection