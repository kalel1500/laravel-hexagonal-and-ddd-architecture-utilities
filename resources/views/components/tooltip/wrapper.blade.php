@props(['id' => '', 'text' => ''])

@php
    // Capturamos el contenido del slot
    $slotContent = trim($slot->toHtml());

    // Usamos una expresión regular para encontrar el primer elemento HTML
    $slotContent = preg_replace(
        '/(<[a-zA-Z][^>]*)(>)/', // Busca el primer tag HTML
        '$1 data-tooltip-target="' . e('tooltip-'.$id) . '"$2', // Añade el atributo
        $slotContent,
        1 // Limita a la primera coincidencia
    );
@endphp

{!! $slotContent !!}
<x-tooltip id="tooltip-{{ $id }}">{{ $text }}</x-tooltip>