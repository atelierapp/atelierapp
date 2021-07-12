<div class="bg-pink-500">
  <img class="w-full" src="{{ asset($image) }}" alt="{{ $name }} / Atelier Team">
  <div class=" flex flex-col items-center space-x-2 py-16 px-8">
    <h3 class="uppercase text-lg tracking-wider">{{ $name }}</h3>
    <span class="text-gray-400 text-md">{!! $position !!}</span>
    <p class="leading-6 tracking-wide text-gray-400 pt-3 text-center text-sm">{{ $biography }}</p>
  </div>
</div>