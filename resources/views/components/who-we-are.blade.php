<div class="relative bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8 flex flex-col items-center">
  <div class="absolute inset-0">
    <div class="bg-white h-1/3 sm:h-2/3"></div>
  </div>
  <div class="relative max-w-7xl flex items-center flex-col" x-data>
    <div class="text-center flex flex-col space-y-4 w-4/5" x-intersect="$el.classList.add('slide-in-bottom')">
      <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4">
        {{ __('about.who-we-are') }}
      </h2>
      <div class="mx-auto py-6">
        <div class="h-1 bg-gray-500 w-20"></div>
      </div>
      <p class="text-md tracking-wide leading-8">
        {{ __('about.we-are-a-group-that-loves-design') }}
      </p>
      <p class="text-md tracking-wide leading-8">
        {{ __('about.we-make-designing-fun') }}
      </p>
      <p class="text-md tracking-wide leading-8">
        {{ __('about.we-provide-good-quality-products') }}
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16 pt-16">
    @foreach($team as $member)
      <div x-intersect="$el.classList.add('slide-in-bottom')">
        <x-elements.team-member
            name="{{ $member['name'] }}"
            position="{{ $member['position'] }}"
            biography="{{ $member['biography'] }}"
            image="{{ $member['image'] }}"
        />
      </div>
    @endforeach
    </div>
  </div>
</div>
