<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="font-bold text-2xl my-2">
                        2 FA Authentication
                    </div>

                    @if (session('status') == 'two-factor-authentication-enabled')
                        <div class="mb-4 font-medium text-sm">
                            Finisser la configuration 2 facteur
                        </div>
                    @endif

                    @if (session('status') == 'two-factor-authentication-disabled')
                        <div class="mb-4 font-medium text-sm">
                            double auth non active
                        </div>
                    @endif

                    @if (session('status') == 'two-factor-authentication-confirmed')
                        <div class="mb-4 font-medium text-sm">
                            double auth activer
                        </div>
                    @endif

                    {{-- qr --}}

                    @if (auth()->user()->two_factor_secret)
                        <div class="py-5">
                            {!! auth()->user()->twoFactorQrcodesvg() !!}
                        </div>
                    @endif

                    {{-- btn 2 AF --}}


                    @if (!auth()->user()->two_factor_secret)
                        <form action="/user/two-factor-authentication" method="post">
                            @csrf
                            <x-primary-button class="my-2">
                                {{ __('Enabled') }}
                            </x-primary-button>
                        </form>
                    @else
                        <form action="/user/two-factor-authentication" method="post">
                            @csrf
                            @method('delete')
                            <x-danger-button class="my-2">
                                {{ __('Disabled') }}
                            </x-danger-button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
