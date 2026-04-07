<x-layouts.master title="Import Academic Records">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/welcome', 'Academic Scores' => route('academicrecords.index')]" current="Import" />
    </x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
                Import Academic Records
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">
                Select the subject and term, then upload your grade sheet. This will automatically calculate total scores.
            </p>
        </div>

        {{-- Import Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            <form action="{{ route('academicrecords.storeimport') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf

                <div class="p-8">

                    {{-- Context Selectors --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-6 bg-slate-50 dark:bg-slate-800/30 rounded-xl border border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Subject</label>
                            <select name="subject_id" class="w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-sm font-bold focus:ring-primary" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">
                                        {{ $subject->name }} — {{ $subject->major }} ({{ $subject->academic_year }} {{ $subject->semester }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Academic Year</label>
                            <select name="academic_year" class="w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-sm font-bold focus:ring-primary" required>
                                <option value="2025/2026">2025/2026</option>
                                <option value="2024/2025">2024/2025</option>
                                <option value="2023/2024">2023/2024</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Semester</label>
                            <select name="semester" class="w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-lg text-sm font-bold focus:ring-primary" required>
                                <option value="Semester 1">Semester 1</option>
                                <option value="Semester 2">Semester 2</option>
                            </select>
                        </div>
                    </div>

                    {{-- Instructions --}}
                    <div class="mb-8 p-4 rounded-lg bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30">
                        <h3 class="text-sm font-bold text-blue-900 dark:text-blue-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">info</span>
                            CSV Format Requirements
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                            Your CSV only needs the student code and the raw scores. The subject and semester are handled by your selection above.
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach(['student_code', 'attendance', 'quiz', 'midterm', 'final'] as $header)
                                <span class="px-2 py-1 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-mono font-bold">
                                    {{ $header }}
                                </span>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400 mt-3 italic">Total score is calculated automatically — do not include it in the CSV.</p>
                    </div>

                    {{-- Drop Zone --}}
                    <div
                        class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-12 flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all cursor-pointer group"
                        onclick="document.getElementById('fileInput').click()"
                    >
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-4xl">grade</span>
                        </div>
                        <h4 class="text-base font-bold text-slate-900 dark:text-slate-100 mb-1">
                            Drag and drop your Grade Sheet here
                        </h4>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">
                            CSV files up to 10MB
                        </p>
                        <button type="button" class="bg-slate-900 dark:bg-slate-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-slate-800 transition-all shadow-md active:scale-95">
                            Select File
                        </button>

                        <input type="file" name="file" id="fileInput" accept=".csv,.txt" class="hidden" onchange="showPreview(this)" />
                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm font-bold mt-3 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">error</span>
                            {{ $message }}
                        </p>
                    @enderror

                    {{-- File Preview --}}
                    <div id="filePreview" class="mt-6 hidden">
                        <div class="flex items-center gap-4 p-4 border border-primary/20 bg-primary/5 rounded-lg">
                            <span class="material-symbols-outlined text-primary">description</span>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-900 dark:text-white" id="fileName"></p>
                                <p class="text-xs text-slate-500" id="fileSize"></p>
                            </div>
                            <button type="button" onclick="clearFile()" class="size-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="px-8 py-5 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-4">
                    <a href="{{ route('academicrecords.index') }}" class="px-6 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 active:scale-95">
                        Process Scores
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        // noinspection JSUnresolvedReference
        function showPreview(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
                document.getElementById('filePreview').classList.remove('hidden');
            }
        }

        function clearFile() {
            document.getElementById('fileInput').value = '';
            document.getElementById('filePreview').classList.add('hidden');
        }
    </script>

</x-layouts.master>