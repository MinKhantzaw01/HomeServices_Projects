<?php

namespace App\Http\Livewire\Admin;

use App\Models\ServiceCategory;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminAddServiceCategoryComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $image;

    public function generateSlug()
    {
        $this->slug=Str::slug($this->name,'-'); 
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required|mimes:png,jpeg',
        ]);
    }

    public function createNewCategory()
    {
        $this->validate([
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required|mimes:png,jpeg',
        ]);
        $scategory=new ServiceCategory();
        $scategory->name=$this->name;
        $scategory->slug=$this->slug;
        $imageName=Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->StoreAs('categories',$imageName);
        $scategory->image=$imageName;
        $scategory->save();

        session()->flash('message','Category has been created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.admin-add-service-category-component')->layout('layouts.base');
    }
}
