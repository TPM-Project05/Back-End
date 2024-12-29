<x-guest-layout>
    <form method="POST" action="{{ route('leader.submit') }}" enctype="multipart/form-data">
        @csrf

        <!-- Full Name -->
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
            @error('full_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Whatsapp Number -->
        <div class="mb-3">
            <label for="whatsapp_number" class="form-label">Whatsapp Number</label>
            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required>
            @error('whatsapp_number')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- LINE ID -->
        <div class="mb-3">
            <label for="line_id" class="form-label">LINE ID</label>
            <input type="text" class="form-control @error('line_id') is-invalid @enderror" id="line_id" name="line_id" value="{{ old('line_id') }}" required>
            @error('line_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Github/Gitlab ID -->
        <div class="mb-3">
            <label for="github_gitlab_id" class="form-label">Github/Gitlab ID</label>
            <input type="text" class="form-control @error('github_gitlab_id') is-invalid @enderror" id="github_gitlab_id" name="github_gitlab_id" value="{{ old('github_gitlab_id') }}" required>
            @error('github_gitlab_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Birth Place -->
        <div class="mb-3">
            <label for="birth_place" class="form-label">Birth Place</label>
            <select class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" required>
                <option value="">-- Select Birth Place --</option>
                <option value="Jakarta" {{ old('birth_place') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                <option value="Bandung" {{ old('birth_place') == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                <option value="Surabaya" {{ old('birth_place') == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
            </select>
            @error('birth_place')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Birth Date -->
        <div class="mb-3">
            <label for="birth_date" class="form-label">Birth Date</label>
            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
            @error('birth_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Upload CV -->
        <div class="mb-3">
            <label for="cv" class="form-label">Upload CV</label>
            <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" accept=".pdf,.jpg,.jpeg,.png" required>
            @error('cv')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
