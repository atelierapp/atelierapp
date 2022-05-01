<div class="flex flex-col space-y-4" x-data="{ invalidSignUp: false, field: '' }">
  <x-form.input name="first_name" title="Name" rounded-full="1" full-width="1" centered="1" type="text"/>
  <x-form.input title="Email" rounded-full="1" full-width="1" centered="1" type="email"/>
  <x-form.input title="Username" rounded-full="1" full-width="1" centered="1" type="text"/>
  <x-form.input title="Password" rounded-full="1" full-width="1" centered="1" type="password"/>
  <x-form.input name="password_confirmation" title="Password Confirmation" rounded-full="1" full-width="1" centered="1" type="password"/>

  <div class="py-4 flex justify-center text-sm" x-intersect="$el.classList.add('slide-in-bottom')">
    <span
        class="cursor-pointer text-green-500 font-normal"
        @click="$store.authMode = 'login'"
    >
      <u>Do you have an account already?</u>
    </span>
  </div>

  <x-form.button
      title="Create account"
      rounded-full="1"
      x-intersect="$el.classList.add('slide-in-bottom')"
      wire:click="submit"
      wire:loading.class="animate-pulse"
      x-show="$store.authMode === 'register'"
      x-key="register-button"
  />
  <div class="pt-2 h-8 flex justify-center text-sm" x-show="$store.authMode === 'register'">
    <p
        class="text-pink-800 font-normal"
        x-show="invalidSignUp"
        @existent-user.window="invalidSignUp = true; field = $event.detail.field"
        @new-user.window="invalidSignUp = ! invalidSignUp"
        x-intersect="$el.classList.add('slide-in-left')"
    >
      Then <span x-text="field"></span> is already taken.
    </p>
  </div>
</div>
