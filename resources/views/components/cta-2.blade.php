<div class="relative">
  <div class="absolute inset-0 z-0">
    <img class="w-full h-full object-cover" src="{{ asset('images/atelier-design-app-demo.png') }}" alt="Atelier Home Design">
    <div class="absolute inset-0" aria-hidden="true"></div>
  </div>
  <div class="max-w-3xl relative z-10 mx-auto flex items-center flex-col text-center py-16 px-4 sm:py-20 px-10 sm:px-6" x-data>
    <h2
        class="text-white"
        x-intersect="$el.classList.add('slide-in-bottom')"
    >
      <span class="block text-lg font-medium tracking-wide md:text-xl">{{ __('cta.your-products-will-be-valued') }}</span>
    </h2>
    <x-elements.button title="{{ __('cta.open-your-shop') }}" :link="route('web-app')" x-intersect="$el.classList.add('slide-in-bottom')">
      <x-slot name="icon">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6" data-name="Group 226" viewBox="0 0 40.55 37.54">
          <defs><clipPath id="a"><path fill="#b4e8db" d="M0 0h40.55v37.54H0z" data-name="Rectangle 40"/></clipPath></defs><g fill="#b4e8db" clip-path="url(#a)" data-name="Group 225"><path d="M38.45 37.54H2.15a3.98 3.98 0 0 1-.06-.47V15.02a6.94 6.94 0 0 0 7.31-2.38 6.97 6.97 0 0 0 10.9 0 6.97 6.97 0 0 0 10.9.01 7.04 7.04 0 0 0 7.31 2.39v22.07a3.34 3.34 0 0 1-.05.42M34 18.93h-9.54v14.58h9.53Zm-15.86 0H6.6v6.04h11.53Z" data-name="Path 401"/><path d="M0 8.93v-.56a.6.6 0 0 0 .07-.14C.52 5.7.97 3.17 1.44.64c.13-.72-.06-.63.74-.63h36.23a2.8 2.8 0 0 0 .32 0c.25-.03.33.07.37.32.44 2.48.88 4.96 1.35 7.44a3.55 3.55 0 0 1-.11 2.05 3.8 3.8 0 0 1-3.49 2.57 3.67 3.67 0 0 1-3.61-1.97 12.11 12.11 0 0 1-.7-1.94H29.7a4.04 4.04 0 0 1-1.24 2.83 3.85 3.85 0 0 1-2.92 1.1 4.02 4.02 0 0 1-3.8-3.91h-2.93a4.01 4.01 0 0 1-3.57 3.9 3.73 3.73 0 0 1-2.56-.64 4.05 4.05 0 0 1-1.82-3.28H7.98a12.07 12.07 0 0 1-.3 1.22 3.76 3.76 0 0 1-3.34 2.68A3.7 3.7 0 0 1 .6 10.49 9.18 9.18 0 0 1 0 8.93" data-name="Path 402"/></g>
        </svg>
      </x-slot>
    </x-elements.button>
  </div>
</div>
