@extends('template.page')

@section('page_header')
@include('partials.header.default')
@endsection

@section('page_content')
@include('partials.datatables.custom')

@include('partials.table.float-menu')
@endsection
