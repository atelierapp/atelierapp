<div class="w-full bg-white" x-data>
  <div class="w-full md:w-2/3 py-16 px-10 mx-auto">
    @unless($registered)
      <div class="text-center py-8">
        <h2
            class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4"
            x-intersect="$el.classList.add('slide-in-bottom')"
        >
          Tell us about you
        </h2>
      </div>
      <form class="grid grid-cols-2 gap-5" wire:submit.prevent="submit">
        <x-form.input title="First Name"/>
        <x-form.input title="Last Name"/>
        <x-form.input title="Email"/>
        <x-form.input title="Phone"/>
        <x-form.input title="Address" fullWidth="true"/>
        <x-form.input title="Company"/>
        <x-form.input title="Position"/>
        <x-form.text-area title="Tell us about your business" name="about" fullWidth="true"/>
        <x-form.input title="Web Address" name="website" fullWidth="true" textArea="true"/>
        <div
            class="col-span-2 flex justify-center"
            x-intersect="$el.classList.add('slide-in-bottom')"
        >
          <button class="py-4 px-16 rounded-lg bg-green-500 text-white hover:bg-gray-600 active:bg-pink-500">
            Submit
          </button>
        </div>
      </form>
    @else

      <div class="text-center py-8">
        <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4">
          Great! We'll be in touch in no time :)
        </h2>
      </div>
    @endunless
  </div>
</div>
