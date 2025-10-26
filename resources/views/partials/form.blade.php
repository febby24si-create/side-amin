@if(isset($fields))
    @foreach($fields as $field)
        <div class="form-group">
            <label for="{{ $field['name'] }}">
                {{ $field['label'] }} 
                @if(isset($field['required']) && $field['required'])
                    <span class="text-danger">*</span>
                @endif
            </label>
            
            @if($field['type'] === 'text' || $field['type'] === 'email' || $field['type'] === 'password' || $field['type'] === 'date')
                <input type="{{ $field['type'] }}" 
                       class="form-control @error($field['name']) is-invalid @enderror" 
                       id="{{ $field['name'] }}" 
                       name="{{ $field['name'] }}" 
                       value="{{ old($field['name'], $field['value'] ?? '') }}"
                       @if(isset($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
                       @if(isset($field['required']) && $field['required']) required @endif
                       @if($field['type'] === 'email') autocomplete="email" @endif>
            @elseif($field['type'] === 'textarea')
                <textarea class="form-control @error($field['name']) is-invalid @enderror" 
                          id="{{ $field['name'] }}" 
                          name="{{ $field['name'] }}" 
                          rows="{{ $field['rows'] ?? 3 }}"
                          @if(isset($field['required']) && $field['required']) required @endif>{{ old($field['name'], $field['value'] ?? '') }}</textarea>
            @elseif($field['type'] === 'select')
                <select class="form-control @error($field['name']) is-invalid @enderror" 
                        id="{{ $field['name'] }}" 
                        name="{{ $field['name'] }}"
                        @if(isset($field['required']) && $field['required']) required @endif>
                    <option value="">Pilih {{ $field['label'] }}</option>
                    @foreach($field['options'] as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}" 
                            {{ old($field['name'], $field['value'] ?? '') == $optionValue ? 'selected' : '' }}>
                            {{ $optionLabel }}
                        </option>
                    @endforeach
                </select>
            @endif
            
            @error($field['name'])
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if(isset($field['help']))
                <small class="form-text text-muted">{{ $field['help'] }}</small>
            @endif
        </div>
    @endforeach
@endif