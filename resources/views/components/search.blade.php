@props(['action', 'placeholder' => 'Search...'])

<form action="{{ $action }}" class="relative w-64 group" method="GET">
    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors text-xl">
        search
    </span>
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="{{ $placeholder }}"
        class="w-full bg-slate-100 dark:bg-slate-800 border-none rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-slate-400"
    />
</form>