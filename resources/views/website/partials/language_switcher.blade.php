<div class="flex justify-center pt-8 sm:justify-start sm:pt-0 language">
        {{--@foreach($available_locales as $locale_name => $available_locale)--}}
            {{--@if($available_locale === 'ar')--}}
            {{--<a style="padding: 0 3px;" href="{{route('language',$available_locale)}}">--}}
            {{--<i class="fas fa-globe"></i> @lang('AR') --}}
            {{--</a>--}}
            {{--@endif--}}
             @if($current_locale === 'ar')
                <a onclick="localStorage.setItem('locale', 'en');" style="padding: 0 3px;" href="{{route('language','en')}}"> <i class="fas fa-globe"></i> EN</a>
                @else
                <a onclick="localStorage.setItem('locale', 'ar');" style="padding: 0 3px;" href="{{route('language','ar')}}"><i class="fas fa-globe"> </i> AR</a>
                @endif
        {{--@endforeach -->--}}
</div>