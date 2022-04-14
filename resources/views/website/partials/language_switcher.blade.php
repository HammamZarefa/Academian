<div class="flex justify-center pt-8 sm:justify-start sm:pt-0 language">
        <nav class="btn-pluss-wrapper">
		<div class="icon"></div>
            <div href="#" class="btn-pluss">
            <ul>
                @foreach($available_locales as $locale_name => $available_locale)
                @if($available_locale === $current_locale)
                <li class="active`"><a href="language/{{$locale_name}}"> {{ $locale_name }}</a></li>
                @else
                <li><a href="{{route('language',$locale_name)}}"> {{ $locale_name }}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
        </nav>
</div>
