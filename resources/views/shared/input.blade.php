@php
    $type ??= 'text';
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= ucfirst($name);
    $disabled ??= false;
@endphp
<div @class(['form-group', $class])>
    @if($type !== 'hidden')
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    @if($type == 'textarea')
        <textarea
            class="form-control @error($name) is-invalid @enderror"
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            @if($disabled) disabled @endif
        >
            {{ old($name, $value) }}
        </textarea>
    @else
        <input
            class="form-control @error($name) is-invalid @enderror"
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($disabled) disabled @endif
        >
    @endif
    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
