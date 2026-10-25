{{--
    Form fasilitas yang dipakai bersama oleh create & edit.
    Variabel yang diharapkan:
      $facility    => model Facility (edit) atau null (create)
      $action      => URL tujuan form
      $method      => 'POST' (create) atau 'PUT' (edit)
      $submitLabel => teks tombol simpan
--}}

@php
    $inputClass = 'h-[52px] w-full rounded-md bg-[#f5f5f5] px-4 text-[15px] text-[#303030] outline-none';
    $labelClass = 'mb-1 block text-[16px] font-medium text-white';
@endphp

@if ($errors->any())
    <div class="mt-4 rounded-md border border-red-400/50 bg-red-400/10 px-4 py-3 text-[14px] text-red-300">
        <ul class="list-disc pl-4">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="name" class="{{ $labelClass }}">Name</label>
            <input id="name" name="name" type="text" required
                value="{{ old('name', $facility?->name) }}"
                placeholder="e.g. Computer Laboratory"
                class="{{ $inputClass }}">
        </div>

        <div>
            <label for="category" class="{{ $labelClass }}">Category</label>
            <input id="category" name="category" type="text" required list="category-options"
                value="{{ old('category', $facility?->category) }}"
                placeholder="e.g. Laboratory"
                class="{{ $inputClass }}">
            <datalist id="category-options">
                <option value="Laboratory"></option>
                <option value="Hall"></option>
                <option value="Classroom"></option>
                <option value="Equipment"></option>
                <option value="Sport Court"></option>
            </datalist>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="location" class="{{ $labelClass }}">Location</label>
            <input id="location" name="location" type="text" required
                value="{{ old('location', $facility?->location) }}"
                placeholder="e.g. IELTS Centre"
                class="{{ $inputClass }}">
        </div>

        <div>
            <label for="capacity" class="{{ $labelClass }}">Capacity <span class="text-white/50">(optional)</span></label>
            <input id="capacity" name="capacity" type="number" min="1"
                value="{{ old('capacity', $facility?->capacity) }}"
                placeholder="e.g. 30"
                class="{{ $inputClass }}">
        </div>
    </div>

    <div>
        <label for="status" class="{{ $labelClass }}">Status</label>
        <select id="status" name="status" class="{{ $inputClass }}">
            @php $currentStatus = old('status', $facility?->status ?? 'active'); @endphp
            <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Active (can be booked)</option>
            <option value="retired" {{ $currentStatus === 'retired' ? 'selected' : '' }}>Retired (hidden from students)</option>
        </select>
    </div>

    <div>
        <label for="description" class="{{ $labelClass }}">Description <span class="text-white/50">(optional)</span></label>
        <textarea id="description" name="description" rows="4"
            class="w-full rounded-md bg-[#f5f5f5] px-4 py-3 text-[15px] text-[#303030] outline-none"
            placeholder="Short description of this facility">{{ old('description', $facility?->description) }}</textarea>
    </div>

    <div>
        <label for="image" class="{{ $labelClass }}">Photo <span class="text-white/50">(optional, max 2 MB)</span></label>

        @if ($facility?->image)
            <div class="mb-3 h-[120px] w-[180px] overflow-hidden rounded-md">
                <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="h-full w-full object-cover">
            </div>
        @endif

        <input id="image" name="image" type="file" accept="image/*"
            class="block w-full text-[14px] text-white/80 file:mr-4 file:cursor-pointer file:rounded-md file:border-0 file:bg-[#639178] file:px-4 file:py-2 file:text-[14px] file:font-semibold file:text-white hover:file:bg-[#527d66]">

        @if ($facility?->image)
            <p class="mt-2 text-[13px] text-white/50">Leave empty to keep the current photo.</p>
        @endif
    </div>

    <div class="flex flex-col gap-3 sm:flex-row">
        <button type="submit" class="h-[48px] rounded-md bg-[#639178] px-10 text-[16px] font-semibold text-white transition hover:bg-[#527d66]">
            {{ $submitLabel }}
        </button>

        <a href="{{ route('admin.facilities.index') }}"
            class="flex h-[48px] items-center justify-center rounded-md border border-white/30 px-10 text-[16px] font-semibold text-white transition hover:bg-white/5">
            Cancel
        </a>
    </div>

</form>
