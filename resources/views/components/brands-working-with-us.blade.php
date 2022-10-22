<div class="relative bg-white pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8 flex flex-col items-center" x-data>
  <div class="absolute inset-0">
    <div class="bg-white h-1/3 sm:h-2/3"></div>
  </div>
  <div class="relative max-w-7xl flex items-center flex-col" x-intersect="$el.classList.add('slide-in-bottom')">
    <div class="text-center flex flex-col space-y-4 w-4/5">
      <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4">
        {{ __('about.some-of-the-brands-that-work-with-us') }}
      </h2>
      <div class="mx-auto py-6">
        <div class="h-1 bg-gray-500 w-20"></div>
      </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 content-around gap-8 md:gap-16 pt-8 px-6 md:px-12">
      @foreach($brands as $brand)
        <div class="flex items-center justify-center" x-intersect="$el.classList.add('slide-in-bottom')">
          <img src="{{ $brand }}" alt="">
        </div>
      @endforeach
    </div>
  </div>
</div>
