<button {{ $attributes }} @class([
    'py-4 px-16 bg-green-500 text-white hover:bg-gray-600 active:bg-pink-500 transition ease-in-out delay-50 duration-300',
    'rounded-lg' => ! ($roundedFull ?? false),
    'rounded-full' => ($roundedFull ?? true),
])>
  {{ $title ?? 'Submit' }}
</button>