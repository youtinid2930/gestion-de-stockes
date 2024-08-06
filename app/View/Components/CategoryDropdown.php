<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Categorie;

class CategoryDropdown extends Component
{
    public $categories;
    public $selected;

    public function __construct($categories, $selected = null)
    {
        $this->categories = $categories;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('components.category-dropdown');
    }
}

