<div>
    <label for="{{ $id }}">{{ $label }}</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $id }}" value="active"
            @if ($value === 'active') checked @endif>
        <label class="form-check-label" for="{{ $id }}">
            Active
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $id }}"
            value="inactive" @if ($value === 'inactive') checked @endif>
        <label class="form-check-label" for="{{ $id }}">
            Inactive
        </label>
    </div>
    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
