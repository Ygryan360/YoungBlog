@props([
    'label',
    'type' => 'text',
    'name',
    'value' => '',
    'required' => false,
    'placeholder' => '',
    'witherror' => false,
])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    <label class="label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}"
        {{ $required ? 'required' : '' }} class="input" placeholder="{{ $placeholder }}" />
    @if ($witherror)
        @error($name)
            <p class="mt-2 text-error font-bold">
                {{ $message }}
            </p>
        @enderror
    @endif
</div>
