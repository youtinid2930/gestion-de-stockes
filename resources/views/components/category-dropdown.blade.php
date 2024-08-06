@php
    function renderCategoryOptions($categories, $selected, $prefix = '') {
        $options = '';
        foreach ($categories as $category) {
            $isSelected = $category->id == $selected ? 'selected' : '';
            $options .= '<option value="' . $category->id . '" ' . $isSelected . '>' . $prefix . $category->name . '</option>';
            if ($category->sousCategories->count() > 0) {
                $options .= renderCategoryOptions($category->sousCategories, $selected, $prefix . '-- ');
            }
        }
        return $options;
    }
@endphp

{!! renderCategoryOptions($categories, $selected) !!}
