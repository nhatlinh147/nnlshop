<style>
    @if ($val == 'white').{{ $val }}.custom-control-input:checked~.custom-control-label::before {
        background-color: {{ $val }} !important;
        border-style: inset;
    }

    input.{{ $val }}.custom-control-input~.custom-control-label::before {
        background-color: white !important;
    }

@else .{{ $val }}.custom-control-input:checked~.custom-control-label::before {
        background-color: {{ $val }} !important;
        border-color: {{ $val }} !important;

    }

    input.{{ $val }}.custom-control-input~.custom-control-label::before {
        background-color: {{ $val }} !important;
    }

    @endif
</style>
