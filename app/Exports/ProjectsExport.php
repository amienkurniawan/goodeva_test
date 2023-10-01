<?php

namespace App\Exports;

use App\Models\Projects;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectsExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Project Name',
            'Project Start',
            'Project End',
            'Project Status'
        ];
    }
    public function collection()
    {
        return Projects::select('project_name', 'start_project', 'end_project', 'status')->get();
    }
}
