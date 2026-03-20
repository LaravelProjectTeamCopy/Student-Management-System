@props(['links' => [], 'current' => ''])

<div class="flex items-center gap-2 text-sm font-medium text-slate-500">
    @foreach($links as $label => $url)
        <a href="{{ $url }}" class="hover:text-primary transition-colors">{{ $label }}</a>
        <span class="text-slate-300">/</span>
    @endforeach
    <span class="text-slate-900 dark:text-white">{{ $current }}</span>
</div>