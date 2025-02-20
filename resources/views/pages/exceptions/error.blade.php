@extends('hexagonal::pages.exceptions.minimal')

@section('title', __('Server Error'))
@section('code', $code)
@section('message', $message)
