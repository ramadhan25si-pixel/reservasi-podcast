<?php

namespace App\Http\Requests;

use App\Models\Fasilitas;
use App\Models\Reservasi;
use App\Models\RuangPodcast;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreReservasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route sudah dilindungi middleware auth
    }

    public function rules(): array
    {
        return [
            'ruang_id'          => ['required', 'exists:ruang_podcast,id'],
            'tanggal_reservasi' => ['required', 'date', 'after_or_equal:today'],
            'waktu_mulai'       => ['required', Rule::in(Reservasi::JAM_OPERASIONAL)],
            'waktu_selesai'     => ['required', Rule::in(Reservasi::JAM_OPERASIONAL), 'after:waktu_mulai'],
            'keperluan'         => ['required', 'string', 'max:255'],
            'fasilitas'         => ['nullable', 'array'],
            'fasilitas.*'       => ['integer', 'min:1'],
            'setuju'            => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'ruang_id.required'                => 'Pilih ruangan terlebih dahulu.',
            'tanggal_reservasi.required'       => 'Tanggal reservasi wajib diisi.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh sebelum hari ini.',
            'waktu_mulai.required'             => 'Waktu mulai wajib dipilih.',
            'waktu_selesai.required'           => 'Waktu selesai wajib dipilih.',
            'waktu_selesai.after'              => 'Waktu selesai harus setelah waktu mulai.',
            'keperluan.required'               => 'Keperluan wajib diisi.',
            'setuju.accepted'                  => 'Anda harus menyetujui tata tertib sebelum mengirim reservasi.',
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $ruang = RuangPodcast::find($this->ruang_id);

            if ($ruang->status_ruang !== 'tersedia') {
                $validator->errors()->add('ruang_id', 'Ruang sedang maintenance dan tidak bisa dipesan.');
                return;
            }

            if (Carbon::parse($this->tanggal_reservasi)->isWeekend()) {
                $validator->errors()->add('tanggal_reservasi', 'Reservasi hanya tersedia Senin sampai Jumat.');
                return;
            }

            $durasi = (int) substr($this->waktu_selesai, 0, 2) - (int) substr($this->waktu_mulai, 0, 2);
            if ($durasi > Reservasi::MAKS_DURASI_JAM) {
                $validator->errors()->add('waktu_selesai', 'Durasi maksimal ' . Reservasi::MAKS_DURASI_JAM . ' jam per reservasi.');
                return;
            }

            if (Reservasi::bentrok($ruang->id, $this->tanggal_reservasi, $this->waktu_mulai, $this->waktu_selesai)->exists()) {
                $validator->errors()->add('waktu_mulai', 'Jadwal bentrok dengan reservasi lain. Pilih waktu atau tanggal yang berbeda.');
                return;
            }

            foreach ($this->input('fasilitas', []) as $id => $qty) {
                $fasilitas = Fasilitas::find($id);

                if (! $fasilitas || (int) $fasilitas->ruang_id !== (int) $ruang->id) {
                    $validator->errors()->add("fasilitas.$id", 'Ada fasilitas yang tidak tersedia di ruang yang dipilih.');
                } elseif ((int) $qty > $fasilitas->jumlah) {
                    $validator->errors()->add("fasilitas.$id", "Jumlah {$fasilitas->nama_fasilitas} melebihi stok ({$fasilitas->jumlah}).");
                }
            }
        }];
    }
}