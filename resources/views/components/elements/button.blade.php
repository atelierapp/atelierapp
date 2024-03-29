@if($link ?? null)
  <a href="{{ $link }}" {{ $attributes }}>
    <div class="pt-8 flex space-x-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
      <div class="flex space-x-4 items-center px-8 py-6 rounded-full w-auto bg-white hover:bg-green-700 hover:text-white shadow transition ease-in-out delay-50 duration-300">
        {{ $icon }}
        <span>{{ $title }}</span>
      </div>
    </div>
  </a>
@else
  <div class="pt-8 flex space-x-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white" {{ $attributes }}>
    <div class="flex space-x-4 items-center px-8 py-6 rounded-full w-auto bg-white">
      {{ $icon }}
      <span class="text-gray-400">{{ $title }}</span>
    </div>
  </div>
@endif