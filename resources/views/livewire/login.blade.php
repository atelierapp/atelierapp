<div class="flex flex-col space-y-4" x-data="{ invalidCredentials: false }">
  <x-form.input title="Email" rounded-full="1" full-width="1" centered="1" type="email"/>
  <x-form.input title="Password" rounded-full="1" full-width="1" centered="1" type="password"/>

  <div class="py-4 flex justify-center text-sm" x-intersect="$el.classList.add('slide-in-bottom')">
    <span
        class="cursor-pointer text-green-500 font-normal"
        @click="$store.authMode = 'recover-password'"
    >
      <u>I forgot my password</u>
    </span>
  </div>

  <x-form.button
      title="Login"
      rounded-full="1"
      x-intersect="$el.classList.add('slide-in-bottom')"
      wire:click="submit"
      wire:loading.class="animate-pulse"
      x-key="register-button"
  />
  <div class="pt-2 h-8 flex justify-center text-sm" x-show="$store.authMode == 'login'">
    <span
        class="text-pink-800 font-normal"
        x-show="invalidCredentials"
        @invalid-credentials.window="invalidCredentials = true"
        x-intersect="$el.classList.add('slide-in-left')"
    >
      Incorrect credentials. Please, try again.
    </span>
  </div>
</div>