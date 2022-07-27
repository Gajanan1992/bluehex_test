<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $search, $name, $modalOpen = false, $editMode = false, $categoryId;

    public function render()
    {
        $categories = Category::with(['posts'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.categories', [
            'categories' => $categories
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|max:255'
        ]);

        if ($this->editMode) {
            $category = Category::find($this->categoryId);
            $category->name = $this->name;
            $category->save();
            $this->editMode = false;
            $this->categoryId = null;
        } else {
            Category::create([
                'name' => $this->name
            ]);
        }

        $this->name = '';
        $this->modalOpen = false;
        session()->flash('message', 'Category created successfully');
    }

    public function edit($id)
    {
        $this->name = Category::find($id)->name;
        $this->categoryId = $id;
        $this->editMode = true;
        $this->modalOpen = true;
    }

    public function delete($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            session()->flash('message', 'Category deleted successfully');
        } catch (\Exception $ex) {
            session()->flash('message', 'Category could not be deleted');
            //throw $th;
        }
    }
}
