<div class="w-full bg-white" x-data>
  <div class="w-full md:w-2/3 pt-0 md:pt-16 pb-16 px-10 mx-auto">
    @unless($registered)
      <div class="text-center py-8">
        <h2
            class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4"
            x-intersect="$el.classList.add('slide-in-bottom')"
        >
          {{ __('open-your-store.tell-us-about-you') }}
        </h2>
      </div>
      <form class="grid grid-cols-2 gap-5" wire:submit.prevent="submit">
        <x-form.input title="{{ __('open-your-store.form.first-name') }}"/>
        <x-form.input title="{{ __('open-your-store.form.last-name') }}"/>
        <x-form.input title="{{ __('open-your-store.form.email') }}"/>
        <x-form.input title="{{ __('open-your-store.form.phone') }}"/>
        <x-form.input title="{{ __('open-your-store.form.address') }}" fullWidth="true"/>
        <x-form.input title="{{ __('open-your-store.form.company') }}"/>
        <x-form.input title="{{ __('open-your-store.form.position') }}"/>
        <x-form.text-area title="{{ __('open-your-store.form.tell-us-about-your-business') }}" name="about" fullWidth="true"/>
        <x-form.input title="{{ __('open-your-store.form.web-address') }}" name="website" fullWidth="true" textArea="true"/>
        <div
            class="col-span-2 flex justify-center"
            x-intersect="$el.classList.add('slide-in-bottom')"
        >
          <x-form.button/>
        </div>
      </form>
    @else

      <div class="text-center py-8">
        <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4">
          {{ __('open-your-store.form.success-message') }}
        </h2>
      </div>
    @endunless
  </div>
</div>
