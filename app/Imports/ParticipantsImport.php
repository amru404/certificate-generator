<?php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ParticipantsImport implements ToModel, WithHeadingRow
{
    use SkipsFailures;

    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row)
    {
        // Validasi kolom wajib
        if (empty($row['nama']) || empty($row['email']) || empty($row['no_telepon'])) {
            return null;
        }

        $existingParticipant = Participant::where('email', $row['email'])
            ->where('event_id', $this->eventId)
            ->first();

        if ($existingParticipant) {
            return null;
        }

        return new Participant([
            'nama'     => $row['nama'],
            'email'    => $row['email'],
            'no_telp'  => $row['no_telepon'],
            'event_id' => $this->eventId,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Validasi format header kolom.
     */
    public function validateHeaders(array $headers)
    {
        $expectedHeaders = ['nama', 'email', 'no_telepon'];

        foreach ($expectedHeaders as $expectedHeader) {
            if (!in_array($expectedHeader, $headers)) {
                throw new \Exception('Kolom tidak sesuai. Harus terdapat: ' . implode(', ', $expectedHeaders));
            }
        }
    }

    public function onRowStart(int $rowIndex, array $headers)
    {
        if ($rowIndex === 1) {
            $this->validateHeaders($headers);
        }
    }
}
