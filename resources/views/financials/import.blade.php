<x-layouts.master title="Import Financials">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Financials' => route('financials.index')]" current="Import" />
    </x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
                Import Financials
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">
                Manage your financial records by importing from a CSV file.
            </p>
        </div>

        {{-- Import Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            <div class="p-8">

                {{-- Instructions --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-2">Instructions</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                        Please ensure your CSV file follows the required format. The first row must contain the following exact headers:
                        <span class="inline-flex items-center px-2 py-0.5 mt-2 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-mono">
                            email, total_fees, amount_paid, payment_status, payment_date
                        </span>.
                        Maximum file size is 10MB.
                    </p>
                </div>

                {{-- Upload Form --}}
                <form action="{{ route('financials.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf

                    {{-- Drop Zone --}}
                    <div
                        class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-12 flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer group"
                        onclick="document.getElementById('fileInput').click()"
                    >
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-primary text-4xl">csv</span>
                        </div>
                        <h4 class="text-base font-semibold text-slate-900 dark:text-slate-100 mb-1">
                            Drag and drop your CSV file here
                        </h4>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">
                            or search for the file on your computer
                        </p>
                        <button
                            type="button"
                            class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20"
                        >
                            Choose File
                        </button>

                        <input
                            type="file"
                            name="file"
                            id="fileInput"
                            accept=".csv,.xlsx,.xls"
                            class="hidden"
                        />
                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                    @enderror

                    <div id="filePreview" class="mt-6 hidden">
                        <div class="flex items-center gap-4 p-4 border border-slate-200 dark:border-slate-700 rounded-lg">
                            <span class="material-symbols-outlined text-primary">description</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium" id="fileName"></p>
                                <p class="text-xs text-slate-500" id="fileSize"></p>
                            </div>
                            <button type="button" onclick="clearFile()" class="text-slate-400 hover:text-red-500">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>

            {{-- Actions --}}
            <div class="px-8 py-5 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-4">
                <a href="{{ route('financials.index') }}" class="px-6 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors">
                    Cancel
                </a>
                <button
                    type="submit"
                    form="importForm"
                    class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20"
                >
                    Upload and Import
                </button>
            </div>

        </div>

        <div class="mt-8 flex items-center justify-center gap-8">
            <a href="#" class="flex items-center gap-2 text-sm text-primary font-medium hover:underline">
                <span class="material-symbols-outlined text-lg">download</span>
                Download CSV Template
            </a>
            <a href="#" class="flex items-center gap-2 text-sm text-primary font-medium hover:underline">
                <span class="material-symbols-outlined text-lg">help_outline</span>
                View Import Guide
            </a>
        </div>

    </div>

    <script>
        const fileInput   = document.getElementById('fileInput');
        const filePreview = document.getElementById('filePreview');
        const fileName    = document.getElementById('fileName');
        const fileSize    = document.getElementById('fileSize');
        const dropZone    = document.querySelector('.border-dashed');

        function showFile(file) {
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
            filePreview.classList.remove('hidden');
        }

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) showFile(this.files[0]);
        });

        function clearFile() {
            fileInput.value = '';
            filePreview.classList.add('hidden');
        }

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary', 'bg-primary/5');
        });

        dropZone.addEventListener('dragleave', function() {
            this.classList.remove('border-primary', 'bg-primary/5');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary', 'bg-primary/5');
            const file = e.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                showFile(file);
            }
        });
    </script>

</x-layouts.master>