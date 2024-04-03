<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900">



                    @php
                        $now = now();
                        $dure = !empty($data->dure) ? \Carbon\Carbon::parse($data->dure) : $now;
                        $difference = $now->diffInMinutes($dure);
                    @endphp

                    @if ($difference <= 0)
                        @if ($difference == 0)
                            <a href="{{ route('code.edit') }}">
                                <x-primary-button class="my-2">
                                    {{ __('Genere mon Code') }}
                                </x-primary-button>
                            </a>
                        @else
                            <a href="{{ route('code.regenere') }}">
                                <x-danger-button class="my-2">
                                    {{ __('Regenere un nouveau code') }}
                                </x-danger-button>
                            </a>
                        @endif
                    @else
                        @if (!$data)
                            <a href="{{ route('code.edit') }}">
                                <x-primary-button class="my-2">
                                    {{ __('Genere mon Code') }}
                                </x-primary-button>
                            </a>
                        @else
                            @if ($data->user_id && $data->user_id != Auth::user()->id)
                                <a href="{{ route('code.edit') }}">
                                    <x-primary-button class="my-2">
                                        {{ __('Genere mon Code') }}
                                    </x-primary-button>
                                </a>
                            @endif
                        @endif

                    @endif


                </div>
                <div class="p-6 text-gray-900">


                    <form action="{{ route('code.send') }}" method="post">
                        @csrf

                        <div>
                            <label class="text-lg text-gray-600 my-2 p-4" for="code">Code </label>
                            <input type="text" name="code" id="code"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                        </div>
                        <x-primary-button class="my-2">
                            {{ __('Verifier mon Code') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
