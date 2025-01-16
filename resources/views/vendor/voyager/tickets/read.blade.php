<?php

$ticket = $dataTypeContent;
?>
@extends('voyager::master')

@section('page_title', 'Orders')

@section('content')
<div class="container">
    <x-tickets.show :ticket='$ticket' />
</div>
@stop