@props(['disabled' => false, 'rows' => '4', 'cols' => '5', 'value' => ''])

<textarea {{ $disabled ? 'disabled' : '' }} rows="{{ $rows }}" cols="{{ $cols }}" {!! $attributes->merge(['class' => 'form-input rounded-md shadow-sm']) !!}>{{ $value }}</textarea>
