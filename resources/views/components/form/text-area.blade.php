<div
    class="{{ ($fullWidth ?? false) ? 'col-span-2' : 'col-span-2 md:col-span-1' }}"
     x-intersect="$el.classList.add('slide-in-bottom')"
>
  <label for="{{ $name ?? (\Illuminate\Support\Str::camel($title)) }}" class="sr-only">{{ $title }}</label>
  <textarea
      wire:model.lazy="{{ $name ?? (\Illuminate\Support\Str::camel($title)) }}"
      id="{{ $name ?? (\Illuminate\Support\Str::camel($title)) }}"
      rows="3"
      class="py-4 px-6 rounded-lg block w-full sm:text-sm sm:leading-5 outline-none ring ring-[1px] ring-gray-700 focus:ring-gray-800 placeholder-gray-300 @error($name ?? (\Illuminate\Support\Str::camel($title))) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
      placeholder="{{ $title }}"
      wire:loading.class="bg-gray-100"
      aria-invalid="false"
      aria-describedby="first-name"
  >
  </textarea>
</div>