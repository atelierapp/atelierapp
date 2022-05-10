<div
      class="{{ ($fullWidth ?? false) ? 'col-span-2' : 'col-span-2 md:col-span-1' }}"
      x-intersect="$el.classList.add('slide-in-bottom')"
>
  <label for="{{ $name ?? (Str::camel($title)) }}" class="sr-only">{{ $title }}</label>
  <input
      wire:model.debounce.200ms="{{ $name ?? (Str::camel($title)) }}"
      id="{{ $name ?? (Str::camel($title)) }}"
      type="{{ $type ?? 'text' }}"
      @class([
        'py-4 px-6 block w-full sm:text-sm sm:leading-5 outline-none ring ring-1 ring-gray-700 focus:ring-gray-800 focus:shadow-outline-gray text-gray-900 placeholder-gray-300',
        'rounded-lg' => ! ($roundedFull ?? false),
        'rounded-full' => ($roundedFull ?? true),
        'text-center' => $centered ?? false,
        'ring-red-300 focus:ring-red-300 focus:shadow-outline-red text-red-900 placeholder-red-300' => $errors->has($name ?? (Str::camel($title))),
        'ring-gray-700 focus:ring-gray-800 focus:shadow-outline-gray text-gray-900 placeholder-gray-300' => ! $errors->has($name ?? (Str::camel($title))),
      ])
      placeholder="{{ $title }}"
      wire:loading.class="bg-gray-100"
      aria-invalid="false"
      aria-describedby="first-name"
  />
</div>