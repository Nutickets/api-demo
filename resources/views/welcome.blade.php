<!doctype html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

</head>
<body>

  @if (!empty(session()->get('success')))
    <div class="relative bg-indigo-600">
      <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
        <div class="pr-16 sm:text-center sm:px-16">
          <p class="font-medium text-white">
            <span class="md:hidden">
              {{ session()->get('success') }}
            </span>
            <span class="hidden md:inline">
              {{ session()->get('success') }}
            </span>
          </p>
        </div>
        <div class="absolute inset-y-0 right-0 pt-1 pr-1 flex items-start sm:pt-1 sm:pr-2 sm:items-start">
          <button type="button" class="flex p-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white">
            <span class="sr-only">Dismiss</span>
            <!-- Heroicon name: outline/x -->
            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  @endif

@foreach ($data as $event)
  <div class="bg-white pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
    <div class="relative max-w-lg mx-auto divide-y-2 divide-gray-200 lg:max-w-7xl">
      <div>
        <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">
          {{ $event['event']['name'] }}
        </h2>
        <div class="mt-3 sm:mt-4 lg:grid lg:grid-cols-2 lg:gap-5 lg:items-center">
          <p class="text-xl text-gray-500">
            {{ $event['event']['venue']['name'] }}
          </p>
        </div>
      </div>
      <div class="mt-6 pt-10 grid gap-16 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12">
        @foreach ($event['tickets'] as $ticket)
          <div>
            <p class="text-sm text-gray-500">
              <time datetime="2020-03-16">Prices include fees & tax</time>
            </p>
            <a href="#" class="mt-2 block">
              <p class="text-xl font-semibold text-gray-900">
                {{ $ticket['name'] }}
              </p>
              <p class="mt-3 text-base text-gray-500">
                {!! $ticket['description'] !!}
              </p>
            </a>
            <div class="mt-3">
              <a href="/buy/{{ $ticket['id'] }}" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">
                Buy Now ({{ $ticket['currencySymbol'] }}{{ $ticket['totalPrice'] / 100 }})
              </a>
            </div>
          </div>
          @endforeach

          @empty($event['tickets'])
          <p>No tickets available.</p>
          @endempty
      </div>
    </div>
  </div>
@endforeach

</body>
</html>