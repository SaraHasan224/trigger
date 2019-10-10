@extends('layouts.admin')
@section('styles')
    <style>
        .btn {
            padding: .84rem 1.14rem;
            font-size: .81rem;
        }
        .btn i, .fc-button i {
            font-size: 1rem;
        }
        .add_button{
            border-radius: 50%;
            margin-top: -7px;
        }
        .remove_addmore{
            margin-top: 1px;
        }
    </style>
@endsection
@section('contents')
    <div class="viewport-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb has-arrow">
                <li class="breadcrumb-item">
                    <a href="{{ route("admin-dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Mass Mailing</li>
            </ol>
        </nav>
    </div>
    <div class="content-viewport">
        @include("admin/includes/alerts")
        {!! Form::open([ 'url' => route('mass-email-send'), 'files' => true]) !!}
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <div class="grid-header">
                        <div class="title">Mass Mailing</div>
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
                                    <div class="col-md-11">
                                        {!! Form::email('recipient[]',  old("recipient[]"), ['id' => 'recipient', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" class="btn btn-primary add_alias_button add_button"><i class="fa fa-plus-square"></i></a>
                                    </div>
                                </div>
                                <div class="alias_addmore"></div>
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
    <script>
		$( document ).ready(function() {
			// Add More Alias Fields
			$('.alias_addmore').on('click', '.remove_addmore', function(e){
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
			});
			$('.add_alias_button').click(function (e) {
				$('.alias_addmore').append('<div class="row">'+
					'<div class="col-md-11">'+
                        '{!! Form::email('recipient[]',  old("recipient[]"), ['id' => 'recipient', 'class' => 'form-control']) !!}'+
					'</div>' +
					'<div class="col-md-offset-1 col-md-1">' +
					'    <a href="javascript:void(0)" class="btn btn-primary remove_addmore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div>' +
					'</div>');
			});
		});
    </script>
@endsection