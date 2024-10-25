@if($errors->any())
    <x-alert.list id="alert-errors" color="red" title="{{ __('Several errors have been detected') }}:" xmlns:x-slot="http://www.w3.org/1999/xlink">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </x-alert.list>
@endif

@if(session()->has('success'))
    <x-alert.simple id="alert-success" color="green">{{ session()->get('success') }}</x-alert.simple>
@endif

@if(session()->has('error'))
    <x-alert.simple id="alert-success" color="red">{{ session()->get('error') }}</x-alert.simple>
@endif

@if(session()->has('severalErrors'))
    <x-alert.list id="alert-errors" color="red">
        @foreach(session()->get('severalErrors') as $key => $error)
            @if($key === 0)
                <x-slot:title>{{ $error }}</x-slot:title>
            @else
                <li>{{ $error }}</li>
            @endif
        @endforeach
    </x-alert.list>
@endif
