<div class="col-md-12 mb-4">
   <div class="d-flex  align-items-center">
      <div class="seclector">
         <div style="font-weight: bold;">
         <div class="current">
            English
         </div>
      </div>
         <i class="fas fa-angle-down"></i>
         <ul class="option change-lang">
            @foreach(Config::get('app.available_locales') as $lang=> $key)
               <li data-lang="{{$key}}">  {{$lang}}</li>
            @endforeach
         </ul>
      </div>
   </div>
</div>