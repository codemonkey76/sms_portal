<?php

namespace App\Jobs;

use App\Csv;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImportContactsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected string $path, protected array $fieldColumnMap, protected int $contactListId, public int $customerId)
    {}

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $csv = Csv::from(new File(Storage::path($this->path)));

        DB::transaction(function () use ($csv) {
            $csv->eachRow(function ($row) {
                $attributes = $this->extractFieldsFromRow($row);

                // Basic safeguard against empty rows
                if (empty($attributes['number'])) {
                    return;
                }

                Contact::create(
                    [
                        ...$attributes,
                        'customer_id' => $this->customerId,
                        'contact_list_id' => $this->contactListId,
                    ]
                );
            });
        });

        Storage::delete($this->path);
    }

    public function extractFieldsFromRow($row): array
    {
        return collect($this->fieldColumnMap)
            ->filter()
            ->mapWithKeys(function ($heading, $field) use ($row) {
                return [$field => $row[$heading] ?? null];
            })
            ->toArray();
    }
}
