<!-- resources/views/components/category-options.blade.php -->
@php
    $prefix = $prefix ?? '';
@endphp

@foreach ($categories as $category)
    <option value="{{ $category->id }}" {{ $category->id == $selected ? 'selected' : '' }}>
        {{ $prefix . $category->name }}
    </option>
    @if ($category->sousCategories->count() > 0)
        @include('components.category-options', ['categories' => $category->sousCategories, 'selected' => $selected, 'prefix' => $prefix . '-- '])
    @endif
@endforeach
