<form action="{{ route($route) }}" method="POST" enctype="multipart/form-data" class="upload-form">
    @csrf
    <div class="form-group-file">
        <input type="file" name="{{ $id }}" id="{{ $id }}" class="file-input" accept=".csv" required>
        <label for="{{ $id }}" class="menu-button file-select-button">
            <span>{{ $label }}</span>
        </label>
        <button type="submit" class="menu-button upload-button" style="display: none;">
            <i class="bi bi-upload"></i>
        </button>
    </div>
</form>
