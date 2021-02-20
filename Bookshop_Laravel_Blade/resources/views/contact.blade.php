@extends('layout')
@section('content')
  <h1>Contact Us.</h1>
  <p>Please contact us by sending a message using the form below:</p>  
  {{$ HTML::ul($errors->all(), array('class'=>'errors'))}}

  <table>
    {{$ Form::open(array('url' => 'contact')) }}
      <tr>
        <td>{{$ Form::label('Subject:') }}</td>
        <td>{{$ Form::text('subject','Enter your subject') }}</td>
      </tr>
      <tr valign="top">
        <td>{{$ Form::label('Message:') }}</td>
        <td>{{$ Form::textarea('message','Enter your message') }}</td>
      </tr>
      <tr>
        <td/><td>{{$ Form::submit() }}</td>
      </tr>
    {{$ Form::close() }}
  </table>
@stop