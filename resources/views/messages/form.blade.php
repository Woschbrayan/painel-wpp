<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight">Envio de Mensagens</h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('messages.send') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label>Instância</label>
                <input name="instance" class="w-full border p-2" placeholder="Ex: brayan" required />
            </div>

            <div class="mb-4">
                <label>Número</label>
                <input name="number" class="w-full border p-2" placeholder="Ex: 554191234567" required />
            </div>

            <div class="mb-4">
                <label>Tipo</label>
                <select name="type" id="type" class="w-full border p-2" required onchange="toggleFields()">
                    <option value="">-- Selecione --</option>
                    <option value="text">Texto</option>
                    <option value="image">Imagem</option>
                    <option value="video">Vídeo</option>
                    <option value="audio">Áudio</option>
                    <option value="doc">Documento</option>
                    <option value="presence">Presença</option>
                    <option value="seen">Marcar como Visto</option>
                </select>
            </div>

            <div class="mb-4" id="text-field">
                <label>Mensagem</label>
                <textarea name="message" class="w-full border p-2"></textarea>
            </div>

            <div class="mb-4 hidden" id="file-field">
                <label>Arquivo</label>
                <input type="file" name="file" class="w-full border p-2" />
            </div>

            <div class="mb-4 hidden" id="caption-field">
                <label>Legenda</label>
                <input type="text" name="caption" class="w-full border p-2" />
            </div>

            <div class="mb-4 hidden" id="view-once-field">
                <label><input type="checkbox" name="viewOnce" /> Visualização única</label>
            </div>

            <div class="mb-4 hidden" id="presence-fields">
                <label>Status de presença</label>
                <select name="status" class="w-full border p-2">
                    <option value="available">Online</option>
                    <option value="composing">Digitando</option>
                    <option value="recording">Gravando</option>
                    <option value="unavailable">Offline</option>
                </select>
                <label class="mt-2">Delay (ms)</label>
                <input type="number" name="delay" value="0" class="w-full border p-2" />
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Enviar Mensagem
            </button>
        </form>
    </div>

    <script>
        function toggleFields() {
            const type = document.getElementById('type').value;
            document.getElementById('text-field').classList.add('hidden');
            document.getElementById('file-field').classList.add('hidden');
            document.getElementById('caption-field').classList.add('hidden');
            document.getElementById('view-once-field').classList.add('hidden');
            document.getElementById('presence-fields').classList.add('hidden');

            if (type === 'text') {
                document.getElementById('text-field').classList.remove('hidden');
            } else if (['image', 'video', 'audio', 'doc'].includes(type)) {
                document.getElementById('file-field').classList.remove('hidden');
                document.getElementById('caption-field').classList.remove('hidden');
                document.getElementById('view-once-field').classList.remove('hidden');
            } else if (type === 'presence') {
                document.getElementById('presence-fields').classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
