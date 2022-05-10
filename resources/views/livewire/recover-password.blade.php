<div class="flex flex-col space-y-4" x-data="{ notificationSent: false }">
  <x-form.input title="Email or username" name="username" rounded-full="1" full-width="1" centered="1" type="email"/>

  <div class="py-4 flex justify-center text-sm" x-intersect="$el.classList.add('slide-in-bottom')">
    <span
        class="cursor-pointer text-green-500 font-normal"
        @click="$store.authMode = 'login'"
    >
      <u>Do you want to sign in instead?</u>
    </span>
  </div>

  <x-form.button
      title="Recover password"
      rounded-full="1"
      x-intersect="$el.classList.add('slide-in-bottom')"
      wire:click="submit"
      wire:loading.class="animate-pulse"
      x-key="recover-password-button"
  />
  <div class="pt-2 h-8 flex justify-center text-sm" x-show="$store.authMode == 'recover-password'">
    <span
        class="text-pink-800 font-normal"
        x-show="notificationSent"
        @recovery-email-has-been-sent.window="notificationSent = true"
        x-intersect="$el.classList.add('slide-in-left')"
    >
      If the username is registered, you will receive a recovery link by email.
    </span>
  </div>
</div>