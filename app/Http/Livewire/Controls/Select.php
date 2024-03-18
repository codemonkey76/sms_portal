<?php

namespace App\Http\Livewire\Controls;

use Livewire\Component;

class Select extends Component
{
    public string $selected = '';

    public bool $stacked = true;

    public string $value = 'id';

    public string $primary = 'name';

    public string $secondary;

    public string $photo = 'photo';

    public string $name = '';

    public array $list = [];

    protected $listeners = ['rerenderList' => 'refresh'];

    public function mount($list)
    {
        $this->list = $list;
    }

    public function click($number)
    {
        if ($this->selected == $number) {
            $this->selected = '';
        } else {
            $this->selected = $number;
        }
        $this->emit('itemSelected', ['selected' => $this->selected, 'name' => $this->name]);
    }

    public function refresh()
    {
        info('Refreshing component');
        $this->mount($this->list);
    }

    public function render()
    {
        $list = $this->list;

        return view('livewire.controls.select', compact('list'));
    }
}
