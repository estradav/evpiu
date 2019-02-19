<ul class="navbar-nav flex-column">
    <li class="nav-divider">
        Menu
    </li>

    @foreach ($items as $item)
        @php
            $isActive = null;
            $icon = null;

            // Check if link is current
            if (url($item->link()) == url()->current()){
                $isActive = 'active';
            }

            // Set Icon
            $icon = '<i class="' . $item->icon_class . '"></i>';
        @endphp

        <li class="nav-item">
            @if ($item->children->isEmpty())
                <a class="nav-link {{ $isActive }}" href="{{ url($item->link()) }}" target="{{ $item->target }}">
                    {!! $icon !!}{{ $item->title }}
                </a>
            @else
                <a class="nav-link {{ $isActive }}" href="{{ url($item->link()) }}" data-toggle="collapse" aria-expanded="false" data-target="#submenu-{{ $item->id }}" aria-controls="submenu-{{ $item->id }}">
                    {!! $icon !!}{{ $item->title }}
                </a>
                <div id="submenu-{{ $item->id }}" class="collapse submenu">
                    <ul class="nav flex-column">
                        @include('layouts.sidebar_items', ['items' => $item->children])
                    </ul>
                </div>
            @endif
        </li>
    @endforeach
</ul>
