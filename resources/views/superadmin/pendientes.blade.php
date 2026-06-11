<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black leading-tight text-blue-950">Aprobación de Administradores</h2>
                <p class="text-sm text-gray-600">Autoriza a nuevos administradores para que puedan crear pollas.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-blue-700 hover:text-blue-900">Volver al Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-md">
                <h3 class="mb-4 text-lg font-black text-gray-900">Administradores Pendientes</h3>

                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200">
                        <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                    </div>
                @endif

                @if($pendientes->isEmpty())
                    <p class="text-sm text-gray-600">No hay ningún administrador pendiente de aprobación.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Registro</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendientes as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d M Y - H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form method="POST" action="{{ route('superadmin.aprobar', $user) }}">
                                                @csrf
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-bold hover:underline">Aprobar Administrador</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
