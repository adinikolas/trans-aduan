<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class ComplaintExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Builder $query;

    protected int $rowNumber = 0;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query(): Builder
    {
        return $this->query;
    }


    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jam',
            'Pelapor',
            'Divisi Tujuan',
            'Pengemudi',
            'No Armada',
            'TKP',
            'Jenis Aduan',
            'Isi Aduan',
            'Keterangan',
            'Status',
        ];
    }

    public function map($complaint): array
    {
        $incidentTime = Carbon::parse($complaint->incident_time);

        $statusLabel = match ($complaint->status) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'menunggu_validasi_cc' => 'Menunggu Validasi CC',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => $complaint->status,
        };

        return [
            ++$this->rowNumber,
            $incidentTime->format('d/m/Y'),
            $incidentTime->format('H:i'),
            $complaint->user?->name ?? '-',
            $complaint->division?->name ?? 'Belum Ditugaskan',
            $complaint->driver_name ?? '-',
            $complaint->bus_number ?? '-',
            $complaint->location ?? '-',
            $complaint->category?->name ?? '-',
            $complaint->description,
            $complaint->resolution_notes ?? '-',
            $statusLabel,
        ];
    }
}
