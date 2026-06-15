@php
    $club = $club ?? null;
@endphp

<div class="logo-upload" data-logo-upload>
    <label class="form-label">Logo du club</label>

    <div class="logo-upload-box" data-logo-dropzone tabindex="0">
        <div class="logo-upload-preview" data-logo-preview>
            @if ($club?->logo)
                <img src="{{ asset('storage/' . $club->logo) }}" alt="Logo {{ $club->name }}">
            @endif
        </div>

        <div class="logo-upload-content">
            <small>Formats acceptes : JPG, PNG, WEBP. Taille maximale : 4 Mo.</small>
            <button class="logo-upload-button" data-logo-button type="button">Choisir un logo</button>
        </div>
    </div>

    <input
        class="logo-upload-input"
        data-logo-input
        type="file"
        name="logo"
        accept="image/*"
    >
</div>
