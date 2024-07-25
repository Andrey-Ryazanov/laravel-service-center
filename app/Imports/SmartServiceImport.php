<?php
namespace App\Imports;

use App\Models\Service;
use App\Models\Deadline;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SmartServiceImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $service = Service::where('id_service', $row['ID'])->first();
            if ($service){
                $service->update([
                    'name_service' => $row['Название'],
                    'description_service' => $row['Описание'],
                ]);
            }
            else{
                $nservice = new Service;
                $nservice->id_service = $row['ID'];
                $nservice->name_service = $row['Название'];
                $nservice->description_service = $row['Описание'];
                $nservice->save();
            }
        }
    }
}