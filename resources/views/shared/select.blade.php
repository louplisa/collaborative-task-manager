@php
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= ucfirst($name);
    $multiple ??= false;
@endphp
<div @class([$class])>
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-select" name="{{ $name }}@if($multiple)[]@endif" id="{{ $name }}" @if($multiple) multiple @endif>
        @if(!$multiple)
            <option value="">-- Choisir une valeur --</option>
        @endif
        @foreach($options as $k => $v)
            <option @selected($multiple ? $value->contains($k) : $value === $k) value="{{ $k }}">{{ $v }}</option>
        @endforeach
    </select>
    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
