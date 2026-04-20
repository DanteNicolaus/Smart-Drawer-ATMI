@extends('layouts.admin')
@section('title', 'Edit Lab')

@push('styles')
<style>
    .container { max-width: 700px; margin: 0 auto; padding: 30px 20px; }
    .page-card { background: white; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid rgba(0,0,0,0.05); }
    .card-head { background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%); color: white; padding: 20px 28px; display: flex; justify-content: space-between; align-items: center; }
    .card-head h5 { margin: 0; font-size: 18px; font-weight: 600; }
    .btn-back-head { padding: 8px 16px; background: rgba(255,255,255,0.2); color: white; border: 1.5px solid rgba(255,255,255,0.4); border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.2s; }
    .btn-back-head:hover { background: rgba(255,255,255,0.35); color: white; }
    .card-body { padding: 28px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; color: #374151; margin-bottom: 7px; font-size: 14px; }
    .required { color: #dc2626; }
    .form-control, .form-select { width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; transition: all 0.2s; background: #fafafa; font-family: inherit; color: #333; box-sizing: border-box; }
    .form-control:focus, .form-select:focus { outline: none; border-color: #f6ad55; background: white; box-shadow: 0 0 0 3px rgba(246,173,85,0.12); }
    .form-control.is-invalid { border-color: #dc2626; }
    .invalid-feedback { color: #dc2626; font-size: 12px; margin-top: 5px; display: block; }
    textarea.form-control { resize: vertical; min-height: 90px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .info-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 16px; margin-bottom: 24px; font-size: 13px; color: #92400e; }
    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid #f1f5f9; }
    .btn-cancel { padding: 11px 22px; background: #f1f5f9; color: #64748b; border: 1.5px solid #e2e8f0; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s; }
    .btn-cancel:hover { background: #e2e8f0; color: #334155; }
    .btn-update { padding: 11px 28px; background: linear-gradient(135deg, #f6ad55, #ed8936); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; font-family: inherit; transition: all 0.2s; box-shadow: 0 4px 12px rgba(246,173,85,0.35); }
    .btn-update:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(246,173,85,0.45); }
    @media (max-width: 640px) { .form-row { grid-template-columns: 1fr; } .form-actions { flex-direction: column-reverse; } .btn-cancel, .btn-update { width: 100%; text-align: center; } }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-card">
        <div class="card-head">
            <h5>✏️ Edit Lab</h5>
            <a href="{{ route('admin.lab.index') }}" class="btn-back-head">← Kembali</a>
        </div>
        <div class="card-body">
            <div class="info-box">
                ℹ️ Lab ini memiliki <strong>{{ $lab->lacis->count() }} laci</strong> yang terdaftar.
            </div>
            <form action="{{ route('admin.lab.update', $lab) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_lab">Kode Lab <span class="required">*</span></label>
                        <input type="text" class="form-control @error('kode_lab') is-invalid @enderror"
                               id="kode_lab" name="kode_lab"
                               value="{{ old('kode_lab', $lab->kode_lab) }}" required>
                        @error('kode_lab')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_lab">Nama Lab <span class="required">*</span></label>
                        <input type="text" class="form-control @error('nama_lab') is-invalid @enderror"
                               id="nama_lab" name="nama_lab"
                               value="{{ old('nama_lab', $lab->nama_lab) }}" required>
                        @error('nama_lab')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                               id="lokasi" name="lokasi"
                               value="{{ old('lokasi', $lab->lokasi) }}"
                               placeholder="Contoh: Gedung A Lantai 2">
                        @error('lokasi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span class="required">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="aktif"    {{ old('status', $lab->status) == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $lab->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                              id="deskripsi" name="deskripsi">{{ old('deskripsi', $lab->deskripsi) }}</textarea>
                    @error('deskripsi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.lab.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-update">💾 Update Lab</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection