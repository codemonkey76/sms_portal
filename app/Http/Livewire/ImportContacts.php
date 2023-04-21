<?php

namespace App\Http\Livewire;


use App\Csv;
use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportContacts extends Component
{
    use WithFileUploads;

    public $showImportContacts = false;
    public $upload;
    public $columns;
    public $fieldColumnMap = [
        'first_name' => '',
        'last_name' => '',
        'company_name' => '',
        'number' => ''
    ];
    public $selectedList = '';
    public $lists;

    protected $rules = [
        'fieldColumnMap.number' => 'required',
        'fieldColumnMap.first_name' => 'nullable|string|max:80',
        'fieldColumnMap.last_name' => 'nullable|string|max:80',
        'fieldColumnMap.company_name' => 'nullable|string|max:80',
        'selectedList' => 'required'
    ];

    protected $validationAttributes = [
        'fieldColumnMap.number' => 'phone number',
        'fieldColumnMap.first_name' => 'first name',
        'fieldColumnMap.last_name' => 'last name',
        'fieldColumnMap.company_name' => 'company'
    ];

    public function mount()
    {
        $this->lists = ContactList::query()->where('customer_id', auth()->user()->current_customer_id)->get();
    }

    public function updatingUpload($value)
    {
        Validator::make(['upload' => $value], [
            'upload' => 'required|mimes:txt,csv'
        ])->validate();
    }

    public function updatedUpload()
    {
        $this->columns = Csv::from($this->upload)->columns();
        $this->guessWhichColumnsMapToWhichFields();
    }

    public function import()
    {
        $this->validate();

        Csv::from($this->upload)
            ->eachRow(function ($row) {
                Contact::create(
                    [
                        ...$this->extractFieldsFromRow($row),
                        'customer_id' => auth()->user()->current_customer_id,
                        'contact_list_id' => $this->selectedList
                    ]
                );
            });

        $this->reset();
        $this->emit('refreshContacts');
        $this->notify('Contacts imported successfully');
    }

    public function extractFieldsFromRow($row)
    {
        $attributes = collect($this->fieldColumnMap)
            ->filter()
            ->mapWithKeys(function($heading, $field) use ($row) {
                return [$field => $row[$heading]];
            })
            ->toArray();

        return $attributes;
    }

    public function guessWhichColumnsMapToWhichFields()
    {
        $guesses = [
            'first_name' => ['first_name', 'name'],
            'last_name' => ['last_name', 'surname', 'family_name'],
            'company_name' => ['company_name', 'company'],
            'number' => ['number', 'phone', 'phone_number', 'mobile', 'mobile_number']
        ];

        foreach ($this->columns as $column) {
            $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options));

            if ($match) $this->fieldColumnMap[$match] = $column;
        }
    }
}
