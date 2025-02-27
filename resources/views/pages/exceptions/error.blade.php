@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ExceptionContextDo $context */ @endphp
@extends('hexagonal::pages.exceptions.minimal')

@section('title', $context->getTitle())
@section('code', $context->getStatusCode())
@section('message', $context->message())


{{--
<div>
    <span>Variables:</span>
    <ul class="m-0">
        @foreach($data['data'] as $key => $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
</div>
--}}
