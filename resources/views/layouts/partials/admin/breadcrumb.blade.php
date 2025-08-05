@if (count($breadcrumbs))
    <nav class="mb-4" aria-label="Breadcrumb">
        <ol class="flex flex-wrap text-sm text-slate-700">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    @if (!$loop->first)
                        <span class="mx-2 text-slate-400">/</span>
                    @endif
                    
                    @isset($item['route'])
                        <a href="{{$item['route']}}" class="opacity-50">
                        {{ $item['name'] }}
                        </a>
                    @else
                        {{$item['name']}}
                    @endisset
                </li>
            @endforeach
        </ol>
        @if (count($breadcrumbs)>=2)
            <h6 class="font-bold">
                {{end($breadcrumbs)['name']}}
            </h6>
        @endif
            
    </nav>
@endif