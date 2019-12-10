@foreach ($items as $item)
    <li class="nav-item">
        @if ($item->children->isEmpty())
            <a class="nav-link" href="{{ url($item->link()) }}" target="{{ $item->target }}">
                {{ $item->title }}
            </a>
        @else
            <a class="nav-link" href="{{ url($item->link()) }}" data-toggle="collapse" aria-expanded="false" data-target="#submenu-{{ $item->id }}" aria-controls="submenu-{{ $item->id }}">
                {{ $item->title }}
            </a>
            <div id="submenu-{{ $item->id }}" class="collapse submenu">
                <ul class="nav flex-column">
                    @include('layouts.sidebar_items', ['items' => $item->children])
                </ul>
            </div>
        @endif
    </li>
@endforeach
