<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-8 sm:px-10">
            <div class="flex items-center justify-center mb-6">
                <div class="rounded-full bg-blue-600 w-12 h-12 flex items-center justify-center text-white font-bold">PN
                </div>
            </div>

            <h2 class="text-center text-2xl font-extrabold text-gray-900 dark:text-gray-100 mb-2">Inicia sesión</h2>
            <p class="text-center text-sm text-gray-500 dark:text-gray-300 mb-6">Accede a tu cuenta para administrar
                notas y perfiles</p>



            <form wire:submit="login" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Correo
                        electrónico</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="email" id="email" wire:model="email"
                            class="appearance-none block w-full px-3 py-2 border border-gray-200 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                            required autofocus>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Contraseña</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="password" id="password" wire:model="password"
                            class="appearance-none block w-full px-3 py-2 border border-gray-200 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                            required>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ }}</p>
                    @enderror
                </div>





                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Entrar
                    </button>
                </div>
            </form>


        </div>

        {{-- <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-center text-sm text-gray-600 dark:text-gray-300">
            No tienes cuenta? <a href="#" class="text-blue-600 font-medium hover:underline">Regístrate</a>
        </div> --}}
    </div>
</div>
