<div class="relative bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
  <div class="absolute inset-0">
    <div class="bg-white h-1/3 sm:h-2/3"></div>
  </div>
  <div class="relative max-w-7xl flex items-center flex-col">
    <div class="text-center flex flex-col space-y-4 w-4/5">
      <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4">
        Who we are
      </h2>
      <div class="mx-auto py-6">
        <div class="h-1 bg-gray-500 w-20"></div>
      </div>
      <p class="text-md tracking-wide leading-8">
        We are a space for people who love design and are also conscious of the impact that they leave behind.
      </p>
      <p class="text-md tracking-wide leading-8">
        Atelier Home Design is the platform that makes interior design an easy and fun process. It provides users with a 3D design platform that makes everything — from envisioning the project to executing it in real life — a simple, fun, and useful process.
      </p>
      <p class="text-md tracking-wide leading-8">
        We make sure to provide only good quality products by providing a channel for independent designers and makers to reach you through their Atelier shops. These small brands do not mass-produce, they source their products ethically, and they’ll make sure your design is always one of a kind!
      </p>
    </div>

    <div class="grid grid-cols-3 gap-16 pt-16">
    @foreach($team as $member)
      <div>
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
