@extends('layouts.admin')

@section('title', 'Edit Alat')

@push('styles')
<style>
    .container { max-width: 900px; margin: 0 auto; padding: 30px 20px; }
    .page-card { background: white; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid rgba(0,0,0,0.05); }
    .card-head { background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%); color: white; padding: 20px 28px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
    .card-head h5 { margin: 0; font-size: 18px; font-weight: 600; }
    .btn-back-head { padding: 8px 16px; background: rgba(255,255,255,0.2); color: white; border: 1.5px solid rgba(255,255,255,0.4); border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.2s; white-space: nowrap; }
    .btn-back-head:hover { background: rgba(255,255,255,0.35); color: white; }
    .card-body { padding: 28px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; color: #374151; margin-bottom: 7px; font-size: 14px; }
    .required { color: #dc2626; }
    .form-control, .form-select { width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; transition: all 0.2s; background: #fafafa; font-family: inherit; color: #333; box-sizing: border-box; }
    .form-control:focus, .form-select:focus { outline: none; border-color: #f6ad55; background: white; box-shadow: 0 0 0 3px rgba(246,173,85,0.15); }
    .form-control.is-invalid, .form-select.is-invalid { border-color: #dc2626; }
    .invalid-feedback { color: #dc2626; font-size: 12px; margin-top: 5px; display: block; }
    textarea.form-control { resize: vertical; min-height: 100px; }
    .text-muted-sm { display: block; color: #94a3b8; font-size: 12px; margin-top: 5px; }
    .current-img-wrap { margin-bottom: 14px; }
    .current-img-wrap img { max-width: 180px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
    .current-img-wrap p { font-size: 12px; color: #94a3b8; margin-top: 6px; }
    .img-preview-wrap { margin-top: 14px; }
    .img-preview-wrap p { font-size: 12px; color: #94a3b8; margin-bottom: 6px; }
    .img-preview-wrap img { max-width: 280px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px; flex-wrap: wrap; }
    .btn-cancel { padding: 12px 24px; background: #f1f5f9; color: #64748b; border: 1.5px solid #e2e8f0; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s; }
    .btn-cancel:hover { background: #e2e8f0; color: #334155; }
    .btn-update { padding: 12px 28px; background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; font-family: inherit; transition: all 0.2s; box-shadow: 0 4px 12px rgba(246,173,85,0.35); }
    .btn-update:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(246,173,85,0.45); }
    .laci-hint { display: block; color: #94a3b8; font-size: 12px; margin-top: 5px; }
    .laci-hint a { color: #f6ad55; }
    @media (max-width: 640px) { .container { padding: 16px 12px; } .card-body { padding: 20px 16px; } .form-row { grid-template-columns: 1fr; } .form-actions { flex-direction: column-reverse; } .btn-cancel, .btn-update { width: 100%; text-align: center; } }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush

@section('content')
<div class="container">
    <div class="page-card">
        <div class="card-head">
            <h5>✏️ Edit Alat</h5>
            <a href="{{ route('admin.alat.index') }}" class="btn-back-head">← Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.alat.update', $alat) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_alat">Kode Alat <span class="required">*</span></label>
                        <input type="text"
                               class="form-control @error('kode_alat') is-invalid @enderror"
                               id="kode_alat" name="kode_alat"
                               value="{{ old('kode_alat', $alat->kode_alat) }}" required>
                        @error('kode_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_alat">Nama Alat <span class="required">*</span></label>
                        <input type="text"
                               class="form-control @error('nama_alat') is-invalid @enderror"
                               id="nama_alat" name="nama_alat"
                               value="{{ old('nama_alat', $alat->nama_alat) }}" required>
                        @error('nama_alat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kategori">Kategori <span class="required">*</span></label>
                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Perkakas_tangan" {{ old('kategori', $alat->kategori) == 'Perkakas_tangan' ? 'selected' : '' }}>Perkakas tangan</option>
                            <option value="Toolbox"         {{ old('kategori', $alat->kategori) == 'Toolbox'         ? 'selected' : '' }}>Toolbox</option>
                        </select>
                        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="kondisi">Kondisi <span class="required">*</span></label>
                        <select class="form-select @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baik"         {{ old('kondisi', $alat->kondisi) == 'baik'         ? 'selected' : '' }}>Baik</option>
                            <option value="rusak ringan" {{ old('kondisi', $alat->kondisi) == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak berat"  {{ old('kondisi', $alat->kondisi) == 'rusak berat'  ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        @error('kondisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah_total">Jumlah Total <span class="required">*</span></label>
                        <input type="number"
                               class="form-control @error('jumlah_total') is-invalid @enderror"
                               id="jumlah_total" name="jumlah_total"
                               value="{{ old('jumlah_total', $alat->jumlah_total) }}" min="1" required>
                        @error('jumlah_total')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <span class="text-muted-sm">Tersedia saat ini: {{ $alat->jumlah_tersedia }}</span>
                    </div>

                    <!-- Pilih Laci -->
                    <div class="form-group">
                        <label for="laci_id">Laci Penyimpanan</label>
                        <select class="form-select @error('laci_id') is-invalid @enderror"
                                id="laci_id" name="laci_id">
                            <option value="">-- Pilih Laci --</option>
                            @foreach($lacis as $laci)
                            <option value="{{ $laci->id }}"
                                {{ old('laci_id', $alat->laci_id) == $laci->id ? 'selected' : '' }}>
                                {{ $laci->kode_laci }} - {{ $laci->nama_laci }}
                                @if($laci->lokasi)({{ $laci->lokasi }})@endif
                            </option>
                            @endforeach
                        </select>
                        @error('laci_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <span class="laci-hint">
                            Laci saat ini: 
                            @if($alat->laci)
                                <strong>{{ $alat->laci->kode_laci }} - {{ $alat->laci->nama_laci }}</strong>
                            @else
                                <em>Belum dipilih</em>
                            @endif
                            | <a href="{{ route('admin.laci.create') }}" target="_blank">+ Tambah laci baru</a>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                              id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="foto">Foto Alat</label>
                    @if($alat->foto)
                    <div class="current-img-wrap">
                        <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}">
                        <p>Foto saat ini</p>
                    </div>
                    @endif
                    <input type="file"
                           class="form-control @error('foto') is-invalid @enderror"
                           id="foto" name="foto"
                           accept="image/jpeg,image/png,image/jpg"
                           onchange="previewImage(event)">
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <span class="text-muted-sm">Format: JPG, PNG. Maks 2MB. Kosongkan jika tidak ingin mengubah.</span>
                    <div class="img-preview-wrap" id="imagePreview" style="display:none;">
                        <p>Preview foto baru:</p>
                        <img id="preview" src="" alt="Preview">
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.alat.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-update">💾 Update Alat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection