<x-layouts.master title="Edit Student">

    <x-slot name="breadcrumb">
        <x-breadcrumb :links="['Dashboard' => '/dashboard', 'Students' => route('students.index')]" current="Edit {{ $student->name }}" />
    </x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Form Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            {{-- Card Header --}}
            <div class="p-8 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-2xl font-bold">Edit Student</h2>
                <p class="text-sm text-slate-500 mt-1">Update the student profile information below.</p>
            </div>

            <form class="p-8 space-y-10" action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    {{-- Full Name --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Full Name</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="name" placeholder="e.g. Alexander Pierce" value="{{ old('name', $student->name) }}" />
                        @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email Address --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Email Address</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="email" name="email" placeholder="alex.p@university.edu" value="{{ old('email', $student->email) }}" />
                        @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Date of Birth --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Date of Birth</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}" />
                        @error('date_of_birth') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Gender --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Gender</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="gender" placeholder="e.g. Male" value="{{ old('gender', $student->gender) }}" />
                        @error('gender') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Address</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="address" placeholder="e.g. 123 Main St" value="{{ old('address', $student->address) }}" />
                        @error('address') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Major --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Major</label>
                        <select name="major" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all cursor-pointer">
                            <option value="" disabled>Select Major</option>
                            <option value="Computer Science"        {{ old('major', $student->major) == 'Computer Science'        ? 'selected' : '' }}>Computer Science</option>
                            <option value="Business Administration" {{ old('major', $student->major) == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                            <option value="Nursing"                 {{ old('major', $student->major) == 'Nursing'                 ? 'selected' : '' }}>Nursing</option>
                            <option value="Engineering"             {{ old('major', $student->major) == 'Engineering'             ? 'selected' : '' }}>Engineering</option>
                            <option value="Psychology"              {{ old('major', $student->major) == 'Psychology'              ? 'selected' : '' }}>Psychology</option>
                            <option value="Medicine"                {{ old('major', $student->major) == 'Medicine'                ? 'selected' : '' }}>Medicine</option>
                            <option value="Architecture"            {{ old('major', $student->major) == 'Architecture'            ? 'selected' : '' }}>Architecture</option>
                        </select>
                        @error('major') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Academic Year --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 block">Academic Year</label>
                        <input class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" type="text" name="academic_year" placeholder="e.g. 2023-2024" value="{{ old('academic_year', $student->academic_year) }}" />
                        @error('academic_year') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- Actions --}}
                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                    <a href="{{ route('students.show', $student->id) }}" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Cancel
                    </a>
                    <button class="px-8 py-2.5 bg-primary text-white rounded-lg text-sm font-bold shadow-sm hover:bg-primary/90 transition-all active:scale-95" type="submit">
                        Update Student
                    </button>
                </div>

            </form>
        </div>

        {{-- Info Cards --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-primary mb-3">
                    <span class="material-symbols-outlined text-lg">badge</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Student ID</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ $student->student_code ?? $student->student_id ?? 'N/A' }} — This ID cannot be changed.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 mb-3">
                    <span class="material-symbols-outlined text-lg">history</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Change Tracking</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">All changes are logged in the system activity history.</p>
            </div>
            <div class="p-5 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 mb-3">
                    <span class="material-symbols-outlined text-lg">assignment_late</span>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Required Fields</h4>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">All fields are required for a successful update.</p>
            </div>
        </div>

    </div>

</x-layouts.master>