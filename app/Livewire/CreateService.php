<?php

namespace App\Livewire;

use App\Livewire\Forms\ServiceForm;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateService extends Component
{
    use WithFileUploads;
    public ServiceForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        
        if ($this->form->image) {
            Storage::disk('public')->delete($this->form->image);
            $this->form->image = $this->form->image->store('photos', 'public');
        }
        
        Service::create($this->form->all());

        $this->dispatch('service-created', [
            'title' => 'Success!',
            'text' => 'Service saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-service')->to(AllServices::class);
    }

    public function update() {
        $this->validate();
        
        if ($this->form->image) {
            Storage::disk('public')->delete($this->form->image);
            $this->form->image = $this->form->image->store('photos', 'public');
        } else {
            $this->form->image = $this->form->db_Image;
        }

        $this->form->service->update(
            $this->form->all()
        );

        $this->dispatch('service-created', [
            'title' => 'Success!',
            'text' => 'Service saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('service-updated');
        $this->dispatch('refresh-service')->to(AllServices::class);
    }

    #[On('service-edit')]
    public function edit($id, $categoryId)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setService($id, $categoryId);
    }

    #[On('service-delete')]
    public function delete($id) {
        $service = Service::findOrfail($id);
        $service->delete();
        
        $this->dispatch('service-deleted');
        $this->dispatch('refresh-service')->to(AllServices::class);
    }

    public function resetImage() {
        $this->form->image = '';
    }

    public function resetInputs() {
        $this->form->resetInputs();
    }

    #[On('reset-modal')]
    public function close() {
        $this->resetInputs();
        $this->form->isEditing = $this->isEditing = false;
    }

    #[Computed()]
    public function serviceCategories() {
        return ServiceCategory::all();
    }

    public function render()
    {
        return view('livewire.create-service');
    }
}
