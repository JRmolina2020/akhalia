@extends('layout')
{{--  incluyendo navbar  --}}
@section('navbar')
@include('navbar')
@endsection
@section('title','- inicio')
@section('body')
<panel-home></panel-home>
@endsection