<?php

namespace App\Exports;

use App\Models\Projects;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectsFormatExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'Project Name',
            'Project Start',
            'Project End'
        ];
    }
}
