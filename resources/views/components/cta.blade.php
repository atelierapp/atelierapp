<div class="relative" x-data>
  <div class="absolute inset-0 z-0">
    <img class="w-full h-full object-cover" src="{{ asset('images/cta-bg.png') }}" alt="Atelier Home Design">
    <div class="absolute inset-0 bg-pink-400 mix-blend-multiply" aria-hidden="true"></div>
  </div>
  <div
      class="max-w-2xl relative z-10 mx-auto flex items-center flex-col text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8"
      x-intersect="$el.classList.add('slide-in-bottom')"
  >
    <h2 class="text-white">
      <span class="block text-lg uppercase tracking-wider font-semibold">Available now!</span>
      <span class="block text-2xl font-medium tracking-wide sm:text-4xl">Beta available through TestFlight</span>
    </h2>
    <x-elements.button title="Get it for iOS" link="https://apps.apple.com/app/atelier-home-design/id1448129816">
      <x-slot name="icon">
        <svg class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.813 26.405"><path d="M24.833 26.33a2.169 2.169 0 01-1.327-1.018l-7.59-13.145L18.441 7.8l4.887 8.465h4.3a2.186 2.186 0 110 4.371h-1.776l1.439 2.494a2.185 2.185 0 01-2.458 3.2zm-21.51-.219a2.188 2.188 0 01-.8-2.985l.429-.744H8l-1.692 2.93a2.189 2.189 0 01-1.9 1.092 2.159 2.159 0 01-1.085-.293zm-1.137-5.479a2.186 2.186 0 110-4.371h4.3l5.9-10.214-1.6-2.77a2.185 2.185 0 113.784-2.184l.336.582.336-.582a2.186 2.186 0 013.786 2.185l-7.5 12.983h4.728l2.524 4.371z" fill="#bfe0d8"/></svg>
      </x-slot>
    </x-elements.button>
  </div>
</div>
